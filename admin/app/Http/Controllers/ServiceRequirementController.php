<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequirement;
use App\Models\ServiceRequirementDetail;
use Illuminate\Http\Request;
use function foo\func;

class ServiceRequirementController extends Controller
{
    public function load( Request $request ) {
        $id = $request->id ? $request->id : 0;
        $stage = $request->stage ? $request->stage : 0;

        $records = ServiceRequirement::where( function( $q ) use( $id ) {
            if( $id > 0 ) {
                $q->where( 'services_id', $id  );
            }
        })->where( function ( $q ) use ( $stage ) {
            if( $stage > 0 ) {
                $q->where( 'stage', $stage );
            }
        })
            ->whereNotIn( 'status', [0,2] )
            ->orderBy( 'created_at', 'desc' )
            ->paginate( self::PAGINATE );

        $requirements = [];

        foreach ( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->name = $record->name;
            $row->stage = $record->stage;
            $row->items = $record->serviceRequirementDetails->whereNotIn( 'status', [0, 2])->count();
            $row->register = $this->getDateComplete( $record->created_at );
            $row->service = new \StdClass();
            $row->service->id = $record->service->id;
            $row->service->document = $record->service->serial_doc . '-' .$record->service->number_doc;

            $requirements[] = $row;
        }

        return response()->json([
            'status' => true,
            'requirements' => $requirements,
            'pagination' => [
                'total' => $records->total(),
                'current_page' => $records->currentPage(),
                'per_page' => $records->perPage(),
                'last_page' => $records->lastPage(),
                'from' => $records->firstItem(),
                'to' => $records->lastItem()
            ],
        ], 200);
    }

    public function store( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];

        $service = $request->service ? $request->service : 0;
        $details = $request->details ? $request->details : [];

        if( $service > 0 && count( $details ) > 0 ) {
            $req = new ServiceRequirement();
            $req->services_id = $service;
            $req->name = 'REQ' . date( 'Ymd' ) . '-' . $req->count();

            if( $req->save() ) {

                foreach( $details as $detail ) {
                    $reqDet = new ServiceRequirementDetail();
                    $reqDet->service_requirements_id = $req->id;
                    $reqDet->presentation_id = $detail['id'];
                    $reqDet->quantity  = $detail['quantity'];
                    $reqDet->save();
                }
            }

            $response['status'] = true;
            $response['msg'] = 'OK.';
        }

        return response()->json( $response, 200 );
    }

    public function send( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];
        $id = $request->id;

        $req = ServiceRequirement::find( $id );
        if( $req && $req->stage === 0 ) {
            $req->stage = 1;

            if( $req->save() ) {
                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response, 200 );
    }
}
