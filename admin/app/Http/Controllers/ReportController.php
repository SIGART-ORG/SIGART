<?php

namespace App\Http\Controllers;

use App\Access;
use App\Customer;
use App\Models\Purchase;
use App\Models\Service;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    protected $breadcrumb = [];
    protected $sidebar = [];
    protected $_page = 0;
    protected $_moduleDB = 'reports';

    public function __construct()
    {

    }

    private function setSidebar() {
        $this->sidebar = Access::sideBar($this->_page);
    }

    private function getBreadcrumb( $name ) {
        $this->breadcrumb = [
            [
                'name' => 'Reportes',
                'url' => route( $name )
            ],
        ];

        return $this->breadcrumb;
    }

    public function dashboard() {

    }

    public function services() {
        $this->setSidebar();
        $breadcrumb = $this->getBreadcrumb( 'report.service.dashboard' );

        return view( 'mintos.pages.reports.services', [
            'breadcrumb' => $breadcrumb,
            'sidebar' => $this->sidebar,
            'moduleDB' => '',
            'menu' => $this->_page,
        ]);
    }

    public function serviceRequest() {
        $this->setSidebar();
        $breadcrumb = $this->getBreadcrumb( 'report.service-request-approved.dashboard' );
        return view( 'mintos.pages.reports.service-request-approved', [
            'breadcrumb' => $breadcrumb,
            'sidebar' => $this->sidebar,
            'moduleDB' => '',
            'menu' => $this->_page,
        ]);
    }

    public function purchases() {
        $this->setSidebar();
        $breadcrumb = $this->getBreadcrumb( 'report.purchases.dashboard' );
        return view( 'mintos.pages.reports.purchase', [
            'breadcrumb' => $breadcrumb,
            'sidebar' => $this->sidebar,
            'moduleDB' => '',
            'menu' => $this->_page,
        ]);
    }

    public function ajaxService( Request $request ) {
        $records = Service::whereNotIn( 'status', [0, 1, 2])
            ->orderBy( 'date_aproved', 'desc' )
            ->paginate( self::PAGINATE );

        $services = [];
        foreach ( $records as $record ) {

            $customer = $record->servicerequest->customer;
            $dataCustomer = $this->getDataCustomer( $customer );
            $payment = $record->sales->sum( 'pay_mount' );

            $row = new \stdClass();
            $row->id = $record->id;
            $row->document = $record->serial_doc . '-' . $record->number_doc;
            $row->start = $this->getDateFormat( $record->start_date );
            $row->end = $this->getDateFormat( $record->end_date );
            $row->total = $record->total;
            $row->payment = $payment;
            $row->paymentPorc = $this->calculatePorc( $record->total, $payment, '% Total' );
            $row->status = $record->status;
            $row->statusName = $this->getStatus( 'service', $record->status );
            $row->customer = new \stdClass();
            $row->customer->id = $customer->id;
            $row->customer->name = $dataCustomer['name'];
            $row->customer->document = $dataCustomer['document'];
            $row->customer->typeDocument = $dataCustomer['typeDocument'];
            $row->tasks = new \stdClass();
            $row->tasks->total = 0;
            $row->tasks->toStart = 0;
            $row->tasks->inProcess = 0;
            $row->tasks->finished = 0;/*terminado*/
            $row->tasks->observed = 0;
            $row->tasks->finalized = 0;/*Finalizado*/

            $row->tasks->porc = 0;
            $row->tasks->class = 'bg-danger';

            foreach ( $record->stages as $stage ){
                $row->tasks->total += $stage->tasks->where( 'status' , '!=', 2 )->count();
                $row->tasks->toStart += $stage->tasks->where( 'status' , 1 )->count();
                $row->tasks->inProcess += $stage->tasks->where( 'status' , 3 )->count();
                $row->tasks->finished += $stage->tasks->where( 'status' , 4 )->count();
                $row->tasks->observed += $stage->tasks->where( 'status' , 5 )->count();
                $row->tasks->finalized += $stage->tasks->where( 'status' , 6 )->count();
            }

            if( $row->tasks->total > 0 ) {
                $row->tasks->porc = round( ( $row->tasks->finalized / $row->tasks->total ) * 100 );
                if( $row->tasks->porc > 40 && $row->tasks->porc < 80 ) {
                    $row->tasks->class = 'bg-warning';
                } elseif ( $row->tasks->porc >= 80 ) {
                    $row->tasks->class = 'bg-primary';
                }
            }

            $services[] = $row;
        }

        $paginate = $this->paginate( $records );

        return response()->json([
            'status' => true,
            'msg' => 'OK',
            'records' => $services,
            'pagination' => $paginate
        ]);
    }

    public function ajaxCustomer( Request $request ) {

        $customers = [];

        $datas = Customer::whereNotIn( 'status', [2,3] )
            ->orderBy( 'name', 'asc' )
            ->orderBy( 'lastname', 'asc' )
            ->orderBy( 'business_name', 'asc' )
            ->paginate( self::PAGINATE );

        foreach ( $datas as $data ) {
            $row = new \stdClass();
            $row->id = $data->id;
            $row->typeDocument = $data->typeDocument->name;
            $row->document = $data->document;
            $row->typePerson = $data->type_person === 1 ? 'Persona Natural' : 'Persona Jurídica';
            $row->name = $data->name;
            $row->email = $data->email;
            $row->lastname = $data->lastname;
            $row->registration = $this->getDateFormat( $data->created_at );
            $row->status = $data->status;
            $row->users = $data->customerLogins->whereNotIn( 'status', [2, 0] )->count();
            $row->serviceRequest = new \stdClass();
            $row->serviceRequest->total = $data->serviceRequests->count();
            $row->saleQuotation = new \stdClass();
            $row->saleQuotation->total = 0;
            $row->services = new \stdClass();
            $row->services->total = 0;

            foreach ( $data->serviceRequests as $sr ) {
                $row->saleQuotation->total += $sr->salesQuotations->count();
                $row->services->total += $sr->services->count();
            }


            $customers[] = $row;
        }

        $paginate = $this->paginate( $datas );

        return response()->json([
            'status' => true,
            'msg' => 'OK',
            'records' => $customers,
            'pagination' => $paginate
        ]);
    }

    public function ajaxPurchase( Request $request ) {

        $from = $request->from ? date( self::DATE_FORMAT_REPORT, strtotime( $request->from ) ) : date( 'Y-m-01' );
        $to = $request->to ? date( self::DATE_FORMAT_REPORT, strtotime( $request->to ) ) : date( self::DATE_FORMAT_REPORT );

        $records = Purchase::whereNotIn( 'status', [0,2] )
            ->whereBetween( 'date_issue', [$from, $to] )
            ->orderBy( 'date_issue', 'asc' )
            ->paginate( self::PAGINATE );

        $purchases = [];
        foreach( $records as $record ) {

            $provider = $record->purchaseOrder->provider;
            $dataProvider = $this->getDataProviderV2( $provider );

            $row = new \stdClass();
            $row->id = $record->id;
            $row->typeVoucher = $record->typeVoucher->name;
            $row->document = $record->serial_doc . '-' . $record->number_doc;
            $row->issue = $this->getDateFormat( $record->date_issue );
            $row->payment = $this->getDateFormat( $record->date_payment );
            $row->subTotal = $record->subtotal;
            $row->igv = $record->igv;
            $row->total = $record->total;
            $row->status = $record->status;
            $row->statusName = $this->getStatus( 'purchase', $record->status );
            $row->provider = new \stdClass();
            $row->provider->id = $provider->id;
            $row->provider->name = $dataProvider['name'];
            $row->provider->document = $dataProvider['document'];
            $row->provider->typeDocument = $dataProvider['typeDocument'];

            $purchases[] = $row;
        }

        $paginate = $this->paginate( $records );

        return response()->json([
            'status' => true,
            'msg' => 'OK',
            'records' => $purchases,
            'pagination' => $paginate
        ]);
    }

    private function paginate( $paginate ) {
        $paginateFormat = [];

        if( !empty( $paginate ) ) {
            $paginateFormat = [
                'total' => $paginate->total(),
                'current_page' => $paginate->currentPage(),
                'per_page' => $paginate->perPage(),
                'last_page' => $paginate->lastPage(),
                'from' => $paginate->firstItem(),
                'to' => $paginate->lastItem()
            ];
        }

        return $paginateFormat;
    }
}
