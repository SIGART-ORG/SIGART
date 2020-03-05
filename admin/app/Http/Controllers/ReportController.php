<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function dashboard() {

    }

    public function services() {

    }

    public function ajaxService( Request $request ) {

    }

    public function ajaxCustomer( Request $request ) {
        $datas = Customer::where( 'status', '!=', 2 )
            ->orderBy( 'name', 'asc' )
            ->orderBy( 'lastname', 'asc' )
            ->orderBy( 'business_name', 'asc' )
            ->paginate( self::PAGINATE );

        $paginate = $this->paginate( $datas );
        dd( $datas );
    }

    private function paginate( $paginate ) {
        $paginateFormat = [];

        return $paginate;
    }
}
