<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
use App\Models\Sale;
use App\Models\ServiceStage;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Servicios',
                'url' => route( 'service.dashboard' )
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

    public function index( Request $request ) {

        $search = $request->search ? $request->search : '';

        $response = Service::getAll( $search );

        $data = [];

        $items = $response->items();

        foreach ( $items as $item ) {
            $row = new \stdClass();
            $row->id = $item->id;
            $row->serialDoc = $item->serial_doc;
            $row->numberDoc = $item->number_doc;
            $row->date = date( 'd/m/Y', strtotime( $item->date_reg ) );
            $row->status = $item->status;
            $row->serviceRequest = new \stdClass();
            $row->serviceRequest->id = $item->serviceRequest->id;
            $row->serviceRequest->name = $item->serviceRequest->description;
            $row->serviceRequest->dateEmission = date( 'd/m/Y', strtotime( $item->serviceRequest->date_emission ) );
            $row->serviceRequest->numRequest = $item->serviceRequest->num_request;
            $row->serviceRequest->attachment = $item->serviceRequest->attachment;
            $row->serviceRequest->status = $item->serviceRequest->status;

            $customer = $item->serviceRequest->customer;
            $name = $customer->name;
            if( $customer->type_person === 1 ) {
                $name .= ' '. $customer->lastname;
            }
            $document = $customer->typeDocument->name . ': ' . $customer->document;

            $row->customer = new \stdClass();
            $row->customer->id = $customer->id;
            $row->customer->name = $name;
            $row->customer->document = $document;

            $data[] = $row;
        }

        return response()->json([
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $data
        ]);
    }

    public function request( Request $request ) {
        $breadcrumb = [
            [
                'name' => 'Servicios',
                'url' => route( 'service.dashboard' )
            ],
            [
                'name' => 'Requerimientos',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'requerimiento',
            'service'       => $request->id
        ]);
    }

    public function data( Request $request ) {

        $serviceId = $request->id;

        $response = [
            'status' => false,
            'msg' => '',
            'data' => [],
        ];

        $service = Service:: find( $serviceId );
        if( $service ) {

            $serviceRequest = $service->serviceRequest;
            $customer = $serviceRequest->customer;
            $quotation = $serviceRequest->salesQuotations->sortByDesc( 'created_at' )->first;
            $saleQuotation = $quotation->id ? $quotation->id : null;

            $name = $customer->name;
            if ($customer->type_person === 1) {
                $name .= ' ' . $customer->lastname;
            }

            $data = new \stdClass();
            $data->document = $service->serial_doc . '-' . $service->number_doc;
            $data->description = $service->description;
            $data->subTotal = $service->sub_total;
            $data->igv = $service->igv;
            $data->total = $service->total;
            $data->payment = $service->sales->whereNotIn( 'status', [0,2])->sum( 'pay_mount' );
            $data->status = $service->status;
            $data->orderPay = $service->is_send_order_pay;
            $data->idEditable = $service->isEditable();

            $data->serviceRequest = new \stdClass();
            $data->serviceRequest->document = $serviceRequest->num_request;
            $data->serviceRequest->name = $serviceRequest->description;
            $data->serviceRequest->send = date( 'd/m/Y', strtotime( $serviceRequest->date_send ) );
            $data->serviceRequest->status = $serviceRequest->status;
            $data->serviceRequest->delivery = $serviceRequest->delivery_date ? date( 'd/m/Y', strtotime( $serviceRequest->delivery_date ) ) : '---';
            $data->serviceRequest->address = $serviceRequest->address;
            $data->serviceRequest->ubigeo = HelperSigart::ubigeo( $serviceRequest->district_id, 'inline' );

            $data->customer = new \stdClass();
            $data->customer->name = $name;
            $data->customer->document = $customer->typeDocument->name . ': ' . $customer->document;
            $data->customer->email = $customer->email;

            $data->quotation = new \stdClass();
            $data->reference = new \stdClass();
            if( $saleQuotation ) {
                $data->quotation->id = $saleQuotation->id;
                $data->quotation->emission = $saleQuotation->date_emission ? date( 'd/m/Y', strtotime( $saleQuotation->date_emission ) ) : '---';
                $data->quotation->document = $saleQuotation->num_serie . '-' . $saleQuotation->num_doc;

                $reference = $saleQuotation->referenceterms->sortByDesc( 'created_at' )->first;
                if( $reference && $reference->id ) {
                    $data->reference->id = $reference->id->id;
                    $data->reference->area = $reference->id->area;
                    $data->reference->activity = $reference->id->activity;
                    $data->reference->objective = $reference->id->objective;
                    $data->reference->specializedArea = $reference->id->specialized_area;
                    $data->reference->execution = $reference->id->execution_time_text;
                    $data->reference->execution = $reference->id->execution_time_text;
                    $data->reference->address = $reference->id->execution_address;
                    $data->reference->ubigeo = HelperSigart::ubigeo( $reference->id->district_id, 'inline' );
                    $data->reference->reference = $reference->id->address_reference;
                    $data->reference->methodPayment = $reference->id->method_payment;
                    $data->reference->conformanceGrant = $reference->id->conformance_grant;
                    $data->reference->warranty = $reference->id->warranty_text;
                    $data->reference->obervations = $reference->id->obervations;
                    $data->reference->pdf_os = $reference->id->pdf_os ? asset( $reference->id->pdf_os ) : '';
                }
            }

            $response['status'] = true;
            $response['data'] = $data;
        }

        return response()->json( $response, 200  );
    }

    public function sendOrderPay( Request $request ) {
        $service = $request->service ? $request->service : 0;

        $response = [
            'status' => false
        ];

        $serviceClass = Service::find( $service );
        if( $serviceClass && $serviceClass->is_send_order_pay === 0 ) {

            $middleMount = $serviceClass->total / 2;

            $serviceClass->is_send_order_pay = 1;
            $serviceClass->pay_first = $middleMount;
            $serviceClass->pay_last = $middleMount;
            if( $serviceClass->save() ) {
                $response['status'] = true;
            }
        }

        return response()->json( $response );
    }

    public function tasks( Request $request ) {

        $response = [
            'status' => true,
            'total' => 0,
            'columns' => [
                'toStart' => [
                    'total' => 0,
                    'records' => []
                ],
                'inProcess' => [
                    'total' => 0,
                    'records' => []
                ],
                'finished' => [
                    'total' => 0,
                    'records' => []
                ],
                'observed' => [
                    'total' => 0,
                    'records' => []
                ],
                'finalized' => [
                    'total' => 0,
                    'records' => []
                ]
            ]
        ];

        $id = $request->id ? $request->id : 0;

        $service = Service::find( $id );

        if( $service ) {
            $tasks = $this->getDataTask( $service );
            foreach ( $tasks as $task ) {
                switch ( $task->status ) {
                    case 1:
                        $response['columns']['toStart']['total']++;
                        $response['columns']['toStart']['records'][] = $task;
                        $response['total']++;
                        break;
                    case 3:
                        $response['columns']['inProcess']['total']++;
                        $response['columns']['inProcess']['records'][] = $task;
                        $response['total']++;
                        break;
                    case 4:
                        $response['columns']['finished']['total']++;
                        $response['columns']['finished']['records'][] = $task;
                        $response['total']++;
                        break;
                    case 5:
                        $response['columns']['observed']['total']++;
                        $response['columns']['observed']['records'][] = $task;
                        $response['total']++;
                        break;
                    case 6:
                        $response['columns']['finalized']['total']++;
                        $response['columns']['finalized']['records'][] = $task;
                        $response['total']++;
                        break;
                }
            }
        }

        return response()->json( $response );
    }

    private function getDataTask( $service ) {
        $tasks = [];

        $stages = $service->stages->whereNotIn( 'status', [0,2] );

        foreach ( $stages as $stage ) {
            $dataTasks = $stage->tasks->whereNotIn( 'status', [0,2] );

            foreach ( $dataTasks as $data_task ) {
                $assigneds = $data_task->AssignedWorkers->where( 'status', 1 );

                $row = new \stdClass();
                $row->id = $data_task->id;
                $row->name = $data_task->name;
                $row->code = $data_task->code;
                $row->stage = $stage->id;
                $row->stageName = $stage->name;
                $row->stageCode = $stage->code;
                $row->description = $data_task->description;
                $row->statusName = $this->getStatus( 'task', $data_task->status );
                $row->status = $data_task->status;
                $row->user = new \stdClass();
                $row->user->total = 0;
                $row->user->records = [];
                $row->observeds = $data_task->observeds->where( 'status', 1 )->count();

                foreach ( $assigneds as $assigned ) {
                    $cUser = $assigned->user;
                    $dataUser = $this->getDataUser( $cUser );
                    $user = new \stdClass();
                    $user->id = $cUser->id;
                    $user->name = $dataUser['name'];
                    $user->document = $dataUser['document'];
                    $row->user->total++;
                    $row->user->records[] = $user;
                }

                $tasks[] = $row;
            }
        }

        return $tasks;
    }

    public function workers( Request $request ) {
        $workers = [];
        $service = $request->service ? $request->service : 0;

        $records = ServiceStage::whereNotIn( 'status', [0, 2] )
            ->where( 'services_id', $service )
            ->get();

        foreach ( $records as $record ) {
            $tasks = $record->tasks->whereNotIn( 'status', [0, 2] );
            foreach ( $tasks as $task ) {
                $assigneds = $task->AssignedWorkers->whereNotIn( 'status', [0, 2] );
                $taskData = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => $task->description,
                    'stage' => $record->name,
                    'status' => $task->status,
                    'statusName' => $this->getStatus( 'task', $task->status )
                ];
                foreach ( $assigneds as $assigned ) {
                    $key = array_search( $assigned->users_id, array_column( $workers, 'user' ) );
                    if( ! is_bool( $key ) && $key >= 0 ) {
                        $workers[$key]['tasks'][] = $taskData;
                    } else {
                        $user = $assigned->user;
                        $dataUser = $this->getDataUser( $user );
                        $workers[] = [
                            'user' => $assigned->users_id,
                            'name' => $dataUser['name'],
                            'document' => $dataUser['document'],
                            'role' => $dataUser['role'],
                            'tasks' => [
                                $taskData
                            ]
                        ];
                    }
                }
            }
        }

        return response()->json([
            'status' => true,
            'workers' => $workers
        ], 200);
    }

    public function observations( Request $request ) {
        $observations = [];
        $service = $request->service ? $request->service : 0;

        $records = ServiceStage::whereNotIn( 'status', [0, 2] )
            ->where( 'services_id', $service )
            ->get();

        foreach ( $records as $record ) {
            $tasks = $record->tasks->whereNotIn( 'status', [0, 2] );
            foreach ( $tasks as $task ) {
                $observeds = $task->observeds->whereNotIn( 'status', [0, 2] )
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
                        'task' => $task->name,
                        'replyLong' => false
                    ];
                }
            }
        }

        $observations = $this->orderArraybyColumn( $observations, 'created', 'desc' );

        return response()->json([
            'status' => true,
            'observations' => $observations
        ], 200 );
    }

    public function voucher( Request $request ) {
        $service = $request->id ? $request->id : 0;
        $records = Sale::whereNotIn( 'status', [0,2] )
            ->where( 'services_id', $service )
            ->orderBy( 'date_emission', 'desc' )
            ->orderBy( 'serial_doc', 'desc' )
            ->orderBy( 'number_doc', 'desc' )
            ->get();

        $vouchers = [];
        $summary = [
            'subTotal' => 0,
            'igv' => 0,
            'total' => 0
        ];

        foreach ( $records as $record ) {
            $row =  new \stdClass();
            $row->id = $record->id;
            $row->typeDocument = $record->typeVoucher->name;
            $row->document = $record->serial_doc . '-' . $record->number_doc;
            $row->subTotal = $record->subtotal;
            $row->igv = $record->igv;
            $row->total = $record->total;
            $row->emission = $this->getDateFormat( $record->date_emission );
            $row->attachment = $record->attachment ? asset( self::UPLOAD_VOUCHER .$record->attachment ) : '';

            $vouchers[] = $row;

            $summary['subTotal'] += $record->subtotal;
            $summary['igv'] += $record->igv;
            $summary['total'] += $record->total;
        }

        $summary['subTotal'] = round( $summary['subTotal'], 2 );
        $summary['igv'] = round( $summary['igv'], 2 );

        return response()->json([
            'status' => true,
            'data' => [
                'summary' => $summary,
                'vouchers' => $vouchers
            ]
        ], 200 );
    }

    public function secondPayment( Request $request ) {
        $response = [
            'status' => false,
            'msg' => ''
        ];
        $serviceId = $request->id ? $request->id : 0;

        $service = Service::find( $serviceId );
        if( $service && $service->status === 5 ) {
            $total = $service->total;
            $payments = $service->sales->whereNotIn( 'status', [0, 2] )->sum( 'total' );

            $service->status = 6;
            $service->is_send_order_pay = 3;
            $msg = 'Generó la orden de pago, para la cancelación del servicio ' . $service->serial_doc . '-' . $service->number_doc . ' ID::' . $service->id;
            if( $payments >= $total ) {
                $service->status = 7;
                $service->is_send_order_pay = 4;
                $service->end_date_real = date( 'Y-m-d H:i:s' );
                $msg = 'Marcó como culminado el servicio, debidó a que ya se habia cancelado el total del servicio ' . $service->serial_doc . '-' . $service->number_doc . ' ID::' . $service->id;
            }

            if( $service->save() ){
                $this->logAdmin( $msg, $service );
                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }
        return response()->json( $response, 200 );
    }
}
