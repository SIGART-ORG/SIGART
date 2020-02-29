<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\InputOrder;
use App\Models\Kardex;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\SiteVourcher;
use App\Models\Stock;
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

        $numPerPage = 20;
        $search     = $request->search;
        $response   = [];

        $data = InputOrder::where( 'input_orders.status', '!=', 2 )
            ->where( 'purchases.status', '!=', 2 )
            ->join( 'purchases', 'purchases.id', '=', 'input_orders.purchases_id' )
            ->join( 'type_vouchers', 'type_vouchers.id', '=', 'purchases.type_vouchers_id' )
            ->join( 'purchase_orders', 'purchase_orders.id', '=', 'purchases.purchase_orders_id' )
            ->join( 'providers', 'providers.id', '=', 'purchase_orders.provider_id' )
            ->join( 'type_documents', 'type_documents.id', '=', 'providers.type_document' )
            ->select(
                'input_orders.id',
                'input_orders.purchases_id',
                'input_orders.code',
                'input_orders.date_input_reg',
                'input_orders.date_input',
                'input_orders.status',
                'purchases.type_vouchers_id',
                'purchases.serial_doc',
                'purchases.number_doc',
                'type_vouchers.name as typeVouchersName',
                'providers.name as providerName',
                'providers.document',
                'type_documents.name as typeDocuments'
            )
            ->paginate( $numPerPage );

        $response['pagination'] = [
            'total'         => $data->total(),
            'current_page'  => $data->currentPage(),
            'per_page'      => $data->perPage(),
            'last_page'     => $data->lastPage(),
            'from'          => $data->firstItem(),
            'to'            => $data->lastItem()
        ];
        $response['records'] = $data;

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
                'voucher'               => $inputOrder->code,
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
        $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucherIO );

        if( $correlative['status'] ) {

            $user = Auth::user();
            $inputOrder = InputOrder::findOrFail( $request->id );
            $purchase = Purchase::findOrFail( $inputOrder->purchases_id );
            $purchaseOrder = PurchaseOrder::findOrFail( $purchase->purchase_orders_id );

            if( $inputOrder->status === 1 && $purchase->status === 0 && $purchaseOrder->status === 3 ) {

                $inputOrder->date_input = date('Y-m-d');
                $inputOrder->user_input = $user->id;
                $inputOrder->code = $correlative['correlative'];
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
}
