<?php

namespace App\Http\Controllers;

use App\Access;
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

    }
}
