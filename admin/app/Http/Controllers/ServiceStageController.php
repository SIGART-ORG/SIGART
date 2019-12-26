<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceStage;

class ServiceStageController extends Controller
{
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
