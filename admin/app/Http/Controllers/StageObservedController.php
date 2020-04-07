<?php

namespace App\Http\Controllers;

use App\Models\ServiceStage;
use App\Models\StageObserved;
use App\Models\Task;
use App\Models\TaskObserved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageObservedController extends Controller
{
    public function observations( Request $request ) {
        $observations = [];
        $service = $request->service ? $request->service : 0;

        $records = ServiceStage::whereNotIn( 'status', [0, 2] )
            ->where( 'services_id', $service )
            ->get();

        foreach ( $records as $record ) {
            $observeds = $record->observeds->whereNotIn( 'status', [0, 2] )
                ->sortByDesc( 'created_at' );

            foreach ( $observeds as $observed ) {
                $observations[] = [
                    'id' => $observed->id,
                    'name' => $observed->name,
                    'description' => $observed->description,
                    'reply' => $observed->reply,
                    'replyDate' => $this->getDateComplete( $observed->date_reply ),
                    'status' => $observed->status,
                    'statusName' => $this->getStatus( 'observation', $observed->status ),
                    'created' => $this->getDateComplete( $observed->created_at ),
                    'stage' => $record->description,
                    'code' => $record->code,
                    'tasks' => [],
                    'replyLong' => false
                ];
            }
        }

        $observations = $this->orderArraybyColumn( $observations, 'created', 'desc' );

        return response()->json([
            'status' => true,
            'observations' => $observations
        ], 200 );
    }

    public function storeReply( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación.'
        ];

        $observed = $request->id ? $request->id : 0;
        $typeReply = $request->typeReply ? (int)$request->typeReply : 0;
        $tasksSelecteds = $request->tasksSelected ? $request->tasksSelected : [];

        $stageObserved = StageObserved::find( $observed );

        if( $stageObserved && $stageObserved->status === 1 && ( ( count( $tasksSelecteds ) > 0 && $typeReply === 3 ) || $typeReply === 4  ) ) {
            $stageObserved->reply = $request->description;
            $stageObserved->date_reply = date( 'Y-m-d H:i:s' );
            $stageObserved->status = $request->typeReply;
            $stageObserved->user_reply = Auth::user()->id;
            if( $stageObserved->save() ) {

                $stage = ServiceStage::find( $stageObserved->service_stages_id );
                if( $stage ) {
                    $stageId = $stage->id;
                    $stage->date_last_observed_reply = date('Y-m-d');

                    if( $typeReply === 3 && $stage->save() ) {
                        $insertTaskObs = [];
                        foreach ( $tasksSelecteds as $tasksSelected ) {
                            $insertTaskObs[] = [
                                'tasks_id' => $tasksSelected,
                                'stage_observeds_id' => $stageId,
                                'created_at' => date('Y-m-d H:i:s' ),
                                'updated_at' => date('Y-m-d H:i:s' )
                            ];
                        }

                        Task::where( 'service_stages_id', $stageId )
                            ->whereIn( 'id', $tasksSelecteds )
                            ->whereNotIn( 'status', [0,2] )
                            ->update(['status' => 5]);

                        if( count( $insertTaskObs ) > 0 ) {
                            TaskObserved::insert( $insertTaskObs );
                        }
                        ServiceStage::setStateStage( $stageId );
                    }

                    if( $typeReply === 4 ) {
                        if( $stage->save() )  {
                            Task::updatedAllTasksByStage( $stage->service_stages_id, 6 );
                            ServiceStage::setStateStage( $stage->service_stages_id );
                        }
                    }
                }

                $this->sendMailReply( $stage, $stageObserved );

                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response, 200 );
    }

    private function sendMailReply( ServiceStage $stage, StageObserved $stageObserved ) {

        $service = $stage->service;
        if( $service ) {
            $serviceRequest = $service->serviceRequest;
            $customer = $serviceRequest->customer;
            $customerData = $this->getDataCustomer( $customer );

            if( $customerData['email'] ) {
                $template = 'mailV2.replyObserved';
                $title = 'Respuesta de observación "' . $stage->description . '"';
                $vars = [
                    'customerName' => $customerData['name'],
                    'stage' => $stage->description,
                    'observation' => $stageObserved->description,
                    'reply' => $stageObserved->reply,
                    'typeReply' => $stageObserved->status,
                    'subject' => $title
                ];

                $this->sendMail( $customerData['email'], $title, $template, $vars );

            }

        }
        return true;
    }
}
