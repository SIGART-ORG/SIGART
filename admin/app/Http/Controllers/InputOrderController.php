<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\InputOrder;
use App\Models\InputOrderDetail;
use App\Models\Kardex;
use App\Models\OutputOrder;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\SiteVourcher;
use App\Models\Stock;
use App\Models\ToolLog;
use App\Models\ToolStock;
use App\Models\TypeVoucher;
use App\PurchaseOrder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputOrderController extends Controller
{
    protected $_moduleDB    = 'input-order';
    protected $_page        = 25;
    protected $_sub_menu    = '';

    /*
     * @const
     * PRICE_BUY_PROC = 5% = 5/100
     */
    const PRICE_BUY_PROC = 0.05;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Ordenes de entradas',
                'url' => route( 'input-order.index' )
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

    public function index( Request $request ){
        if( ! $request->ajax() ) return redirect( '/' );

        $search     = $request->search;
        $response   = [];

        $records = InputOrder::where( 'input_orders.status', '!=', 2 )
            ->orWhereHas( 'purchase', function ($q) {
                $q->where( 'status', '!=', 2 );
            })
            ->paginate( self::PAGINATE );

        $inputOrders = [];
        foreach ( $records as $record ) {
            $purchase = $record->purchase;
            $purchaseOrder = $purchase ? $purchase->purchaseOrder : null;
            $provider = $purchaseOrder ? $purchaseOrder->provider : null;

            $providerData = $this->getDataProviderV2( $provider );

            $row = new \stdClass();
            $row->id = $record->id;
            $row->document = $record->serial_doc . '-' . $record->number_doc;
            $row->inputReg = $this->getDateFormat( $record->date_input_reg );
            $row->input = $this->getDateFormat( $record->date_input );
            $row->status = $record->status;
            $row->purchase = new \stdClass();
            $row->purchase->id = $purchase ? $purchase->id : 0;
            $row->purchase->typeDocument = $purchase ? $purchase->typeVoucher->name : '---';
            $row->purchase->document = $purchase ? $purchase->serial_doc . '-' . $purchase->number_doc : '---';
            $row->provider = $providerData;

            $inputOrders[] = $row;
        }

        $response['pagination'] = [
            'total'         => $records->total(),
            'current_page'  => $records->currentPage(),
            'per_page'      => $records->perPage(),
            'last_page'     => $records->lastPage(),
            'from'          => $records->firstItem(),
            'to'            => $records->lastItem()
        ];
        $response['records'] = $inputOrders;

        return response()->json( $response );
    }

    public function show ( Request $request ) {

        $inputOrder     = InputOrder::findOrFail( $request->id );
        $purchase       = Purchase::findOrFail( $inputOrder->purchases_id );
        $purchaseOrder  = PurchaseOrder::findOrFail( $purchase->purchase_orders_id );
        $typeVoucher    = TypeVoucher::findOrFail( $purchase->type_vouchers_id );
        $userClass      = new User();

        $userReg = $userClass::findOrFail( $inputOrder->user_reg );
        $userAproved = ( $inputOrder->user_input > 0 ? $userClass::findOrFail( $inputOrder->user_input ) : false );


        $purchaseDetails = PurchaseOrderDetail::where( 'purchase_order_details.status', 1 )
            ->where( 'purchase_order_details.purchase_orders_id', $purchase->purchase_orders_id )
            ->join( 'presentation', 'presentation.id', '=', 'purchase_order_details.presentation_id')
            ->join( 'products', 'products.id', '=', 'presentation.products_id' )
            ->join( 'categories', 'categories.id', '=', 'products.category_id' )
            ->join( 'unity', 'unity.id', '=', 'presentation.unity_id' )
            ->select(
                'purchase_order_details.id',
                'purchase_order_details.presentation_id',
                'purchase_order_details.quantity',
                'purchase_order_details.price_unit',
                'purchase_order_details.is_confirmed',
                'presentation.description',
                'presentation.sku',
                'products.name as product',
                'categories.name as category',
                'unity.name as unity'
            )
            ->get();
        $response = [
            'status'    => true,
            'message'   => 'ok',
            'items'     => $purchaseDetails,
            'headers'   => [
                'voucher'               => $inputOrder->serial_doc . '-' . $inputOrder->number_doc,
                'purchaseVoucher'       => $purchase->serial_doc . '-' . $purchase->number_doc,
                'purchaseTypeVoucher'   => $typeVoucher->name,
                'purchaseOrder'         => $purchaseOrder->code,
                'userReg'               => $userReg->name . ' ' . $userReg->last_name,
                'userApproved'          => ( $userAproved ? $userAproved->name . ' ' . $userAproved->last_name : '---' ),
                'dateReg'               => date( 'd/m/Y', strtotime( $inputOrder->date_input_reg ) ),
                'dateApproved'          => ( $inputOrder->status === 3 ? date( 'd/m/Y', strtotime( $inputOrder->date_input ) ) : '---' ),
                'status'                => $inputOrder->status
            ]
        ];

        return response()->json( $response );
    }

    public function approvedInputDetail( Request $request ) {

        $typeVoucherIO      = 6;
        $SiteVoucherClass   = new SiteVourcher();
        $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucherIO, 'details' );

        if( $correlative['status'] ) {

            $user = Auth::user();
            $inputOrder = InputOrder::findOrFail( $request->id );
            $purchase = Purchase::findOrFail( $inputOrder->purchases_id );
            $purchaseOrder = PurchaseOrder::findOrFail( $purchase->purchase_orders_id );

            if( $inputOrder->status === 1 && $purchase->status === 0 && $purchaseOrder->status === 3 ) {

                $inputOrder->date_input = date('Y-m-d');
                $inputOrder->user_input = $user->id;
                $inputOrder->serial_doc = $correlative['correlative']['serie'];
                $inputOrder->number_doc = $correlative['correlative']['number'];
                $inputOrder->status = 3;
                $inputOrder->save();
                $SiteVoucherClass->increaseCorrelative($typeVoucherIO);

                $purchase->status = 1;
                $purchase->save();

                $purchaseOrder->status = 4;
                $purchaseOrder->save();

                PurchaseOrderDetail::where( 'purchase_orders_id', $purchaseOrder->id )
                    ->where( 'status', '=', 1 )
                    ->update([
                        'is_confirmed' => 1,
                    ]);

                $purchaseDetail = PurchaseDetail::where('status', 1)
                    ->where('purchases_id', $inputOrder->purchases_id)
                    ->select(
                        'id',
                        'presentation_id',
                        'quantity',
                        'price_unit'
                    )
                    ->get();

                foreach ($purchaseDetail as $detail) {
                    $stockClass = new Stock();
                    $kardexClass = new Kardex();
                    $priceUnit = floatval($detail->price_unit);
                    $priceBuy = round(($priceUnit + (self::PRICE_BUY_PROC * $priceUnit)), 2);

                    $stock = $stockClass::where('sites_id', session('siteDefault'))
                        ->where('presentation_id', $detail->presentation_id)
                        ->first();

                    if ( ! empty($stock)) {
                        $stock->stock += $detail->quantity;
                        $stock->price = $detail->price_unit;
                        $stock->price_buy = $priceBuy;
                        $stock->save();
                        $idStock = $stock->id;
                    } else {
                        $stockClass->sites_id = session('siteDefault');
                        $stockClass->presentation_id = $detail->presentation_id;
                        $stockClass->stock = $detail->quantity;
                        $stockClass->price = $detail->price_unit;
                        $stockClass->price_buy = $priceBuy;
                        $stockClass->save();
                        $idStock = $stockClass->id;
                    }

                    if ($idStock > 0) {
                        $lastPriceUnit = 0;
                        $productTotal = 0;
                        $totalItemProduct = ($detail->quantity * $detail->price_unit);
                        $kardexLast = $kardexClass::where('stocks_id', $idStock)->orderBy('id', 'desc')->first();
                        if ( ! empty($kardexLast)) {
                            $lastPriceUnit = $kardexLast->last_price_unit_purchase;
                            $productTotal = $kardexLast->total;
                        }
                        $productTotal += $detail->quantity;

                        $kardexClass->stocks_id = $idStock;
                        $kardexClass->input_orders_id = $inputOrder->id;
                        $kardexClass->quantity_input = $detail->quantity;
                        $kardexClass->total = $productTotal;
                        $kardexClass->price_total_purchase = $totalItemProduct;
                        $kardexClass->price_unit_purchase = $detail->price_unit;
                        $kardexClass->last_price_unit_purchase = $lastPriceUnit;
                        $kardexClass->price_buy = $priceBuy;
                        $kardexClass->save();
                    }
                }

                if (count($purchaseDetail) > 0) {
                    return response()->json([
                        'status' => true
                    ]);
                }

            } else {

                $msg = [];
                if( $inputOrder->status !== 1 ) {
                    $msg[] = 'La orden de entrada ya fue aprobada';
                }

                if( $purchase->status !== 0 ) {
                    $msg[] = 'La compra ya fue registrada.';
                }

                if( $purchaseOrder->status !== 3 ) {
                    $msg[] = 'La orden de compra ya fue aprobada.';
                }

                return response()->json([
                    'status' => false,
                    'msg' => implode( ', ', $msg )
                ]);
            }

        }

        return response()->json([
            'status' => false,
            'msg' => 'Falta asignar los correlativos para ordenes de entrada'
        ]);
    }

    public function pageApproved( Request $request ) {

        $inputOrder = InputOrder::find( $request->id );
        $purchase = Purchase::find( $inputOrder->purchases_id );
        $purchaseOrder = PurchaseOrder::find( $purchase->purchase_orders_id );

        $this->_page = 28;
        $this->_sub_menu    = 'inputorderdetail';

        $breadcrumb = [
            [
                'name' => 'Ordenes de entradas',
                'url' => route( 'input-order.index' )
            ],
            [
                'name' => $purchaseOrder->code,
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar( $this->_page );

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'subMenu'       => $this->_sub_menu,
            'id'            => $request->id
        ]);
    }

    public function recordEntryOrder( Request $request ) {

        $response = [
            'status' => false,
            'msg' => ''
        ];

        $output = $request->output;
        $details = $request->details;

        $oo = OutputOrder::findOrFail( $output );

        $typeVoucher        = 6;
        $SiteVoucherClass   = new SiteVourcher();
        $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher, 'details' );

        if( $correlative['status'] ) {
            $user = Auth::user();
            $io = new InputOrder();
            $io->output_orders_id = $output;
            $io->serial_doc = $correlative['correlative']['serie'];
            $io->number_doc = $correlative['correlative']['number'];
            $io->date_input_reg = date('Y-m-d');
            $io->date_input = date('Y-m-d');
            $io->user_reg = $user->id;
            $io->user_input = $user->id;
            $io->user_delivered = $oo->user_output;
            $io->type = $oo->type_outorder;
            $io->status = 3;
            if( $io->save() ) {
                $SiteVoucherClass->increaseCorrelative($typeVoucher);
                if ($oo->type_outorder === 2) {
                    $this->storeDetails( $io->id, $details, $oo->type_outorder );
                }

                $oo->stage = 3;
                if( $oo->save() ) {
                    $sr = $oo->serviceRequirement;
                    if( $sr ) {
                        $sr->stage = 4;
                        $sr->save();
                    }

                }

                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        } else {
            $response['msg'] = 'No se generaron los correlativos correspondientes.';
        }

        return response()->json( $response, 200 );
    }

    private function storeDetails( $orderId, $details, $type ) {
        foreach ( $details as $detail ) {
            $iod = new InputOrderDetail();
            $iod->input_orders_id = $orderId;
            $iod->presentation_id = $detail['presentation'];
            $iod->quantity = $detail['giveBack'];
            $iod->is_delivered = 1;
            $iod->comment = $detail['comment'];

            if( $iod->save() ) {
                $this->alterToolStock( $orderId, $detail['presentation'], $detail['giveBack'], $detail['comment'] );
            }
        }
    }

    private function alterToolStock( $orderId, $presentation, $alterStock, $comment ) {
        $alterStock = (double)$alterStock;
        $site = session( 'siteDefault' );
        $stock = ToolStock::where( 'presentation_id', $presentation )
            ->where( 'sites_id', $site )
            ->first();

        if( $stock ) {
            $idStock = $stock->id;
            $currentStock = $stock->stock;

            $newStock =  $currentStock + $alterStock;

            $stock->stock = $newStock;
            if( $stock->save() ) {
                $this->addLogTools( $orderId, $idStock,$alterStock, $newStock, $comment );
            }

        }
    }

    private function addLogTools( $orderId, $idStock, $addStock, $newStock, $comment = '' ) {
        $log = new ToolLog();
        $log->tool_stocks_id = $idStock;
        $log->input_orders_id =$orderId;
        $log->input = $addStock;
        $log->total = $newStock;
        $log->comment = 'Se agregó ' . $addStock . ' unidad(es) al stock. ' . $comment;
        $log->save();
        return true;
    }
}
