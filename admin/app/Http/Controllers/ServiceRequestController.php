<?php

namespace App\Http\Controllers;

use App\Models\SalesQuotationsDetails;
use App\Models\ServicePaymentMethod;
use App\SalesQuote;
use Illuminate\Http\Request;
use App\Access;
//use App\ServiceRequest;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDetail;
use App\EnLetras;
use App\Funciones;

class ServiceRequestController extends Controller
{
    protected $_moduleDB = 'sales_quote';
    protected $_page = 28;

    public function dashboard()
    {

        $xData = array();

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


    public function RegisterServiceRequest(Request $request)
    {

        $sites_id = '1';
        $cbo_TipDocumento = ($request->input('cbo_TipDocumento')) ? $request->input('cbo_TipDocumento') : '';
        $cbo_Customers = '1';
        $xuser_reg = '1';
        $txt_totalReqmto = ($request->input('txt_totalReqmto')) ? $request->input('txt_totalReqmto') : '';
        $txt_observacion = ($request->input('txt_observacion')) ? $request->input('txt_observacion') : '';

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

        $ObjSolicitud = ServiceRequest::Generate_ID_Solic_Request();
        $id_solicitud = $ObjSolicitud->codigo;

        $ObjNumDocum = ServiceRequest::Generate_Num_Request();
        $xnum_request = $ObjNumDocum->num_request;

        $arrayCampos = [
            'id' => $id_solicitud,
            'sites_id' => $sites_id,
            'type_vouchers_id' => $cbo_TipDocumento,
            'date_emission' => Funciones::Cambiar_fecha_a_Mysql($xFechaHoy),
            'num_request' => $xnum_request,
            'customers_id' => $cbo_Customers,
            'user_reg' => $xuser_reg,
            'user_aproved' => $xuser_reg,
            'description' => 'Solicitud de Requerimiento',
            'observation' => $txt_observacion
        ];

        $Insertado = ServiceRequest::Registrar_SolRequest_CAB($arrayCampos);
        $valor = ($Insertado) ? $id_solicitud : '0';

        //####################################################################
        //####################################################################
        //####################################################################

        if ($valor > 0) {


            for ($w = 0; $w < count($Array_Producto); $w++) {

                $ObjDetalleDoc = ServiceRequest::Generate_ID_Solic_Request_Details();
                $xCodDetalle = $ObjDetalleDoc->codigo;

                $www_Cantidad = trim($Array_Cantidad[$w]);
                $www_UnitMed = trim($Array_UnitMed[$w]);
                $www_Producto = trim($Array_Producto[$w]);
                $www_Coment = trim($Array_Coment[$w]);
                $www_PreUnit = trim($Array_PreUnit[$w]);
                $www_Total = trim($Array_Total[$w]);

                $arrayCampos_wv2 = [
                    'id' => $xCodDetalle,
                    'service_requests_id' => $id_solicitud,
                    'name' => $www_Producto,
                    'quantity' => $www_Cantidad,
                    'description' => $www_Coment,
                    'assumed_customer' => $cbo_Customers
                ];

                $rpta_v2 = ServiceRequest::Registrar_SolRequest_DET($arrayCampos_wv2);

            }

        }

        return trim($valor);
    }


    public function PrintQuotations($codRequest)
    {

        $xData = array();

        $xData['DatoEmpresa'] = ServiceRequest::Data_Empresa();
        $xData['DatoCabQuote_CAB'] = ServiceRequest::Data_sales_quotations_x_ID_CAB(['id_cab' => $codRequest]);
        $xData['DatoCabQuote_DET'] = ServiceRequest::Data_sales_quotations_x_ID_DET(['id_cab' => $codRequest]);

        return view('mintos.pages.sales_quote.PrintQuote', ['wDataVta' => $xData]);

    }


    /******************Listado***************/
    public function dashboardServices()
    {

        $this->_moduleDB = "services_request";

        $breadcrumb = [
            [
                'name' => 'Solicitud de Contizacion',
                'url' => route('services_request.list')
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar($this->_page);
        return view('mintos.content', [
            'menu' => $this->_page,
            'sidebar' => $permiso,
            'moduleDB' => $this->_moduleDB,
            'breadcrumb' => $breadcrumb,
            'tipo' => "no-derive"
        ]);

    }

    public function listServices(Request $request)
    {
        $derive = $request->type && $request->type === 'derive' ? 1 : 0;

        $response = ServiceRequest::whereIn('status', [1,3])
            ->where('is_send', 1)
            ->where('derive_request', $derive)
            ->orderBy('date_send', 'desc')
            ->paginate(20);

        $serviceRequest = [];

        foreach ($response as $sr) {
            $row = new \stdClass();
            $row->id = $sr->id;
            $row->document = $sr->num_request;
            $row->send = date('d/m/Y h:ia', strtotime($sr->date_send));
            $row->isDerive = $sr->derive_request == 1 ? true : false;
            $row->status = $sr->status;
            $row->description = $sr->description;
            $row->items = $sr->serviceRequestDetails->where('status', 1)->count();
            $customer = $sr->customer;
            $name = $customer->name;
            if ($customer->type_person === 1) {
                $name .= ' ' . $customer->lastname;
            }
            $document = $customer->typeDocument->name . ': ' . $customer->document;

            $row->customer = new \stdClass();
            $row->customer->id = $customer->id;
            $row->customer->name = $name;
            $row->customer->document = $document;

            $row->saleQuotation = new \stdClass();
            $row->saleQuotation->exist = false;
            $objSaleQuotation = $sr->salesQuotations->whereNotIn( 'status', [0, 1, 2, 5, 7, 9] )->first;
            if( $objSaleQuotation->id ) {
                $dataSQ = $objSaleQuotation->id;
                $row->saleQuotation->exist = true;
                $row->saleQuotation->id = $dataSQ->id;
                $row->saleQuotation->document = $dataSQ->num_serie . '-' . $dataSQ->num_doc;
                $row->saleQuotation->total = $dataSQ->tot_gral;
                $row->saleQuotation->status = $dataSQ->status;
            }

            $serviceRequest[] = $row;
        }

        return [
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $serviceRequest
        ];
    }

    public function derive(Request $request)
    {
        $services = ServiceRequest::findOrFail($request->id);
        $services->derive_request = 1;
        $services->status = 3;
        if ($services->save()) {
            return response()->json(["rpt" => 1]);
        }
    }


    public function detail(Request $request)
    {
        $response = ServiceRequestDetail::where('status', 1)->where('service_requests_id', $request->id)->get();
        return [

            'records' => $response
        ];
    }

    public function dashboardServicesDerive()
    {
        $this->_moduleDB = "services_request";

        $breadcrumb = [
            [
                'name' => 'Contizaciones Derivadas',
                'url' => route('services_request.list')
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar($this->_page);
        return view('mintos.content', [
            'menu' => $this->_page,
            'sidebar' => $permiso,
            'moduleDB' => $this->_moduleDB,
            'breadcrumb' => $breadcrumb,
            'tipo' => "derive"
        ]);

    }

    public function data(Request $request)
    {

        $response = [
            'status' => false
        ];

        $sr = $request->service ? $request->service : 0;

        $existSalesQuotation = SalesQuote::generateSalesQuotation($sr);

        if ($existSalesQuotation['status']) {

            $serviceRequest = ServiceRequest::findOrfail($sr);

            if( $existSalesQuotation['new'] ) {
                SalesQuotationsDetails::generateItems($existSalesQuotation['collection']);
            }

            $salesQuotations = $existSalesQuotation['collection'];
            $quotationsDetails = $salesQuotations->salesQuotationsDetails->where('status', 1);

            $details = [];

            foreach ($quotationsDetails as $det) {
                $details[] = [
                    'id' => $det->id,
                    'description' => $det->description,
                    'quantity' => $det->quantity,
                    'subTotal' => $det->sub_total,
                    'discount' => $det->discount,
                    'includesProducts' => $det->includes_products === 1 ? true : false,
                    'totalProducts' => $det->total_products,
                    'igv' => $det->igv,
                    'total' => $det->total,
                    'type' => $det->type
                ];
            }

            $dateDelivery = $salesQuotations->serviceRequest->delivery_date;
            $dateDelivery = $dateDelivery ? date( 'd/m/Y', strtotime( $dateDelivery ) ) : '';

            $quotations = [
                'id' => $salesQuotations->id,
                'activity' => $salesQuotations->activity,
                'objective' => $salesQuotations->objective,
                'dateDelivery' => $dateDelivery,
                'paymentMethods' => $salesQuotations->service_payment_methods_id,
                'execution' => $salesQuotations->execution_time_days,
                'warranty' => $salesQuotations->warranty_num,
                'status' => $salesQuotations->status,
                'document' => $salesQuotations->num_serie . '-' . $salesQuotations->num_doc,
                'total' => $salesQuotations->tot_gral,
                'totalLetter' => $salesQuotations->total_letter,
                'start' => $salesQuotations->date_start ? $salesQuotations->date_start : '',
                'end' => $salesQuotations->date_end ? $salesQuotations->date_end : '',
                'details' => $details,
            ];

            $methodPayments = [];
            $methodPaymentDatas = ServicePaymentMethod::all();
            foreach ( $methodPaymentDatas as $methodPayment ) {
                $row = new \stdClass();
                $row->id = $methodPayment->id;
                $row->title = $methodPayment->title;
                $row->description = $methodPayment->description;
                $methodPayments[] = $row;
            }

            $response = [
                'status' => true,
                'summary' => [
                    'description' => $serviceRequest->num_request,
                    'attachment' => $serviceRequest->attachment,
                    'quotations' => $quotations,
                    'methodPayments' => $methodPayments
                ]
            ];

        } else {
            $response['msg'] = 'No se pudo obtener los registros solicitados';
        }


        return response()->json($response);
    }

    public function listTypeDashboard( Request $request ) {

        $type = $request->type ? $request->type : '';

        $typePermits = [
            'to-be-approved',
            'to-be-approved-second',
            'to-be-approved-customer',
            'approved',
            'cancel'
        ];

        if( in_array( $type, $typePermits ) ) {

            switch ( $type ) {
                case 'to-be-approved':
                    $title = 'Servicios: Cotizaciones por aprobar ( Administración )';
                    break;
                case 'to-be-approved-second':
                    $title = 'Servicios: Cotizaciones por aprobar ( Ejecutivo )';
                    break;
                case 'to-be-approved-customer':
                    $title = 'Servicios: Cotizaciones por aprobar ( Cliente )';
                    break;
                case 'approved':
                    $title = 'Servicios: Cotizaciones aprobadas';
                    break;
                case 'cancel':
                    $title = 'Servicios: Cotizaciones anuladas';
                    break;
            }

            $breadcrumb = [
                [
                    'name' => $title,
                    'url' => route( 'services-request.type.list', ['type' => $type] )
                ],
                [
                    'name' => 'Listado',
                    'url' => '#'
                ]
            ];

            $this->_page = 0;
            $this->_moduleDB = 'sales-quotation';
            $permiso = Access::sideBar( $this->_page );
            return view('mintos.content', [
                'menu'          => $this->_page,
                'sidebar'       => $permiso,
                'moduleDB'      => $this->_moduleDB,
                'breadcrumb'    => $breadcrumb,
                'type'          => $type
            ]);
        }

        return redirect( '/' );
    }

    /*
     * $request->type
     * to-be-approved: 1° por aprobar( Administración ) - 3
     * cancel: rechazados - 0,2,5,7,9
     * to-be-approved-second: 2° por aprobar(dirección general) - 4
     * to-be-approved-customer: 2° por aprobar(dirección cliente) - 6
     * approved: Por generar estructura de servicio - 8
     * */

    public function listTypeData( Request $request ) {

        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación',
            'data' => []
        ];

        $type = $request->type ? $request->type : '';

        $saleQuotation = new SalesQuote();
        $canceledState = $saleQuotation::CANCELED_STATE;

        switch ( $type ) {
            case 'to-be-approved':
                $data = $this->listData( [3] );
                $response['title'] = 'Servicios: Cotizaciones por aprobar ( Administración )';
                $response['status'] = true;
                $response['msg'] = 'OK';
                break;
            case 'to-be-approved-second':
                $data = $this->listData( [4] );
                $response['title'] = 'Servicios: Cotizaciones por aprobar ( Ejecutivo )';
                $response['status'] = true;
                $response['msg'] = 'OK';
                break;
            case 'to-be-approved-customer':
                $data = $this->listData( [6] );
                $response['title'] = 'Servicios: Cotizaciones por aprobar ( Cliente )';
                $response['status'] = true;
                $response['msg'] = 'OK';
                break;
            case 'approved':
                $data = $this->listData( [8] );
                $response['title'] = 'Servicios: Cotizaciones aprobadas';
                $response['status'] = true;
                $response['msg'] = 'OK';
                break;
            case 'cancel':
                $data = $this->listData( $canceledState );
                $response['title'] = 'Servicios: Cotizaciones anuladas';
                $response['status'] = true;
                $response['msg'] = 'OK';
                break;
        }

        if( ! empty( $data ) ) {
            $response['pagination'] = $data['pagination'];
            $response['data'] = $data['data'];
        }
        return response()->json( $response );
    }

    private function listData( $type ) {

        $paginate = 20;
        $data = [
            'pagination' => [],
            'data' => []
        ];

        $salesQuotations = SalesQuote::whereIn( 'status', $type )
            ->orderBy('updated_at', 'desc')
            ->paginate( $paginate );

        if( $salesQuotations ) {

            $data['pagination'] = [
                'total' => $salesQuotations->total(),
                'current_page' => $salesQuotations->currentPage(),
                'per_page' => $salesQuotations->perPage(),
                'last_page' => $salesQuotations->lastPage(),
                'from' => $salesQuotations->firstItem(),
                'to' => $salesQuotations->lastItem()
            ];

            foreach ($salesQuotations as $saleQuotation) {
                $row = new \stdClass();
                $row->id = $saleQuotation->id;
                $row->status = $saleQuotation->status;
                $row->document = $saleQuotation->num_serie . '-' . $saleQuotation->num_doc;
                $row->emission = $saleQuotation->date_emission ? date('d/m/Y',
                    strtotime($saleQuotation->date_emission)) : '---';
                $row->start = $saleQuotation->date_start ? date('d/m/Y', strtotime($saleQuotation->date_start)) : '---';
                $row->end = $saleQuotation->date_end ? date('d/m/Y', strtotime($saleQuotation->date_end)) : '---';
                $row->total = $saleQuotation->tot_gral;
                $row->subtotal = $saleQuotation->subtot_sale;
                $row->discount = $saleQuotation->tot_dscto;
                $row->existReferenceTerm = false;
                if( $saleQuotation->status === 8 ) {
                    $countReferenceTerm = $saleQuotation->referenceterms->where( 'status', '!=', 2 )->count();
                    $row->existReferenceTerm = $countReferenceTerm > 0 ? true : false;
                }

                $serviceRequest = $saleQuotation->serviceRequest;
                $row->serviceRequest = new \stdClass();
                $row->serviceRequest->id = $serviceRequest->id;
                $row->serviceRequest->send = $serviceRequest->date_send ? date('d/m/Y',
                    strtotime($serviceRequest->date_send)) : '---';
                $row->serviceRequest->document = $serviceRequest->num_request;
                $row->serviceRequest->attachment = $serviceRequest->attachment;
                $row->serviceRequest->description = $serviceRequest->description;
                $row->serviceRequest->status = $serviceRequest->status;

                $customer = $serviceRequest->customer;
                $name = $customer->name;
                if ($customer->type_person === 1) {
                    $name .= ' ' . $customer->lastname;
                }
                $document = $customer->typeDocument->name . ': ' . $customer->document;

                $row->customer = new \stdClass();
                $row->customer->id = $customer->id;
                $row->customer->name = $name;
                $row->customer->document = $document;

                $row->canceled = new \stdClass();
                $row->canceled->status = false;
                switch( $saleQuotation->status ) {
                    case 5:
                        $userData = $saleQuotation->userFirst;
                        $row->canceled->user = $userData ? $userData->name . ' ' . $userData->last_name : '';
                        $row->canceled->status = true;
                        break;
                    case 7:
                        $userData = $saleQuotation->userSecond;
                        $row->canceled->user = $userData ? $userData->name . ' ' . $userData->last_name : '';
                        $row->canceled->status = true;
                        break;
                }

                $data['data'][] = $row;
            }
        }

        return $data;
    }
}
