<?php

namespace App\Http\Controllers;

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
            $row->name = $stage->name;
            $row->start = date( 'd/m/Y', strtotime( $stage->date_start ) );
            $row->end = date( 'd/m/Y', strtotime( $stage->date_end ) );
            $row->status = $stage->status;

            $data[] = $row;
        }
        return response()->json([
            'status' => true,
            'stages' => $data
        ]);
    }

    public function store( Request $request ) {

        $start = date( 'Y-m-d', strtotime( $request->start ) );
        $end = date( 'Y-m-d', strtotime( $request->end ) );

        $serviceStage = new ServiceStage();
        $serviceStage->services_id = $request->service;
        $serviceStage->name = $request->name;
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
}
