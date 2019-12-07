<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\InputOrder;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\SiteVourcher;
use App\Provider;
use App\PurchaseOrder;
use App\TypeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class PurchaseController extends Controller
{
    protected $_moduleDB    = 'purchase';
    protected $_page        = 21;

    const PATH_UPLOAD = '/uploads/purchases/';

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

        $data = Purchase::where( 'purchases.status', '!=', 2 )
            ->whereNotIn( 'purchases.status', [ 0, 2 ] )
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
                'purchases.attach',
                'type_vouchers.name as typeVouchersName',
                'providers.name as providerName',
                'providers.document',
                'type_documents.name as typeDocuments'
            )
            ->orderBy( 'date_reg', 'desc' )
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
    public function create( Request $request )
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
            'subMenu'       => 'purchase-form',
            'purchase'      => $request->id
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request )
    {
        if( ! $request->ajax() ) return redirect( '/' );

        $id = $request->id ? $request->id : 0;

        if( $id > 0 ) {

            $purchase       = Purchase::findOrFail( $id );
            $purchaseOrder  = PurchaseOrder::findOrFail( $purchase->purchase_orders_id );
            $provider       = Provider::findOrFail( $purchaseOrder->provider_id );
            $typeDocument   = TypeDocument::findOrFail( $provider->type_document );
            $numDocProvider = $typeDocument->name . ': ' . $provider->document;
            $details        = [];

            $purchaseDetail = PurchaseDetail::where( 'purchase_details.status', 1 )
                ->where( 'purchase_details.purchases_id', $id )
                ->join( 'presentation', 'presentation.id', '=', 'purchase_details.presentation_id' )
                ->join( 'unity', 'unity.id', '=', 'presentation.unity_id' )
                ->leftJoin('products', 'products.id', '=', 'presentation.products_id')
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'purchase_details.id',
                    'purchase_details.quantity',
                    'purchase_details.price_unit',
                    'purchase_details.sub_total',
                    'purchase_details.total',
                    'presentation.sku',
                    'presentation.description',
                    'unity.name as unity',
                    'products.name as product',
                    'categories.name as category'
                )
                ->get();

            foreach( $purchaseDetail as $item ) {
                $row = new \stdClass();
                $row->id = $item->id;
                $row->priceUnit = $item->price_unit;
                $row->quantity = $item->quantity;
                $row->subTotal = $item->sub_total;
                $row->image = asset( '/assets/dist/img/product-thumb1.png' );
                $row->name = $item->category . ' ' . $item->product . ' ' . $item->description;
                $row->sku = $item->sku;

                $details[] = $row;
            }

            $response = [
                'status' => true,
                'header' => [
                    'provider' => [
                        'name'  => $provider->name,
                        'doc'   => $numDocProvider
                    ],
                    'purchase' => [
                        'subtotal' => $purchase->subtotal,
                        'igv' => $purchase->igv,
                        'total' => $purchase->total
                    ]
                ],
                'details' => $details
            ];

            return response()->json( $response );
        }

        return response()->json([
            'status' => false,
            'msg'   => 'No se puede obtener los datos.'
        ]);
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
    public function update(Request $request)
    {
        $dateIssue = new DateTime($request->date);
        $id = $request->id;

        $purchase = Purchase::findOrFail( $id );
        $purchase->type_vouchers_id = $request->typeVoucher;
        $purchase->serial_doc = $request->serial;
        $purchase->number_doc = $request->number;
        $purchase->date_issue = $dateIssue->format( 'Y-m-d');
        $purchase->subtotal = $request->subTotal;
        $purchase->igv = $request->igv;
        $purchase->total = $request->total;
        $purchase->status = 3;
        if ( $request->hasFile('fileVoucher') ) {
            $purchase->attach = $this->uploadVoucher( $request->file('fileVoucher') );
        }
        $purchase->save();

        $this->updateDetails( $request->details );

        $this->logAdmin('Completo los datos para la compra ID::' . $id );

        return response()->json([
            'status' => true,
        ]);
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

    private function uploadVoucher( $file ) {

        $destinationPath = public_path(self::PATH_UPLOAD );
        $newImage = 'purchases-' . time() . '.' . $file->getClientOriginalExtension();
        $file->move( $destinationPath, $newImage );
        return $newImage;
    }

    private function updateDetails( $details ) {
        foreach ( $details as $detail ) {
            $item = json_decode( $detail );
            $purchaseDetail = PurchaseDetail::findOrFail( $item->id );
            $purchaseDetail->price_unit = $item->priceUnit;
            $purchaseDetail->sub_total = $item->subTotal;
            $purchaseDetail->total = $item->subTotal;
            $purchaseDetail->save();
        }
    }

    public function payPurchase( $id ) {
        $purchase = Purchase::findOrFail( $id );
        if( $purchase->status === 3 ) {
            $purchase->status = 4;
            $this->logAdmin('Marco como pagado la compra ID::' . $id );
        }
        $purchase->save();
        return response()->json([
            'status' => true
        ]);
    }

    public function upload( Request $request ) {
        $purchase = Purchase::findOrFail( $request->id );
        if ( $request->hasFile('fileVoucher') ) {
            $purchase->attach = $this->uploadVoucher( $request->file('fileVoucher') );
        }
        $purchase->save();
        return response()->json([
            'status' => true
        ]);
    }
}
