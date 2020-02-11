<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
use App\Models\Sale;
use App\Models\Service;
use App\Models\SiteVourcher;
use Illuminate\Http\Request;
use DB;

class SaleController extends Controller
{
    const PATH_PDF_SALE= '/sales/';

    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function index( Request $request ) {

        $paginate = 20;
        $search = $request->search ? $request->search : '';
        $sales = [];

        $results = Sale::orderBy( 'created_at', 'desc' )
            ->paginate( $paginate );

        foreach ( $results as $result ){
            $row = new \stdClass();
            $row->id = $result->id;
            $row->document = $result->serial_doc . '-' . $result->number_doc;
            $row->subtotal = $result->subtotal;
            $row->igv = $result->igv;
            $row->total = $result->total;

            $service = $row->service;
            $row->service = new \stdClass();
            $row->service->id = $service->id;
            $row->service->document = $service->serial_doc . '-' . $service->number_doc;
            $row->service->total = $service->total;

            $sales[] = $row;
        }

        $response = [
            'pagination' => [
                'total' => $results->total(),
                'current_page' => $results->currentPage(),
                'per_page' => $results->perPage(),
                'last_page' => $results->lastPage(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem()
            ],
            'records' => $sales
        ];

        return response()->json( $response );
    }

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Facturación',
                'url' => route( 'sale.dashboard' )
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
            'component'     => 'sale',
        ]);
    }

    public function generate( Request $request ) {

        $response = [
            'status' => false
        ];

        $service = $request->service;
        $typeVoucher = $request->typeVoucher;

        $sale = new Sale();
        $sale->services_id = $service;
        $sale->type_vouchers_id = $typeVoucher;
        $sale->type_payment_methods_id = 1;
        $sale->serial_doc = '';
        $sale->number_doc = '';
        $sale->subtotal = 0;
        $sale->igv = 0;
        $sale->total = 0;
        $sale->date_emission = date( 'Y-m-d' );
        $sale->date_pay = date( 'Y-m-d' );
        $sale->company_name = 'D\' Pintart E.I.R.L';
        $sale->business_name_customer = '';
        $sale->company_document = '';
        $sale->customer_document = '';
        $sale->customer_type_document = '';
        $sale->pay_mount = '';
        $sale->observation = '';

        if( $sale->save() ) {
            $response['status'] = true;
        }

        return response()->json( $response );
    }

    public function newSale() {
        $breadcrumb = [
            [
                'name' => 'Facturación',
                'url' => route( 'sale.dashboard' )
            ],
            [
                'name' => 'Nuevo Registro',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'sale-new',
        ]);
    }

    public function search( Request $request ) {
        $search = $request->search ? $request->search : '';

        $response = [
            'data' => []
        ];

        if( strlen( trim( $search ) ) > 2 ) {
            $services = Service::where( 'is_send_order_pay', '!=', 0 )
                ->where( function( $query ) use( $search ) {
                    $query->where( DB::raw( "CONCAT(`serial_doc`, '-', `number_doc`)" ), 'like', '%' . $search . '%' )
                    ->orWhereHas( 'serviceRequest.customer', function( $subQuery ) use( $search ) {
                        $subQuery->where( DB::raw( "CONCAT(`name`, ' ', `lastname`)" ), 'like' , '%' . $search . '%' )
                            ->orWhere( 'document', 'like', '%' . $search . '%' );
                    });
                })
                ->limit( 20 )
                ->orderBy( 'created_at', 'desc' )
                ->get();

            foreach ( $services as $service ) {
                $outstanding = $service->sales->sum( 'pay_mount' );
                $minPay = abs( $outstanding - $service->pay_first );

                $row = new \stdClass();
                $row->id = $service->id;
                $row->document = $service->serial_doc . '-' . $service->number_doc;
                $row->subTotal = $service->sub_total;
                $row->igv = $service->igv;
                $row->total = $service->total;
                $row->paidOut = $service->total - $outstanding;
                $row->outstanding = $outstanding;
                $row->minPay = $minPay;
                $row->dateEmision = date( 'Y-m-d' );
                $row->today = date( 'Y-m-d' );
                $row->details = $this->getServiceDetails( $service->serviceDetails );

                $serviceRequest = $service->serviceRequest;
                $customer = $serviceRequest->customer;

                $row->customer = new \stdClass();
                $row->customer->id = $customer->id;
                $row->customer->name = $customer->type_person === 1 ? $customer->name . ' ' . $customer->lastname : $customer->name;
                $row->customer->document = $customer->document;
                $row->customer->typePerson = $customer->type_person;
                $row->customer->typeDocument = $customer->type_document;
                $row->customer->typeDocumentName = $customer->typeDocument->name;
                $row->customer->address = $customer->address;
                $row->customer->ubigeo = HelperSigart::ubigeo( $customer->district_id, 'inline' );

                $typeVoucher        = $customer->type_document === 2 ? 5 : 4;
                $SiteVoucherClass   = new SiteVourcher();
                $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher, 'details' );
                $row->voucher = new \stdClass();
                $row->voucher->typeDocument = $typeVoucher;
                $row->voucher->typeDocuments = $this->typeVoucher( $customer->type_document, $customer->type_person );
                $row->voucher->document = $correlative['status'] ? $correlative['correlative']['serie'] . '-' . $correlative['correlative']['number'] : '';

                $response['data'][] = $row;
            }
        }

        return response()->json( $response );
    }

    private function getServiceDetails( $details ) {
        $data = [];

        foreach ( $details as $detail ) {
            $row = new \stdClass();
            $row->id = $detail->id;
            $row->description = $detail->description;
            $row->priceUnit = $detail->price_unit;
            $row->quantity = $detail->quantity;
            $row->total = $detail->total;

            $data[] = $row;
        }

        return $data;
    }

    private function typeVoucher( $tDocument, $tPerson ) {
        $typeDocuments = [];

        switch ( $tPerson ) {
            case 1:
                if( $tDocument === 2 ) {
                    $typeDocuments[] = [
                        'id' => 5,
                        'name' => 'Factura'
                    ];
                } else {
                    $typeDocuments[] = [
                        'id' => 4,
                        'name' => 'Boleta'
                    ];
                }
                break;
            case 2:
                $typeDocuments[] = [
                    'id' => 5,
                    'name' => 'Factura'
                ];
                break;
        }

        return $typeDocuments;
    }

    public function store( Request $request ) {
        $service = $request->service ? $request->service : 0;
        $amount = $request->amount ? $request->amount : 0;
        $emission = $request->emission ? $request->emission : 0;
        dd( $service, $amount, $emission );
    }
}
