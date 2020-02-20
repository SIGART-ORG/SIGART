<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
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
}
