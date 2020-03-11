<?php

namespace App\Http\Controllers;

use App\Access;
use App\Customer;
use App\Models\Purchase;
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

    public function ajaxService( Request $request ) {

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
            $row->registration = date( self::DATE_FORMAT, strtotime( $data->created_at ) );
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

        dd( $from, $to, $records );
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
