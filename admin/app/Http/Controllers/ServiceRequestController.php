<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\ServiceRequest;
use App\Models\ServiceRequestDetail;
use App\EnLetras;
use App\Funciones;

class ServiceRequestController extends Controller
{
    protected $_moduleDB = 'sales_quote';
    protected $_page = 28;

    public function dashboard()
    {

        $xData   = array();

        $permiso = Access::sideBar();
        $xData['DataTypeDocuments'] = ServiceRequest::List_Type_Documents();
        $xData['FechaHoy'] = date('d-m-Y');
        $xData['DataNumDocument'] = ServiceRequest::Generate_Num_Request();
        $xData['DataProducts'] = ServiceRequest::List_Products();
        $xData['DataUnities'] = ServiceRequest::List_Unitys();

        $breadcrumb = [
            [
                'name' => 'Solicitud de Requerimiento',
                'url' => '/servicerequest/dashboard'
            ],
            [
                'name' => 'Registro',
                'url' => '#'
            ]
        ];

        $xData = [
            "menu" => 23,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB,
            "wData" => $xData,
            "breadcrumb" => $breadcrumb
        ];



        return view('mintos.pages.service_request.principal', $xData);
    }




    public function RegisterServiceRequest(Request $request){

        $sites_id      = '1';
        $cbo_TipDocumento   = ( $request->input('cbo_TipDocumento') ) ? $request->input('cbo_TipDocumento') : '';
        $cbo_Customers      = '1';
        $xuser_reg      = '1';
        $txt_totalReqmto    = ( $request->input('txt_totalReqmto') ) ? $request->input('txt_totalReqmto') : '';
        $txt_observacion    = ( $request->input('txt_observacion') ) ? $request->input('txt_observacion') : '';

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

        $ObjSolicitud  = ServiceRequest::Generate_ID_Solic_Request();
        $id_solicitud     = $ObjSolicitud->codigo;

        $ObjNumDocum    = ServiceRequest::Generate_Num_Request();
        $xnum_request       = $ObjNumDocum->num_request;

        $arrayCampos = [
            'id'=>$id_solicitud,
            'sites_id'=>$sites_id,
            'type_vouchers_id'=>$cbo_TipDocumento,
            'date_emission'=>Funciones::Cambiar_fecha_a_Mysql($xFechaHoy),
            'num_request'=>$xnum_request,
            'customers_id'=>$cbo_Customers,
            'user_reg'=>$xuser_reg,
            'user_aproved'=>$xuser_reg,
            'description'=>'Solicitud de Requerimiento',
            'observation'=>$txt_observacion
        ];

        $Insertado = ServiceRequest::Registrar_SolRequest_CAB($arrayCampos);
        $valor = ($Insertado) ? $id_solicitud : '0';

        //####################################################################
        //####################################################################
        //####################################################################

        if($valor>0){


            for ( $w = 0; $w < count($Array_Producto); $w++){

                $ObjDetalleDoc  = ServiceRequest::Generate_ID_Solic_Request_Details();
                $xCodDetalle    = $ObjDetalleDoc->codigo;

                $www_Cantidad   = trim($Array_Cantidad[$w]);
                $www_UnitMed    = trim($Array_UnitMed[$w]);
                $www_Producto   = trim($Array_Producto[$w]);
                $www_Coment     = trim($Array_Coment[$w]);
                $www_PreUnit    = trim($Array_PreUnit[$w]);
                $www_Total      = trim($Array_Total[$w]);

                $arrayCampos_wv2    = [
                    'id'=>$xCodDetalle,
                    'service_requests_id'=>$id_solicitud,
                    'name'=>$www_Producto,
                    'quantity'=>$www_Cantidad,
                    'description'=>$www_Coment,
                    'assumed_customer'=>$cbo_Customers
                ];

                $rpta_v2 = ServiceRequest::Registrar_SolRequest_DET($arrayCampos_wv2);

            }

        }

        return trim($valor);
    }




   public function PrintQuotations($codRequest){

        $xData  = array();

        $xData['DatoEmpresa']       = ServiceRequest::Data_Empresa();
        $xData['DatoCabQuote_CAB']  = ServiceRequest::Data_sales_quotations_x_ID_CAB([ 'id_cab'=>$codRequest ]);
        $xData['DatoCabQuote_DET']  = ServiceRequest::Data_sales_quotations_x_ID_DET([ 'id_cab'=>$codRequest ]);

        return view('mintos.pages.sales_quote.PrintQuote', ['wDataVta' => $xData]);

    }



    /******************Listado***************/
    public function dashboardServices(){

        $this->_moduleDB = "services_request";

        $breadcrumb = [
            [
                'name' => 'Solicitud de Contizacion',
                'url' => route( 'services_request.list' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
        ]);

    }

    public function listServices(){
        $response = ServiceRequest::where('status',1)->where('is_send',1)->where('derive_request',0)->paginate(20);
        return [
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $response
        ];
    }

    public function derive(Request $request){
        $services = ServiceRequest::findOrFail($request->id);
        $services->derive_request = 1;
        if ($services->save()) {
            return response()->json(["rpt" => 1]);
        }
    }



    public function detail(Request $request){
        $response = ServiceRequestDetail::where('status',1)->where('service_requests_id',$request->id)->get();
        return [

            'records' => $response
        ];
    }

    public function listServicesDerive(){
        $response = ServiceRequest::where('status',1)->where('is_send',1)->where('derive_request',1)->paginate(20);
        return [
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $response
        ];
    }



}
