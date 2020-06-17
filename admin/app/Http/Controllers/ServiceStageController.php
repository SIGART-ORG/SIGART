<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\StageObserved;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\ServiceStage;
use Illuminate\Support\Str;

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

            $task = new Task();
            $task->service_stages_id = $serviceStage->id;
            $task->code = $task::generateCorrelative( $serviceStage->id );
            $task->name = Str::substr( $request->name, 0, 20 );
            $task->description = $request->name;
            $task->date_start_prog = $start;
            $task->date_end_prog = $end;
            $task->save();

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

    public function getTaskById( Request $request ) {
        $observedId = $request->observed ? $request->observed : 0;

        $observed = StageObserved::find( $observedId );

        if( $observed ) {
            $stageId = $observed->service_stages_id;
            $records = Task::where('service_stages_id', $stageId)
                ->whereNotIn('status', [0, 2])
                ->orderBy('code', 'asc')
                ->get();

            $tasks = [];

            foreach ($records as $record) {
                $row = new \stdClass();
                $row->id = $record->id;
                $row->name = $record->name;
                $row->code = $record->code;
                $row->status = $this->getStatus('task', $record->status);
                $tasks[] = $row;
            }
        }

        return response()->json([
            'status' => true,
            'tasks'  => $tasks
        ], 200 );
    }

    public function deleteStage( ServiceStage $service_stage ) {
        $service_stage->status = 2;
        if( $service_stage->save() ) {
            Task::where( 'service_stages_id', $service_stage->id )->where( 'status', '!=', 2 )->update(['status' => 2]);
        }

        return response()->json([
            'status' => true
        ], 200);
    }
}
