<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Models\AssignedWorker;
use App\Models\Service;
use App\User;
use Illuminate\Http\Request;
use App\Access;

class PanelController extends Controller
{
    protected $_role;
    protected $_moduleDB = 'dashboard';
    protected $_page = 0;

    public function index(){

        $breadcrumb = [
            [
                'name' => 'Dashboard',
                'url' => route( 'main' )
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
            'component'     => 'service'
        ]);
    }

    private function getRole() {
        $this->_role = session( 'roleDefault' );
    }

    public function getDataDashboard( Request $request ) {
        $this->getRole();
        $template = $this->getTemplate();

        return response()->json([
            'status' => true,
            'template' => $template
        ]);
    }

    private function getTemplate() {
        switch ( $this->_role ) {
            case 6:
                $template = 'operario';
                break;
            default:
                $template = 'admin';
        }

        return $template;
    }

    public function getInformation() {

        $this->getRole();

        switch ( $this->_role ) {
            case 6:
                $response = $this->summaryOperator();
                break;
            default:
                $response = $this->summaryAdmin();
        }

        return response()->json( $response );
    }

    private function summaryAdmin() {
        return [
            'status' => true,
            'summary' => [
                'users' => User::where( 'status', 1 )->count(),
                'customers' => Customer::where( 'status', 1 )->count(),
                'services' => Service::whereNotIn( 'status', [0, 1, 2] )->count()
            ],
            'services' => $this->services()
        ];
    }

    private function summaryOperator () {
        return [
            'status' => true,
            'summary' => $this->getCountAssinegTask()
        ];
    }

    private function getCountAssinegTask() {
        $userId = Auth()->user()->getAuthIdentifier();

        $assigneds = AssignedWorker::whereNotIn( 'status', [0, 2, 6] )
            ->where( 'users_id', $userId )
            ->get();

        $data = [
            'doing' => [
                'count' => 0,
                'title' => 'Por iniciar',
                'status' => 1,
                'class' => 'text-warning',
                'icon'  => 'fa-hourglass'
            ],
            'process' => [
                'count' => 0,
                'title' => 'En proceso',
                'status' => 1,
                'class' => 'text-info',
                'icon' => 'fa-tasks'
            ],
            'finalized' => [
                'count' => 0,
                'title' => 'Finalizado',
                'status' => 1,
                'class' => 'text-primary',
                'icon' => 'fa-check'
            ],
            'observed' => [
                'count' => 0,
                'title' => 'Observado',
                'status' => 1,
                'class' => 'text-danger',
                'icon' => 'fa-exclamation-triangle'
            ],
        ];
        foreach ( $assigneds as $assigned ) {
            switch ( $assigned->status ) {
                case 1:
                    $data['doing']['count']++;
                    break;
                case 3:
                    $data['process']['count']++;
                    break;
                case 4:
                    $data['finalized']['count']++;
                    break;
                case 5:
                    $data['observed']['count']++;
                    break;
            }
        }

        return $data;
    }

    private function services() {
        $services = Service::whereNotIn( 'status', [0, 1, 2])
            ->orderBy( 'date_aproved', 'desc' )
            ->limit(10)
            ->get();

        $data = [];

        foreach( $services as $service ) {
            $row = new \stdClass();
            $row->id = $service->id;
            $row->document = $service->serial_doc . ' ' . $service->number_doc;
            $row->aproved = date( 'd/m/Y', strtotime( $service->date_aproved ) );
            $row->aprovedCustomer = $service->date_aproved_customer ? date( 'd/m/Y', strtotime( $service->date_aproved_customer ) ) : '---';
            $row->status = $service->status;

            $customer = $service->serviceRequest->customer;

            $nameCustomer = $customer->name;
            if( $customer->type_person === 1 ) {
                $nameCustomer .= ' ' . $customer->lastname;
            }

            $row->customer = new \stdClass();
            $row->customer->id = $customer->id;
            $row->customer->name = $nameCustomer;
            $row->customer->document = $customer->typeDocument->name . ': ' .$customer->document;

            $row->task = new \stdClass();
            $row->task->all = 0;
            $row->task->porIniciar = 0;
            $row->task->enProceso = 0;
            $row->task->terminado = 0;
            $row->task->observado = 0;
            $row->task->finalizado = 0;
            $row->task->porc = 0;
            $row->task->class = 'bg-danger';

            foreach ( $service->stages as $stage ){
                $row->task->all += $stage->tasks->where( 'status' , '!=', 2 )->count();
                $row->task->porIniciar += $stage->tasks->where( 'status' , 1 )->count();
                $row->task->enProceso += $stage->tasks->where( 'status' , 3 )->count();
                $row->task->terminado += $stage->tasks->where( 'status' , 4 )->count();
                $row->task->observado += $stage->tasks->where( 'status' , 5 )->count();
                $row->task->finalizado += $stage->tasks->where( 'status' , 6 )->count();
            }

            if( $row->task->all > 0 ) {
                $row->task->porc = round( ( $row->task->finalizado / $row->task->all ) * 100 );
                if( $row->task->porc > 40 && $row->task->porc < 80 ) {
                    $row->task->class = 'bg-warning';
                } elseif ( $row->task->porc >= 80 ) {
                    $row->task->class = 'bg-primary';
                }
            }

            $data[] = $row;
        }

        return $data;
    }
}
