<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\SalesQuote;
use App\EnLetras;
use App\Funciones;

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
        $xData['DataListDsctos'] = SalesQuote::List_Dsctos();
        $xData['DataIGV'] = SalesQuote::Data_IGV();
        
        

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


    public function RegisterSales(Request $request){

        $cbo_TipDocumento   = ( $request->input('cbo_TipDocumento') ) ? $request->input('cbo_TipDocumento') : '';
        $cbo_Customers      = ( $request->input('cbo_Customers') ) ? $request->input('cbo_Customers') : '';
        $txt_tot_a_pagar    = ( $request->input('txt_tot_a_pagar') ) ? $request->input('txt_tot_a_pagar') : '';
        $txt_observacion    = ( $request->input('txt_observacion') ) ? $request->input('txt_observacion') : '';
        
        
        $cbo_descuento      = ( $request->input('cbo_descuento') ) ? $request->input('cbo_descuento') : '0';
        $txt_subtotalVta    = ( $request->input('txt_subtotalVta') ) ? $request->input('txt_subtotalVta') : '';
        $txh_valIGV         = ( $request->input('txh_valIGV') ) ? $request->input('txh_valIGV') : '';
        $txt_igvVta         = ( $request->input('txt_igvVta') ) ? $request->input('txt_igvVta') : '';
        $txt_totalVta       = ( $request->input('txt_totalVta') ) ? $request->input('txt_totalVta') : '';
        $txt_total_letras   = ( $request->input('txt_total_letras') ) ? $request->input('txt_total_letras') : '';

        $x_Cantidad     = ( $request->input('Array_Cantidad') ) ? $request->input('Array_Cantidad') : '';
        $x_UnitMed      = ( $request->input('Array_UnitMed') ) ? $request->input('Array_UnitMed') : '';
        $x_Productos    = ( $request->input('Array_Productos') ) ? $request->input('Array_Productos') : '';
        $x_Comentario   = ( $request->input('Array_Comentario') ) ? $request->input('Array_Comentario') : '';
        $x_PrecUnit     = ( $request->input('Array_PrecUnit') ) ? $request->input('Array_PrecUnit') : '';
        $x_Total        = ( $request->input('Array_Total') ) ? $request->input('Array_Total') : '';

        $Array_Cantidad = array();
        $Array_Cantidad = isset( $x_Cantidad ) ? explode(',',$x_Cantidad) : '';

        $Array_UnitMed = array();
        $Array_UnitMed = isset( $x_UnitMed ) ? explode(',',$x_UnitMed) : '';

        $Array_Producto = array();
        $Array_Producto = isset( $x_Productos ) ? explode(',',$x_Productos) : '';

        $Array_Coment = array();
        $Array_Coment = isset( $x_Comentario ) ? explode(',',$x_Comentario) : '';

        $Array_PreUnit = array();
        $Array_PreUnit = isset( $x_PrecUnit ) ? explode(',',$x_PrecUnit) : '';

        $Array_Total = array();
        $Array_Total = isset( $x_Total ) ? explode(',',$x_Total) : '';

        //=============================================================================
        //=============================================================================
        //=============================================================================

        $xFechaHoy = date('d-m-Y');

        $ObjCotizacion  = SalesQuote::Generate_ID_Cotizacion();
        $id_cotizacion     = $ObjCotizacion->id_cotizacion;

        $ObjNumSerie    = SalesQuote::Generate_Num_Serie();
        $xnum_serie     = $ObjNumSerie->num_serie;

        $ObjNumDocum    = SalesQuote::Generate_Num_Document();
        $xnum_doc       = $ObjNumDocum->num_doc;  

        $valorDscto =  (($cbo_descuento*1) / 100 ) * $txt_tot_a_pagar;


        $arrayCampos = [
            'id'=>$id_cotizacion,
            'type_vouchers_id'=>$cbo_TipDocumento,
            'date_emission'=>Funciones::Cambiar_fecha_a_Mysql($xFechaHoy),
            'num_serie'=>$xnum_serie,
            'num_doc'=>$xnum_doc,
            'customers_id'=>$cbo_Customers,
            'tot_sale'=>$txt_tot_a_pagar,
            'porc_dscto'=>$cbo_descuento,
            'tot_dscto'=>$valorDscto,
            'subtot_sale'=>$txt_subtotalVta,
            'porc_igv'=>$txh_valIGV,
            'tot_igv'=>$txt_igvVta,
            'tot_gral'=>$txt_totalVta,
            'total_letter'=>$txt_total_letras,
            'observation'=>$txt_observacion
            
        ];

        $Insertado = SalesQuote::Registrar_Cotizacion_CAB($arrayCampos);
        $valor = ($Insertado) ? $id_cotizacion : '0';

        //####################################################################
        //####################################################################
        //####################################################################

        if($valor>0){

            for ( $w = 0; $w < count($Array_Producto); $w++){
          
                $ObjDetalleDoc  = SalesQuote::Generate_ID_Cotizacion_Details();
                $xCodDetalle    = $ObjDetalleDoc->codigo;

                $www_Cantidad   = trim($Array_Cantidad[$w]);
                $www_UnitMed    = trim($Array_UnitMed[$w]);
                $www_Producto   = trim($Array_Producto[$w]);
                $www_Coment     = trim($Array_Coment[$w]);
                $www_PreUnit    = trim($Array_PreUnit[$w]);
                $www_Total      = trim($Array_Total[$w]);

                $arrayCampos_wv2    = [
                    'id'=>$xCodDetalle,
                    'sales_quotations_id'=>$id_cotizacion,
                    'quantity'=>$www_Cantidad,
                    'unity_id'=>$www_UnitMed,
                    'products_id'=>$www_Producto,
                    'coment'=>$www_Coment,
                    'unit_price'=>$www_PreUnit,
                    'total'=>$www_Total
                ];

                $rpta_v2 = SalesQuote::Registrar_Cotizacion_DET($arrayCampos_wv2);            

            }

        }

        return trim($valor);
    }




   public function PrintQuotations($idcab){

        $xData  = array();

        $xData['DatoEmpresa']       = SalesQuote::Data_Empresa();
        $xData['DatoCabQuote_CAB']  = SalesQuote::Data_sales_quotations_x_ID_CAB([ 'id_cab'=>$idcab ]);
        $xData['DatoCabQuote_DET']  = SalesQuote::Data_sales_quotations_x_ID_DET([ 'id_cab'=>$idcab ]);

        return view('mintos.pages.sales_quote.PrintQuote', ['wDataVta' => $xData]);

    }




    
}
