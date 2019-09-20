<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\SalesQuote;
use App\EnLetras;

class SalesQuoteController extends Controller
{
    protected $_moduleDB = 'sales_quote';


    public function dashboard()
    {

        $xData   = array();

        $permiso = Access::sideBar();
        $xData['DataTypeDocuments'] = SalesQuote::List_Type_Documents();
        $xData['DataCustomers'] = SalesQuote::List_Customers();
        $xData['FechaHoy'] = date('d-m-Y');
        $xData['DataNumSerie'] = SalesQuote::Generate_Num_Serie();
        $xData['DataNumDocument'] = SalesQuote::Generate_Num_Document();
        $xData['DataProducts'] = SalesQuote::List_Products();
        $xData['DataUnities'] = SalesQuote::List_Unitys();
        

        $breadcrumb = [
            [
                'name' => 'Cotizaciones',
                'url' => '/salesquote/dashboard'
            ],
            [
                'name' => 'Registro',
                'url' => '#'
            ]
        ];

        $xData = [
            "menu" => 22,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB,
            "wData" => $xData,
            "breadcrumb" => $breadcrumb
        ];



        return view('mintos.pages.sales_quote.principal', $xData);
    }



    public function searchProduct(Request $request)
    {

        $xData = array();
        $x_codigo = ( $request->input('x_codigo') ) ? $request->input('x_codigo') : '';

        $xData['vProducto'] = SalesQuote::View_Data_Product_x_ID([ 'products_id'=>$x_codigo ]);

        return json_encode($xData);
    }


    public function ViewTotalLetters(Request $request){

        $valor = ( $request->input('valor') ) ? $request->input('valor') : '0';
        $Valor_Letras = EnLetras::ValorEnLetras($valor, '');
        return $Valor_Letras;

    }


    
}
