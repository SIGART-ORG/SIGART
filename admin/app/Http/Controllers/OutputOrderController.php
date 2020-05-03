<?php

namespace App\Http\Controllers;

use App\Access;
use App\Http\Requests\Admin\ShowOutputOrderRequest;
use App\Models\OutputOrder;
use App\Models\OutputOrderDetails;
use App\Models\ServiceRequirement;
use App\Models\SiteVourcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutputOrderController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Ordenes de salida',
                'url' => route( 'output.orders.index' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'output-order'
        ]);
    }

    public function index() {

        $outputOrders = [];

        $records = OutputOrder::whereNotIn( 'status', [0, 2])
            ->orderBy( 'date_input_reg', 'desc' )
            ->paginate( self::PAGINATE );

        foreach( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->register = date( self::DATE_FORMAT_COMP, strtotime( $record->date_input_reg ) );
            $row->stage = $record->stage;
            $row->items = $record->ouputsOrderDetails->where( 'status', 1 )->count();
            $row->service = new \stdClass();
            $row->service->id = $record->service ? $record->service->id : 0;
            $row->service->document = $record->service ? $record->service->serial_doc . '-' . $record->service->number_doc : '';
            $row->serviceRequirement = new \stdClass();
            $row->serviceRequirement->id = $record->serviceRequirement ? $record->serviceRequirement->id : 0;
            $row->serviceRequirement->document = $record->serviceRequirement ? $record->serviceRequirement->name : '';

            $outputOrders[] = $row;
        }

        return response()->json([
            'status' => true,
            'outputorders' => $outputOrders
        ], 200);

    }

    public function store( Request $request ) {

        $response = [
            'status' => false,
            'msg' => 'No se pudo realizar la operación.'
        ];

        $requirement = $request->requirement ? $request->requirement : 0;

        $servReq = ServiceRequirement::find( $requirement );
        if( $servReq && $servReq->stage === 1 ) {
            $user = Auth::user();

            $SiteVoucherClass   = new SiteVourcher();
            $typeVoucher        = 7;
            $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher, 'details' );

            if( $correlative['status'] ) {
                $outputOrder = new OutputOrder();
                $outputOrder->sites_id = session( 'siteDefault' );
                $outputOrder->services_id = $servReq->services_id;
                $outputOrder->service_requirements_id = $servReq->id;
                $outputOrder->serial_doc = $correlative['correlative']['serie'];
                $outputOrder->number_doc = $correlative['correlative']['number'];
                $outputOrder->date_input_reg = date('Y-m-d H:i:s');
                $outputOrder->user_reg = $user->id;
                $outputOrder->type_outorder = 2;

                if ($outputOrder->save()) {
                    $servReq->stage = 2;
                    $servReq->save();

                    $details = $servReq->serviceRequirementDetails->whereNotIn('status', [0, 2]);
                    foreach ($details as $detail) {
                        $outputOrderDetail = new OutputOrderDetails();
                        $outputOrderDetail->output_orders_id = $outputOrder->id;
                        $outputOrderDetail->presentation_id = $detail->presentation_id;
                        $outputOrderDetail->quantity = $detail->quantity;
                        $outputOrderDetail->delivered_quantity = $detail->quantity;
                        $outputOrderDetail->save();
                    }
                    $SiteVoucherClass->increaseCorrelative($typeVoucher);

                    $response['status'] = true;
                    $response['msg'] = 'OK.';

                }
            } else {
                $response['msg'] = 'No se puede generar el correlativo para la orden de salida.';
            }

        }

        return response()->json( $response );
    }

    public function show( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación.'
        ];
        $id = $request->id;
        $outputOrder = [];

        $output = OutputOrder::findOrFail( $id );
        $outputOrder['id'] = $output->id;
        $outputOrder['document'] = $output->serial_doc . '-' . $output->number_doc;
        $outputOrder['register'] = $this->getDateFormat( $output->date_input_reg );
        $outputOrder['comment'] = $output->comment;
        $outputOrder['stage'] = $output->stage;

        $details = [];
        foreach ( $output->ouputsOrderDetails->where('status', 1) as $detail ) {
            $presentation = $detail->presentation;
            $stock = $presentation->toolStocks->where('sites_id', session( 'siteDefault' ) )->first();
            $row = new \stdClass();
            $row->id = $detail->id;
            $row->sku = $presentation->sku;
            $row->product = $presentation->description;
            $row->priceUnit = $detail->price_unit;
            $row->quantity = $detail->quantity;
            $row->deliveredQuantity = $detail->delivered_quantity;
            $row->subTotal = $detail->subTotal;
            $row->isDelivered = $detail->is_delivered;
            $row->comment = $detail->comment;
            $row->stock = $stock->stock;

            $details[] = $row;
        }

        $response['status'] = true;
        $response['msg'] = 'OK.';
        $response['outputOrder'] = $outputOrder;
        $response['details'] = $details;

        return response()->json( $response, 200 );
    }
}
