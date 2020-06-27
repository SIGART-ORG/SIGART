<?php

namespace App\Http\Controllers;

use App\Models\SalesQuotationsDetails;
use Illuminate\Http\Request;
use App\Access;
use App\SalesQuote;
use App\EnLetras;
use App\Funciones;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class SalesQuoteController extends Controller
{
    protected $_moduleDB = 'sales_quote';

    public function dashboard()
    {

        $xData = array();

        $permiso = Access::sideBar();
        $xData['DataTypeDocuments'] = SalesQuote::List_Type_Documents();
        $xData['DataCustomers'] = SalesQuote::List_Customers();
        $xData['FechaHoy'] = date('d-m-Y');
        $xData['DataNumSerie'] = SalesQuote::Generate_Num_Serie();
        $xData['DataNumDocument'] = SalesQuote::Generate_Num_Document();
        $xData['DataTypeServices'] = SalesQuote::ListTypeServices();
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


    public function ListProductxTipService($codTypServ)
    {

        $xData = array();
        $cbo_TipoServicio_ADD = ($codTypServ != '') ? $codTypServ : '0';
        $xData['DataProducts'] = SalesQuote::List_Products_x_TypeService(['cod_type_service' => $cbo_TipoServicio_ADD]);
        return json_encode($xData);
    }


    public function searchProduct(Request $request)
    {

        $xData = array();
        $x_codigo = ($request->input('x_codigo')) ? $request->input('x_codigo') : '';

        $xData['vProducto'] = SalesQuote::View_Data_Product_x_ID(['products_id' => $x_codigo]);

        return json_encode($xData);
    }


    public function ViewTotalLetters(Request $request)
    {

        $valor = ($request->input('valor')) ? $request->input('valor') : '0';
        $Valor_Letras = EnLetras::ValorEnLetras($valor, '');
        return $Valor_Letras;

    }


    public function RegisterSales(Request $request)
    {

        $cbo_TipDocumento = ($request->input('cbo_TipDocumento')) ? $request->input('cbo_TipDocumento') : '';
        $cbo_Customers = ($request->input('cbo_Customers')) ? $request->input('cbo_Customers') : '';
        $txt_tot_a_pagar = ($request->input('txt_tot_a_pagar')) ? $request->input('txt_tot_a_pagar') : '';
        $txt_observacion = ($request->input('txt_observacion')) ? $request->input('txt_observacion') : '';


        $cbo_descuento = ($request->input('cbo_descuento')) ? $request->input('cbo_descuento') : '0';
        $txt_subtotalVta = ($request->input('txt_subtotalVta')) ? $request->input('txt_subtotalVta') : '';
        $txh_valIGV = ($request->input('txh_valIGV')) ? $request->input('txh_valIGV') : '';
        $txt_igvVta = ($request->input('txt_igvVta')) ? $request->input('txt_igvVta') : '';
        $txt_totalVta = ($request->input('txt_totalVta')) ? $request->input('txt_totalVta') : '';
        $txt_total_letras = ($request->input('txt_total_letras')) ? $request->input('txt_total_letras') : '';

        $x_Cantidad = ($request->input('Array_Cantidad')) ? $request->input('Array_Cantidad') : '';
        $x_UnitMed = ($request->input('Array_UnitMed')) ? $request->input('Array_UnitMed') : '';
        $x_Productos = ($request->input('Array_Productos')) ? $request->input('Array_Productos') : '';
        $x_Comentario = ($request->input('Array_Comentario')) ? $request->input('Array_Comentario') : '';
        $x_PrecUnit = ($request->input('Array_PrecUnit')) ? $request->input('Array_PrecUnit') : '';
        $x_Total = ($request->input('Array_Total')) ? $request->input('Array_Total') : '';

        $Array_Cantidad = array();
        $Array_Cantidad = isset($x_Cantidad) ? explode(',', $x_Cantidad) : '';

        $Array_UnitMed = array();
        $Array_UnitMed = isset($x_UnitMed) ? explode(',', $x_UnitMed) : '';

        $Array_Producto = array();
        $Array_Producto = isset($x_Productos) ? explode(',', $x_Productos) : '';

        $Array_Coment = array();
        $Array_Coment = isset($x_Comentario) ? explode(',', $x_Comentario) : '';

        $Array_PreUnit = array();
        $Array_PreUnit = isset($x_PrecUnit) ? explode(',', $x_PrecUnit) : '';

        $Array_Total = array();
        $Array_Total = isset($x_Total) ? explode(',', $x_Total) : '';

        //=============================================================================
        //=============================================================================
        //=============================================================================

        $xFechaHoy = date('d-m-Y');

        $ObjCotizacion = SalesQuote::Generate_ID_Cotizacion();
        $id_cotizacion = $ObjCotizacion->id_cotizacion;

        $ObjNumSerie = SalesQuote::Generate_Num_Serie();
        $xnum_serie = $ObjNumSerie->num_serie;

        $ObjNumDocum = SalesQuote::Generate_Num_Document();
        $xnum_doc = $ObjNumDocum->num_doc;

        $valorDscto = (($cbo_descuento * 1) / 100) * $txt_tot_a_pagar;


        $arrayCampos = [
            'id' => $id_cotizacion,
            'type_vouchers_id' => $cbo_TipDocumento,
            'date_emission' => Funciones::Cambiar_fecha_a_Mysql($xFechaHoy),
            'num_serie' => $xnum_serie,
            'num_doc' => $xnum_doc,
            'customers_id' => $cbo_Customers,
            'tot_sale' => $txt_tot_a_pagar,
            'porc_dscto' => $cbo_descuento,
            'tot_dscto' => $valorDscto,
            'subtot_sale' => $txt_subtotalVta,
            'porc_igv' => $txh_valIGV,
            'tot_igv' => $txt_igvVta,
            'tot_gral' => $txt_totalVta,
            'total_letter' => $txt_total_letras,
            'observation' => $txt_observacion

        ];

        $Insertado = SalesQuote::Registrar_Cotizacion_CAB($arrayCampos);
        $valor = ($Insertado) ? $id_cotizacion : '0';

        //####################################################################
        //####################################################################
        //####################################################################

        if ($valor > 0) {

            for ($w = 0; $w < count($Array_Producto); $w++) {

                $ObjDetalleDoc = SalesQuote::Generate_ID_Cotizacion_Details();
                $xCodDetalle = $ObjDetalleDoc->codigo;

                $www_Cantidad = trim($Array_Cantidad[$w]);
                $www_UnitMed = trim($Array_UnitMed[$w]);
                $www_Producto = trim($Array_Producto[$w]);
                $www_Coment = trim($Array_Coment[$w]);
                $www_PreUnit = trim($Array_PreUnit[$w]);
                $www_Total = trim($Array_Total[$w]);

                $arrayCampos_wv2 = [
                    'id' => $xCodDetalle,
                    'sales_quotations_id' => $id_cotizacion,
                    'quantity' => $www_Cantidad,
                    'unity_id' => $www_UnitMed,
                    'products_id' => $www_Producto,
                    'coment' => $www_Coment,
                    'unit_price' => $www_PreUnit,
                    'total' => $www_Total
                ];

                $rpta_v2 = SalesQuote::Registrar_Cotizacion_DET($arrayCampos_wv2);

            }

        }

        return trim($valor);
    }


    public function PrintQuotations($idcab)
    {

        $xData = array();

        $xData['DatoEmpresa'] = SalesQuote::Data_Empresa();
        $xData['DatoCabQuote_CAB'] = SalesQuote::Data_sales_quotations_x_ID_CAB(['id_cab' => $idcab]);
        $xData['DatoCabQuote_DET'] = SalesQuote::Data_sales_quotations_x_ID_DET(['id_cab' => $idcab]);

        return view('mintos.pages.sales_quote.PrintQuote', ['wDataVta' => $xData]);

    }

    /*nuevo*/

    public function listSalesQuotations(Request $request)
    {

    }

    public function saveData(Request $request)
    {
        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];

        $quotation = $request->quotation ? $request->quotation : 0;
        $details = $request->details ? $request->details : [];
        $start = $request->start ? date( 'Y-m-d', strtotime( $request->start ) ) : NULL;
        $end = $request->end ? date( 'Y-m-d', strtotime( $request->end ) ) : NULL;
        $activity = $request->activity;
        $objective = $request->objective;
        $paymentMethods = $request->paymentMethods;
        $execution = $request->execution;
        $warranty = $request->warranty;

        $salesQuotations = SalesQuote::findOrfail($quotation);

        if ($salesQuotations->status === 1) {

            $totals = SalesQuotationsDetails::updateItems($details);

            $salesQuotations->date_start = $start;
            $salesQuotations->date_end = $end;
            $salesQuotations->activity = $activity;
            $salesQuotations->objective = $objective;
            $salesQuotations->execution_time_days = $execution;
            $salesQuotations->service_payment_methods_id = $paymentMethods;
            $salesQuotations->warranty_num = $warranty;
            $salesQuotations->subtot_sale = $totals['subtotal'];
            $salesQuotations->porc_dscto = $totals['discountPorc'];
            $salesQuotations->tot_dscto = $totals['discount'];
            $salesQuotations->porc_igv = $totals['igvPorc'];
            $salesQuotations->tot_igv = $totals['igv'];
            $salesQuotations->tot_gral = $totals['total'];

            if( $salesQuotations->save() ) {
                $response[ 'status' ] = true;
                $response['msg'] = 'OK';
            }
        }

        return response()->json($response);
    }

    public function sendQuotation( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];
        $quotation = $request->quotation ? $request->quotation : 0;
        $salesQuotations = SalesQuote::findOrfail($quotation);

        if ($salesQuotations->status === 1) {
            $salesQuotations->status = 3;
            if( $salesQuotations->save() ) {
                $response[ 'status' ] = true;
                $response['msg'] = 'OK';
            }
        }

        return response()->json($response);
    }

    public function action( Request $request )
    {

        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];

        $type = $request->type ? $request->type : '';
        $action = $request->action ? $request->action : '';
        $quotation = $request->quotation ? $request->quotation : 0;

        $salesQuotations = SalesQuote::findOrfail($quotation);

        $userId = Auth()->user()->id;

        switch ($type) {
            case 'to-be-approved':
                if ( $salesQuotations->status === 3 ) {
                    if( $action === 'approval' ) {
                        $salesQuotations->status = 4;
                        $salesQuotations->type_reply = 1;
                        $salesQuotations->user_reply = $userId;
                        $salesQuotations->date_reply = date( 'Y-m-d H:i:s' );
                        $this->logAdmin( 'Aprobó la cotización de servicio ( Administración ) ID::' . $salesQuotations->id );
                    } elseif( $action === 'cancel' ) {
                        $salesQuotations->status = 5;
                        $salesQuotations->type_reply = 2;
                        $salesQuotations->user_reply = $userId;
                        $salesQuotations->date_reply = date( 'Y-m-d H:i:s' );
                        $this->logAdmin( 'Anuló la cotización de servicio ( Administración ) ID::' . $salesQuotations->id );
                    } elseif( $action === 'again' ) {
                        $salesQuotations->status = 1;
                        $salesQuotations->type_reply = 0;
                        $salesQuotations->user_reply = 0;
                        $salesQuotations->date_reply = Null;
                        $salesQuotations->type_reply_second = 0;
                        $salesQuotations->user_reply_second = 0;
                        $salesQuotations->date_reply_second = Null;
                        $this->logAdmin( 'Envió nuevamente a cotizar ID::' . $salesQuotations->id );
                    }
                    if ($salesQuotations->save()) {
                        $response['status'] = true;
                        $response['msg'] = 'OK';
                    }
                }
                break;
            case 'to-be-approved-second':
                if ($salesQuotations->status === 4) {
                    if( $action === 'approval' ) {
                        $salesQuotations->status = 6;
                        $salesQuotations->type_reply_second = 1;
                        $salesQuotations->user_reply_second = $userId;
                        $salesQuotations->date_reply_second = date( 'Y-m-d H:i:s' );
                        $salesQuotations->date_expiration = $this->calculateExpiration( $salesQuotations->effective_days );
                        $customer = $salesQuotations->customer;
                        $serviceRequest = $salesQuotations->serviceRequest;
                        if( $serviceRequest ) {
                            $serviceRequest->is_send = 2;
                            $serviceRequest->save();
                        }
                        if( $customer && $customer->email ) {
                            $template = 'quotation-request';
                            $vars = [
                                'name' => $customer->name
                            ];
                            $this->sendMail($customer->email, 'Solicitud de orden de servicio', $template, $vars);
                        }
                        $this->logAdmin( 'Aprobó la cotización de servicio ( Dirección General ) ID::' . $salesQuotations->id );
                    } elseif( $action === 'cancel' ) {
                        $salesQuotations->status = 7;
                        $salesQuotations->type_reply_second = 2;
                        $salesQuotations->user_reply_second = $userId;
                        $salesQuotations->date_reply_second = date( 'Y-m-d H:i:s' );
                        $this->logAdmin( 'Anuló la cotización de servicio ( Dirección General ) ID::' . $salesQuotations->id );
                    } elseif( $action === 'again' ) {
                        $salesQuotations->status = 1;
                        $salesQuotations->type_reply = 0;
                        $salesQuotations->user_reply = 0;
                        $salesQuotations->date_reply = Null;
                        $salesQuotations->type_reply_second = 0;
                        $salesQuotations->user_reply_second = 0;
                        $salesQuotations->date_reply_second = Null;
                        $this->logAdmin( 'Envió nuevamente a cotizar ID::' . $salesQuotations->id );
                    }
                    if ($salesQuotations->save()) {
                        $response['status'] = true;
                        $response['msg'] = 'OK';
                    }
                }
                break;
            case 'to-be-approved-customer':
                if ($salesQuotations->status === 6) {
                    if( $action === 'approval-customer' ) {
                        $salesQuotations->status = 8;
                        $salesQuotations->is_approved_customer = 1;
                        $salesQuotations->date_approved_customer = date( 'Y-m-d H:i:s' );
                        $this->logAdmin( 'Aprobó la cotización de servicio ( Cliente ) ID::' . $salesQuotations->id );
                    } elseif( $action === 'cancel' ) {
                        $salesQuotations->status = 9;
                        $salesQuotations->is_approved_customer = 2;
                        $salesQuotations->date_approved_customer = date( 'Y-m-d H:i:s' );
                        $this->logAdmin( 'Anuló la cotización de servicio ( Cliente ) ID::' . $salesQuotations->id );
                    } elseif( $action === 'again' ) {
                        $salesQuotations->status = 1;
                        $salesQuotations->type_reply = 0;
                        $salesQuotations->user_reply = 0;
                        $salesQuotations->date_reply = Null;
                        $salesQuotations->type_reply_second = 0;
                        $salesQuotations->user_reply_second = 0;
                        $salesQuotations->date_reply_second = Null;
                        $this->logAdmin( 'Envió nuevamente a cotizar ID::' . $salesQuotations->id );
                    }

                    if ($salesQuotations->save()) {
                        $response['status'] = true;
                        $response['msg'] = 'OK';
                    }
                }
                break;
        }

        return response()->json($response);
    }

    private function calculateExpiration( $numDays ) {
        $today = date( 'Y-m-d' );

        $contador = 1;
        while ( $contador <= $numDays ) {
            $today = date( 'Y-m-d', strtotime($today. ' + 1 day') );
            $numberDay = date( 'N', strtotime( $today ) );
            if( $numberDay === '6' ) {
                $today = date( 'Y-m-d', strtotime($today. ' + 2 day') );
            }
            if( $numberDay === '7' ) {
                $today = date( 'Y-m-d', strtotime($today. ' + 1 day') );
            }

            $contador++;
        }

        return $today;
    }

    public function detail( Request $request ) {
        $response = [
            'status' => false
        ];

        $sr = $request->sr ? $request->sr : 0;
        $existSalesQuotation = SalesQuote::generateSalesQuotation($sr);

        if ( $existSalesQuotation['status'] ) {
            if( $existSalesQuotation['new'] ) {
                SalesQuotationsDetails::generateItems($existSalesQuotation['collection']);
            }

            $response['status'] = true;
            $response['data'] = $this->informationData( $existSalesQuotation['collection']->id );
        }

        return response()->json( $response );
    }

    private function informationData( $id ) {

        $saleQuotation = SalesQuote::findOrFail( $id );

        $data = new \stdClass();
        $data->id = $saleQuotation->id;
        $data->activity = $saleQuotation->activity;
        $data->objective = $saleQuotation->objective;
        $data->execution = $saleQuotation->execution_time_days;
        $data->paymentMethods = $saleQuotation->servicePaymentMethod->description;
        $data->warranty = $saleQuotation->warranty_num;
        $data->effective = $saleQuotation->effective_days;
        $data->dateExpiration = $saleQuotation->date_expiration ? date( 'd/m/Y', strtotime( $saleQuotation->date_expiration ) ) : '';
        $data->document = $saleQuotation->num_serie . '-' . $saleQuotation->num_doc;
        $data->subtotal = $saleQuotation->subtot_sale;
        $data->discount = $saleQuotation->tot_dscto;
        $data->discountPorc = $saleQuotation->porc_dscto;
        $data->igv = $saleQuotation->tot_igv;
        $data->igvPorc = $saleQuotation->porc_igv;
        $data->total = $saleQuotation->tot_gral;
        $data->details = $this->getDetailsSalesQuotations( $saleQuotation->salesQuotationsDetails );
        $data->status = $saleQuotation->status;

        $userDataFirst = $saleQuotation->userFirst;
        $data->administration = new \stdClass();
        $data->administration->type = $this->typeAction( $saleQuotation->type_reply );
        $data->administration->user = $userDataFirst ? $userDataFirst->name . ' ' . $userDataFirst->last_name : '';

        $userDataSecond = $saleQuotation->userSecond;
        $data->generalDirection = new \stdClass();
        $data->generalDirection->type = $this->typeAction( $saleQuotation->type_reply_second );
        $data->generalDirection->user = $userDataSecond ? $userDataSecond->name . ' ' . $userDataSecond->last_name : '';

        $customer = $saleQuotation->customer;
        $customerLogin = $saleQuotation->customerLogin;
        $name = $customer->name;
        if ($customer->type_person === 1) {
            $name .= ' ' . $customer->lastname;
        }
        $document = $customer->typeDocument->name . ': ' . $customer->document;
        $data->customer = new \stdClass();
        $data->customer->id = $customer->id;
        $data->customer->name = $name;
        $data->customer->document = $document;
        $data->customer->action = $this->typeAction( $saleQuotation->is_approved_customer );
        $data->customer->login = $customerLogin ? $customerLogin->name : '';

        $serviceRequest = $saleQuotation->serviceRequest;
        $data->serviceRequest = new \stdClass();
        $data->serviceRequest->id = $serviceRequest->id;
        $data->serviceRequest->document = $serviceRequest->num_request;
        $data->serviceRequest->description = $serviceRequest->description;
        $data->serviceRequest->observation = $serviceRequest->observation;
        $data->serviceRequest->approved = $serviceRequest->date_aproved ? date( 'd/m/Y', strtotime( $serviceRequest->date_aproved ) ) : '---';
        $data->serviceRequest->send = $serviceRequest->date_send ? date( 'd/m/Y', strtotime( $serviceRequest->date_send ) ) : '---';
        $data->serviceRequest->status = $serviceRequest->status;
        $data->serviceRequest->details = $this->getDetailsServiceRequest( $serviceRequest->serviceRequestDetails );

        return $data;
    }

    public function information( Request $request ) {

        $id = $request->id;

        $data = $this->informationData( $id );

        $response = [];
        $response['status'] = true;
        $response['data'] = $data;

        return response()->json( $response );
    }

    private function getDetailsServiceRequest( $details ) {
        $data = [];
        if( ! empty( $details ) ) {
            foreach ( $details as $detail ) {
                $row = new \stdClass();
                $row->id = $detail->id;
                $row->item = $detail->description;
                $row->quantity = $detail->quantity;

                $data[] = $row;
            }
        }

        return $data;
    }

    private function getDetailsSalesQuotations( $details ) {
        $data = [];
        if( ! empty( $details ) ) {
            foreach ( $details as $detail ) {
                $row = new \stdClass();
                $row->id = $detail->id;
                $row->description = $detail->description;
                $row->quantity = $detail->quantity;
                $row->includesProducts = $detail->includes_products;
                $row->discount = $detail->discount;
                $row->totalProducts  = $detail->total_products ;
                $row->workforce  = $detail->workforce ;
                $row->total = $detail->total;
                $row->type = $detail->type;
                $row->details = $this->getDetailsSalesProducts( $detail->quotationProducstDetails );

                $data[] = $row;
            }
        }

        return $data;
    }

    private function getDetailsSalesProducts( $details ) {
        $data = [];
        if( ! empty( $details ) ) {
            foreach ( $details as $detail ) {
                $presentation = $detail->presentation;
                $product = $presentation->product;

                $nameProduct = $product ? $product->category->name . ' ' . $product->name : '';
                $nameProduct .= $presentation->description;

                $row = new \stdClass();
                $row->id = $detail->id;
                $row->item = $nameProduct;
                $row->quantity = $detail->quantity;
                $row->difference = $detail->difference;
                $row->price = $detail->price;
                $row->unity = $presentation->unity->name;

                $data[] = $row;
            }
        }

        return $data;
    }

    private function typeAction( $type ) {
        $typesAction = [
            '---',
            'Aprobado',
            'Anulado'
        ];

        return $typesAction[$type];
    }

}
