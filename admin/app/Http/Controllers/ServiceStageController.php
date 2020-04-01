<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceStage;

class ServiceStageController extends Controller
{
    public function index( Request $request ) {
        $id = ! empty( $request->id ) ? $request->id : 0;
        $search = ! empty( $request->search ) ? $request->search : '';
        $serviceStage = new ServiceStage();
        $stages = $serviceStage->getStages( $id, $search );

        $data = [];

        foreach ( $stages as $stage ) {
            $row = new \stdClass();
            $row->id = $stage->id;
            $row->code = $stage->code;
            $row->description = $stage->description ? $stage->description : $stage->name;
            $row->name = $stage->name;
            $row->status = $stage->status;
            $row->tasks = $stage->tasks->whereNotIn( 'status', [0,2] )->count();

            $data[] = $row;
        }
        return response()->json([
            'status' => true,
            'stages' => $data
        ]);
    }

    public function store( Request $request ) {

        $start = date( 'Y-m-d' );
        $end = date( 'Y-m-d' );

        $serviceStage = new ServiceStage();
        $serviceStage->services_id = $request->service;
        $serviceStage->code = $serviceStage::generateCorrelative( $request->service );
        $serviceStage->name = $request->name;
        $serviceStage->description = $request->name;
        $serviceStage->date_start = $start;
        $serviceStage->date_end = $end;

        if( $serviceStage->save() ) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }

    public function update( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación.'
        ];

        $serviceStage = ServiceStage::find( $request->id );
        if( $serviceStage ) {
            $serviceStage->name = $request->name;
            $serviceStage->description = $request->name;
            if( $serviceStage->code === '' ) {
                $serviceStage->code = $serviceStage->updateCorrelative( $serviceStage->services_id );
            }
            if( $serviceStage->save() ) {
                $response = [
                    'status' => true,
                    'msg' => 'OK.'
                ];
            }
        }
        return response()->json( $response, 200 );
    }

    public function charge( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];

        $id = ! empty( $request->id ) ? $request->id : 0;

        $service = Service::find( $id );
        if( $service ) {
            $serviceRequest = $service->serviceRequest;
            if( $serviceRequest ) {
                $quotation = $serviceRequest->salesQuotations->sortByDesc( 'created_at' )->first();
                if( $quotation ) {
                    $referenceTerm = $quotation->referenceterms->sortByDesc( 'created_at' )->first();
                    if( $referenceTerm ) {
                        $resp = ServiceStage::generateStageByReference( $referenceTerm, $id );
                        if( $resp ) {
                            $response['status'] = true;
                            $response['msg'] = 'Ok.';
                        }
                    }
                }
            }
        }

        return response()->json( $response, 200 );
    }
}
