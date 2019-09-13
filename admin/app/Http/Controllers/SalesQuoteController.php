<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\SalesQuote;

class SalesQuoteController extends Controller
{
    protected $_moduleDB = 'sales_quote';


    public function dashboard(){

        $xData   = array();

        $permiso = Access::sideBar();
        $xData['ObjDocumentos'] = SalesQuote::Listar_Documentos();
        
        $xData = [
            "menu" => 22,
            'sidebar' => $permiso,
            "module" => $this->_moduleDB,
            "wData" => $xData
        ];   

        return view('sales_quote.principal', $xData);
    }
}
