<?php

namespace App\Http\Controllers;

use App\Models\ServiceStage;
use App\Models\Task;
use App\Models\TaskObserved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskObservedController extends Controller
{
    public function storeReply( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación.'
        ];

        $observed = $request->id ? $request->id : 0;

        $taskObserved = TaskObserved::find( $observed );
        if( $taskObserved && $taskObserved->status === 1 ) {
            $taskObserved->reply = $request->description;
            $taskObserved->date_reply = date( 'Y-m-d H:i:s' );
            $taskObserved->status = $request->typeReply;
            $taskObserved->user_reply = Auth::user()->id;
            if( $taskObserved->save() ) {

                if( (int)$request->typeReply === 3 ) {
                    $task = Task::find( $taskObserved->tasks_id );
                    $task->status = 3;
                    if( $task->save() ) {
                        ServiceStage::setStateStage( $task->service_stages_id );
                    }
                }

                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response, 200 );
    }
}
