<?php

namespace App\Http\Controllers;

use App\Access;
use App\Customer;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\CustomerExport;
use App\Exports\ServicesExport;
use App\Exports\PurchaseExport;
use App\Exports\ServiceRequestExport;
use Maatwebsite\Excel\Facades\Excel;
class ReportController extends Controller
{

    protected $breadcrumb = [];
    public $sidebar = [];
    public $_page = 40;
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
        $this->_page = 42;
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
        $this->_page = 43;
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
        $this->_page = 44;
        $this->setSidebar();
        $breadcrumb = $this->getBreadcrumb( 'report.purchases.dashboard' );
        return view( 'mintos.pages.reports.purchase', [
            'breadcrumb' => $breadcrumb,
            'sidebar' => $this->sidebar,
            'moduleDB' => '',
            'menu' => $this->_page,
        ]);
    }

    public function customers() {
        $this->_page = 45;
        $this->setSidebar();
        $breadcrumb = $this->getBreadcrumb( 'report.curstomer.dashboard' );
        return view( 'mintos.pages.reports.customer', [
            'breadcrumb' => $breadcrumb,
            'sidebar' => $this->sidebar,
            'moduleDB' => '',
            'menu' => $this->_page,
        ]);
    }

    public function ajaxService( Request $request ) {
        $service_data = $this->getServices();
        $services = $service_data["data"];
        $paginate = $service_data['paginate'];
         return view('mintos.pages.reports.services-load',compact('services','paginate'));
    }

    public function getServices( $paginate = true ){
        $records = Service::whereNotIn( 'status', [0, 1, 2])
            ->orderBy( 'date_aproved', 'desc' );

        if( $paginate ) {
            $records = $records->paginate(self::PAGINATE);
        } else {
            $records = $records->get();
        }

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

        $paginate = $this->paginate( $records, $paginate );

        return array("data"=>$services,"paginate"=>$paginate);
    }

    public function ajaxCustomer( Request $request ) {

        $customers_data = $this->getCustomer();
        $customers = $customers_data["data"];
        $paginate = $customers_data['paginate'];
        return view('mintos.pages.reports.customer-load',compact('customers','paginate'));
    }

    public function getCustomer( $isPaginate = true )
    {
        $customers = [];

        $datas = Customer::whereIn( 'status', [1] )
            ->orderBy( 'name', 'asc' )
            ->orderBy( 'lastname', 'asc' )
            ->orderBy( 'business_name', 'asc' );

        if( $isPaginate ) {
            $datas = $datas->paginate(self::PAGINATE);
        } else {
            $datas = $datas->get();
        }

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
                $row->services->total += $sr->services->whereNotIn( 'status', [0,2] )->count();
            }


            $customers[] = $row;
        }

        $paginate = $this->paginate( $datas, $isPaginate );

        return array("data"=>$customers,"paginate"=>$paginate);
    }

    public function ajaxPurchase( Request $request ) {
        $purchase_data = $this->getPurchase($request);
        $purchases = $purchase_data["data"];
        $paginate = $purchase_data['paginate'];
        return view('mintos.pages.reports.purchase-load',compact('purchases','paginate'));
    }

    public function getPurchase($request="", $paginate = true){
        $from = date( 'Y-m-01' );
        $to =  date( self::DATE_FORMAT_REPORT );
        if(is_object($request)){
            $from = $request->from ? date( self::DATE_FORMAT_REPORT, strtotime( $request->from ) ) : date( 'Y-m-01' );
            $to = $request->to ? date( self::DATE_FORMAT_REPORT, strtotime( $request->to ) ) : date( self::DATE_FORMAT_REPORT );

        }

        $records = Purchase::whereNotIn( 'status', [0,2] )
            ->whereBetween( 'date_issue', [$from, $to] )
            ->orderBy( 'date_issue', 'asc' );
        if( $paginate ) {
            $records = $records->paginate(self::PAGINATE);
        } else {
            $records = $records->get();
        }

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
        $paginate = $this->paginate( $records, $paginate );

        return array("data"=>$purchases,"paginate"=>$paginate);
    }

    private function paginate( $paginate, $isPaginate = true ) {
        $paginateFormat = [];

        if( !empty( $paginate ) && $isPaginate ) {
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

    public function exportCustomer()
    {
        $customers_data = $this->getCustomer( false );
        $export = new CustomerExport($customers_data["data"]);
        $fileName = 'reporte-de-customer-' . date( 'Y-m-d__H-i-s') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    public function exportService()
    {
        $service_data = $this->getServices( false );
        $fileName = 'reporte-de-servicios-' . date( 'Y-m-d__H-i-s') . '.xlsx';
        $export = new ServicesExport($service_data["data"]);

        return Excel::download($export, $fileName);
    }

    public function exportPurchase()
    {
        $purchase_data = $this->getPurchase( false );
        $export = new PurchaseExport($purchase_data["data"]);
        $fileName = 'reporte-de-compras-' . date( 'Y-m-d__H-i-s') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    public function exportServiceRequest() {
        $service_request_data = $this->getServiceRequest( false );
        $export = new ServiceRequestExport($service_request_data["data"]);
        $fileName = 'reporte-de-solicitudes-de-servicios-' . date( 'Y-m-d__H-i-s') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    public function ajaxServiceRequest( Request $request ) {
        $serviceRequest = $this->getServiceRequest( $request );
        $serviceRequests = $serviceRequest['data'];
        $paginate = $serviceRequest['paginate'];
        return view('mintos.pages.reports.service-request-approved-load',compact('serviceRequests','paginate'));
    }

    private function getServiceRequest( $request, $paginate = true ) {
        $records = ServiceRequest::whereNotIn( 'status', [0,2] )
            ->where( 'is_send', '<>', 0 )
            ->orderBy( 'date_send', 'ASC' );
        if( $paginate ) {
            $records = $records->paginate(self::PAGINATE);
        } else {
            $records = $records->get();
        }

        $serviceRequests = [];
        foreach ( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->serviceRequest = new \stdClass();
            $row->serviceRequest->id = $record->id;
            $row->serviceRequest->name = $record->description;
            $row->serviceRequest->document = $record->num_request;
            $row->serviceRequest->send = $this->getDateComplete( $record->date_send );
            $row->serviceRequest->approved = $this->getDateComplete( $record->date_aproved );

            $customer = $record->customer;
            if( $customer ) {
                $row->customer = new \stdClass();
                $row->customer->id = $customer->id;
                $row->customer->document = $customer->typeDocument->name . ': ' . $customer->document;
                $row->customer->name = $customer->type_person === 1 ? $customer->name . ' ' . $customer->lastname : $customer->name;
            }

            $saleQuotation = $record->salesQuotations->sortByDesc( 'created_at' )->first();
            if( $saleQuotation ) {
                $row->saleQuotation  = new \stdClass();
                $row->saleQuotation->id = $saleQuotation->id;
                $row->saleQuotation->document = $saleQuotation->num_serie . '-' . $saleQuotation->num_doc;
                $row->saleQuotation->created = $this->getDateComplete( $saleQuotation->date_emission );
                $row->saleQuotation->approved_adm = $saleQuotation->type_reply === 1 ? $this->getDateComplete( $saleQuotation->date_reply ) : '';
                $row->saleQuotation->approved_dg = $saleQuotation->type_reply_second === 1 ? $this->getDateComplete( $saleQuotation->date_reply_second ) : '';
                $row->saleQuotation->approved_customer = $saleQuotation->is_approved_customer === 1 ? $this->getDateComplete( $saleQuotation->date_approved_customer ) : '';
            }

            $service = $record->services->sortByDesc( 'created_at' )->first();
            if( $service ) {
                $row->service = new \stdClass();
                $row->service->id = $service->id;
                $row->service->document = $service->serial_doc . '-' . $service->num_doc;
                $row->service->total = 'S/' . number_format( $service->total, 2 );
                $row->service->start = $this->getDateComplete( $service->start_date_real );
                $row->service->end = $this->getDateComplete( $service->end_date_real );
                $row->service->status = $this->getStatus( 'service', $service->status );
            }

            $daySendServiceRequest = $record->date_send;
            $dayApprovedDGQuotation = ( !empty($saleQuotation->type_reply_second) && $saleQuotation->type_reply_second === 1 )? $saleQuotation->date_reply_second : false;
            $dayDiffSR = '--';
            if( $daySendServiceRequest && $dayApprovedDGQuotation ) {
                $cDateStart = new Carbon( $daySendServiceRequest );
                $cDateEnd = new Carbon( $dayApprovedDGQuotation );
                $dayDiffSR = $cDateStart->diff( $cDateEnd )->days;
            }
            $row->dayDiffSR = $dayDiffSR;

            $serviceRequests[] = $row;
        }

        $paginate = $this->paginate( $records, $paginate );

        return ['data'=>$serviceRequests, 'paginate'=>$paginate];
    }

}
