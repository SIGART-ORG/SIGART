<?php

namespace App\Http\Controllers;

use App\Access;
use App\Http\Requests\Admin\SaveOutputOrderRequest;
use App\Http\Requests\Admin\ShowOutputOrderRequest;
use App\Models\OutputOrder;
use App\Models\OutputOrderDetails;
use App\Models\ServiceRequirement;
use App\Models\SiteVourcher;
use App\Models\ToolLog;
use App\Models\ToolStock;
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

    public function index( Request $request ) {

        $outputOrders = [];
        $type = $request->type;

        $records = OutputOrder::whereNotIn( 'status', [0, 2])
            ->where( function ( $q ) use( $type ) {
                if( $type === 'delivered' ) {
                    $q->whereIn( 'stage', [2, 3]);
                }
            })
            ->orderBy( 'date_input_reg', 'desc' )
            ->paginate( self::PAGINATE );

        foreach( $records as $record ) {
            $user = $record->userOutput;
            $userData = $this->getDataUser( $user );

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
            $row->user = $userData;

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
                    $servReq->stage = 1;
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
        $outputOrder['userOutput'] = $output->user_output;

        $details = [];
        foreach ( $output->ouputsOrderDetails->where('status', 1) as $detail ) {
            $presentation = $detail->presentation;
            $stock = $presentation->toolStocks->where('sites_id', session( 'siteDefault' ) )->first();
            $row = new \stdClass();
            $row->id = $detail->id;
            $row->presentation = $presentation->id;
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

    public function save( SaveOutputOrderRequest $request, $id ) {

        $outputOrder = OutputOrder::findOrfail( $id );
        $outputOrder->user_output = $request->userOutput;
        if( $outputOrder->stage === 0 ) {
            $outputOrder->stage = 1;

            $sr = ServiceRequirement::find( $outputOrder->service_requirements_id );
            if( $sr && $sr->stage === 1 ) {
                $sr->stage = 2;
                $sr->save();
            }
        }
        $outputOrder->save();

        $details = $request->details;
        if( count( $details ) > 0 ) {
            OutputOrderDetails::where( 'output_orders_id', $id )->where( 'status', 1 )
                ->update(['status' => 0]);

            foreach ( $details as $detail ) {
                $outputOrderDetail = OutputOrderDetails::find( $detail['id'] );
                if( $outputOrderDetail ) {
                    $outputOrderDetail->status = 1;
                    $outputOrderDetail->delivered_quantity = $detail['deliveredQuantity'];
                    $outputOrderDetail->save();
                }
            }
        }

        return response()->json([
            'status' => true,
            'msg' => 'OK.'
        ], 200);
    }

    public function send( Request $request ) {
        $id = $request->id;
        $outputOrder = OutputOrder::findOrfail( $id );
        $outputOrder->stage = 2;
        $sr = ServiceRequirement::find( $outputOrder->service_requirements_id );
        if( $sr && $sr->stage === 2 ) {
            $sr->stage = 3;
            $sr->save();
        }

        if( $outputOrder->save() ) {

            OutputOrderDetails::where( 'output_orders_id', $id )->where( 'status', 1 )
                ->update(['is_delivered' => 1]);

            $details = $outputOrder->ouputsOrderDetails->where('status', 1)->where('is_delivered', 1);

            foreach ( $details as $detail ) {
                $presentation = $detail->presentation_id;
                $quantity = $detail->delivered_quantity;
                $this->updateStock( $presentation, $quantity, $id );
            }
        }

        return response()->json([
            'status' => true,
            'msg' => 'OK.'
        ], 200);
    }

    private function updateStock( $presentation, $stockNew, $outputOrder ) {
        $site = session( 'siteDefault' );
        $stock = ToolStock::where( 'presentation_id', $presentation )
            ->where( 'sites_id', $site )
            ->first();

        if( !$stock ) {

            $stock = new ToolStock();
            $stock->presentation_id = $presentation;
            $stock->sites_id = $site;
            $stock->stock = (-1) * ($stockNew);
            $stock->save();
            $diference = (-1) * $stockNew;
            $this->updateToolLog( $stock->id, $diference, $diference, true, $outputOrder );
        } else {
            $diference = ( -1 * ( $stock->stock - $stockNew ) );
            $this->updateToolLog( $stock->id, $diference, $stock->stock - $stockNew, false, $outputOrder );
            $stock->stock = $stock->stock - $stockNew;
            $stock->save();
        }
    }

    private function updateToolLog( $stockId, $diference, $totalNew, $isNew = false, $outputOrder ) {
        if( $diference !== 0 ) {
            $toolLog = new ToolLog();
            $toolLog->tool_stocks_id = $stockId;
            if ($diference > 0) {
                $comment = 'Se aumento el stock a ' . $totalNew . ' unidades.';
                if ($isNew) {
                    $comment = 'Se agregó herramienta con stock inicial de ' . $diference . ' unidades.';
                }
                $toolLog->input = $diference;
            } else {
                $comment = 'Se redujó el stock a ' . $totalNew . ' unidades.';
                $toolLog->output = abs( $diference );
            }

            $toolLog->output_orders_id = $outputOrder;
            $toolLog->total = $totalNew;
            $toolLog->comment = $comment;
            $toolLog->save();
        }
    }
}
