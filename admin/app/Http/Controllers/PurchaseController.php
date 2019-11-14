<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\InputOrder;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\SiteVourcher;
use App\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class PurchaseController extends Controller
{
    protected $_moduleDB    = 'purchase';
    protected $_page        = 21;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Compras',
                'url' => route( 'purchase.index' )
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if( ! $request->ajax() ) return redirect( '/' );

        $numPerPage = 20;
        $search     = $request->search;
        $response   = [];

        $data = Purchase::where('purchases.status', '!=', 2)
            ->join( 'type_vouchers', 'type_vouchers.id', '=', 'purchases.type_vouchers_id' )
            ->join( 'purchase_orders', 'purchase_orders.id', '=', 'purchases.purchase_orders_id' )
            ->join( 'providers', 'providers.id', '=', 'purchase_orders.provider_id' )
            ->join( 'type_documents', 'type_documents.id', '=', 'providers.type_document' )
            ->select(
                'purchases.id',
                'purchases.purchase_orders_id',
                'purchases.type_vouchers_id',
                'purchases.type_payment_methods_id',
                'purchases.serial_doc',
                'purchases.number_doc',
                'purchases.subtotal',
                'purchases.igv',
                'purchases.total',
                'purchases.status',
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = [
            [
                'name' => 'Compras',
                'url' => route( 'purchase.index' )
            ],
            [
                'name' => 'Registro',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'subMenu'       => 'purchase-form'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( ! $request->ajax() ) return redirect( '/' );

        $user = Auth::user();
        $site = session('siteDefault');
        $subTotal = 0;
        $total = 0;
        $igv = 0;
        $date       = new DateTime( $request->date );

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->sites_id        = $site;
        $purchaseOrder->provider_id     = $request->provider;
        $purchaseOrder->quotations_id   = 0;
        $purchaseOrder->user_reg        = $user->id;
        $purchaseOrder->user_aproved    = $user->id;
        $purchaseOrder->code            = 'Automatic';
        $purchaseOrder->date_reg        = date('Y-m-d');

        if( $purchaseOrder->save() ) {

            $purchase = new Purchase();
            $purchase->purchase_orders_id       = $purchaseOrder->id;
            $purchase->type_vouchers_id         = $request->typeVoucher;
            $purchase->type_payment_methods_id  = 1;
            $purchase->serial_doc               = $request->serial;
            $purchase->number_doc               = $request->number;
            $purchase->save();

            foreach ( $request->details as $detail ) {
                $purchaseOrderDetail = new PurchaseOrderDetail();
                $purchaseOrderDetail->purchase_orders_id    = $purchaseOrder->id;
                $purchaseOrderDetail->presentation_id       = $detail['id'];
                $purchaseOrderDetail->quantity              = $detail['quantity'];
                $purchaseOrderDetail->price_unit            = $detail['priceUnit'];
                $purchaseOrderDetail->total                 = $detail['quantity'] * $detail['priceUnit'];
                $purchaseOrderDetail->save();

                $purchaseDetail = new PurchaseDetail();
                $purchaseDetail->purchases_id       = $purchase->id;
                $purchaseDetail->presentation_id    = $detail['id'];
                $purchaseDetail->quantity           = $detail['quantity'];
                $purchaseDetail->price_unit         = $detail['priceUnit'];
                $purchaseDetail->total              = $detail['quantity'] * $detail['priceUnit'];
                $purchaseDetail->save();

                $subTotal += ( $detail['quantity'] * $detail['priceUnit'] );
            }

            if( $request->typeVoucher == 5 ) {
                $igv    = $this::IGV * $subTotal;
                $total  = $subTotal + $igv;

                $purchaseOrder->subtotal    = round( $subTotal , 2 );
                $purchaseOrder->igv         = round( $igv, 2 );
                $purchaseOrder->total       = round( $total, 2 );
                $purchaseOrder->save();

                $purchase->subtotal = round( $subTotal, 2 );
                $purchase->igv      = round( $igv, 2 );
                $purchase->total    = round( $total, 2 );
                $purchase->save();
            } else {
                $purchaseOrder->subtotal    = round( $subTotal,2);
                $purchaseOrder->igv         = 0;
                $purchaseOrder->total       = round( $subTotal, 2);
                $purchaseOrder->save();

                $purchase->subtotal = round( $subTotal, 2);
                $purchase->igv      = 0;
                $purchase->total    = round( $subTotal, 2);
                $purchase->save();
            }

            $typeVoucher        = 6;
            $SiteVoucherClass   = new SiteVourcher();
            $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher );

            $inputOrder = new InputOrder();
            $inputOrder->purchases_id   = $purchase->id;
            $inputOrder->code           = $correlative['correlative'];
            $inputOrder->date_input_reg = date( 'Y-m-d' );
            $inputOrder->user_reg       = $user->id;
            $inputOrder->date_input     = date( 'Y-m-d' );

            if( $inputOrder->save() ) {
                $SiteVoucherClass->increaseCorrelative( $typeVoucher );
            }

            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
