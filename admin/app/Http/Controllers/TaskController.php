<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\AssignedWorker;
use App\Models\ServiceLog;
use App\Models\ServiceStage;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function head( Request $request ) {
        $serviceStage = ServiceStage::findOrFail( $request->stage );

        $service = $serviceStage->service;
        $serviceRequest = $service->serviceRequest;
        $customer = $serviceRequest->customer;

        $response = [
            'status' => true,
            'head' => [
                'service' => [
                    'id' =>  $service->id,
                    'document' => ( ! empty( $service->serial_doc ) && ! empty( $service->number_doc ) ) ? $service->serial_doc . ' ' . $service->number_doc : '',
                    'date' => date( 'd/m/Y', strtotime( $service->date_reg ) ),
                    'attachment' => $serviceRequest->attachment,
                    'status' => $service->status
                ],
                'stage' => [
                    'id' => $serviceStage->id,
                    'name' => $serviceStage->name,
                    'start' => date( 'd/m/Y', strtotime( $serviceStage->date_start ) ),
                    'end' => date( 'd/m/Y', strtotime( $serviceStage->date_end ) ),
                    'status' => $serviceStage->status
                ],
                'provider' => [
                    'id' => $customer->id,
                    'name' => $customer->name . ( $customer->type_person === 1 ? ' '. $customer->lastname : '' ),
                    'document' => $customer->typeDocument->name . ': ' . $customer->document
                ]
            ]
        ];

        return response()->json( $response );
    }

    public function index( Request $request ) {
        $stage = $request->stage ? $request->stage : 0;
        $search = $request->search ? $request->search : '';

        $taskClass = new Task();
        $tasks = $taskClass->getTasks( $stage, $search );

        $data = [];
        $count = 0;
        $status = [
            1 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0
        ];

        foreach ( $tasks as $task ) {
            $row = new \stdClass();
            $row->id = $task->id;
            $row->name = $task->name;
            $row->description = $task->description;
            $row->descriptionShort = Str::words( $task->description, 10, '...' );
            $row->users = $task->AssignedWorkers->where( 'status', 1 )->count();
            $row->isObs = ! empty( $task->observation ) ? true : false;
            $row->status = $task->status;

            $data[] = $row;

            if( $row->status !== 0 ) {
                $status[$row->status]++;
            }

            $count++;
        }

        $summary = $this->summary( $count, $status );

        return response()->json([
            'status' => true,
            'tasks' => $data,
            'summary' => $summary
        ]);
    }

    private function summary( $total, $status ) {
        $summary = [
            'total' => $total,
            'details' => []
        ];

        foreach ( $status as $idx => $item ) {

            $head = $this->headSummary( $idx );

            $row = new \stdClass();
            $row->id = $idx;
            $row->label = $head['label'];
            $row->class = $head['class'];
            $row->porc = $total > 0 ? round( ( 100 * $item ) / $total, 2 ) : 0;
            $row->total = $item;

            $summary['details'][] = $row;
        }

        return $summary;
    }

    private function headSummary( $status ) {
        switch ( $status ) {
            case 1:
                $label = 'Por iniciar';
                $class = 'primary';
                break;
            case 3:
                $label = 'En proceso';
                $class = 'info';
                break;
            case 4:
                $label = 'Terminado';
                $class = 'success';
                break;
            case 5:
                $label = 'Observado';
                $class = 'warning';
                break;
            case 6:
                $label = 'Cerrado';
                $class = 'danger';
                break;
            default:
                $label = '';
                $class = '';
        }

        return [
            'label' => $label,
            'class' => $class
        ];
    }

    public function store( Request $request ) {

        $start = date( 'Y-m-d H:i:s' );
        $end = date( 'Y-m-d H:i:s' );

        $task = new Task();
        $task->service_stages_id = $request->stage;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->date_start_prog = $start;
        $task->date_end_prog = $end;
        if( $task->save() ) {
            foreach ( $request->users as $user ) {
                $aWorker = new AssignedWorker();
                $aWorker->tasks_id = $task->id;
                $aWorker->users_id = $user['id'];
                $aWorker->user_in_charge = '0';
                $aWorker->save();
            }
        }
        $this->logAdmin( 'Agregó nueva tarea ' . $task->name );

        $serviceLog = new ServiceLog();
        $serviceLog->registerLog( $request->service, 'Se registró nueva tarea ' . $task->name, 3);
        return response()->json([
            'status' => true
        ]);

    }

    public function getWorkers( Request $request ) {
        $task = $request->task ? $request->task : 0;

        $workers = AssignedWorker::where( 'tasks_id', $task )
            ->where( 'status', 1 )
            ->get();

        $data = [];

        foreach ( $workers as $worker ) {
            $row = new \stdClass();
            $row->id = $worker->user->id;
            $row->text = $worker->user->name . ' ' . $worker->user->last_name;

            $data[] = $row;
        }

        return response()->json([
            'status' => true,
            'workers' => $data
        ]);
    }

    public function update( Request $request ) {
        $id = $request->id ? $request->id : 0;

        $start = date( 'Y-m-d H:i:s' );
        $end = date( 'Y-m-d H:i:s' );

        $task = Task::findOrFail( $id );
        $task->service_stages_id = $request->stage;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->date_start_prog = $start;
        $task->date_end_prog = $end;
        if( $task->save() ) {

            AssignedWorker::where( 'tasks_id', $task->id )
                ->update(['status' => 2]);

            foreach ( $request->users as $user ) {

                AssignedWorker::updateOrCreate(
                    ['tasks_id' => $task->id, 'users_id' => $user['id']],
                    ['user_in_charge' => '0', 'status' => 1]
                );

            }
        }

        $this->logAdmin( 'Editó la tarea ' . $task->name );

        $serviceLog = new ServiceLog();
        $serviceLog->registerLog( $request->service, 'Se editó nueva tarea ' . $task->name, 3);
        return response()->json([
            'status' => true
        ]);
    }

    public function delete( Request $request ) {
        $task = Task::findOrFail( $request->task );
        $task->status = 2;
        $task->save();

        $this->logAdmin( 'Eliminó la tarea ' . $task->name );

        $serviceStage = ServiceStage::findOrFail( $task->service_stages_id );

        $serviceLog = new ServiceLog();
        $serviceLog->registerLog( $serviceStage->services_id, 'Eliminó la tarea ' . $task->name, 3);

        return response()->json([
            'status' => true
        ]);
    }

    public function show() {

    }

    public function boardDashboard() {
        $breadcrumb = [
            [
                'name' => 'Tablero',
                'url' => route( 'service.board' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'board'
        ]);
    }

    public function boardData() {
        $user = Auth()->user()->id;

        $assignedTask = AssignedWorker::whereNotIn( 'status', [0,2] )
            ->where( 'users_id', $user )
            ->get();



        dd( $assignedTask );
        return response()->json([
            'status' => true,
        ]);
    }

    public function changeColumn( Request $request ) {
        $column = $request->column ? $request->column : '';
        $id = $request->task ? $request->task : 0;
        $idColumn = 0;

        $response = [
            'status' => false,
            'msg' => 'Nose pudo realizar la operación.'
        ];

        switch ( $column ) {
            case 'start': $idColumn = 1; break;
            case 'inProcess': $idColumn = 3; break;
            case 'finished': $idColumn = 4; break;
            case 'observed': $idColumn = 5; break;
            case 'finalized': $idColumn = 6; break;
            default: $response['msg'] = 'No se encuentra la columna.';
        }

        if( $id > 0 && $idColumn > 0 ) {
            $task = Task::find( $id );
            $task->status = $idColumn;
            if( $task->save() ) {

                ServiceStage::setStateStage( $task-> service_stages_id );

                $response['status'] = true;
                $response['msg'] = 'Ok.';
            }
        }

        return response()->json( $response );
    }
}
