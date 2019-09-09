<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\PurchaseOrderDetail;
use App\PurchaseOrder;
use App\Quotation;
use App\QuotationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    protected $_moduleDB    = 'purchase-order';
    protected $_page        = 20;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Ordenes de compra (OC)',
                'url' => route( 'purchase-order.index' )
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

    public function generate( Request $request ) {
        if( ! $request->ajax() ) return redirect( '/' );

        $response = [
            'status' => false,
            'msg' => ''
        ];

        $quotation = Quotation::findOrFail( $request->id );

        if( $quotation->status === 4 ) {

            $user_id    = Auth::user()->id;
            $cant       = 0;
            $total   = 0;

            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->sites_id        = 1;/*ID de la sede principal*/
            $purchaseOrder->provider_id     = $quotation->providers_id;
            $purchaseOrder->quotations_id   = $request->id;
            $purchaseOrder->user_reg        = $user_id;
            $purchaseOrder->code            = 'S/C';
            $purchaseOrder->date_reg        = date( 'Y-m-d' );
            $purchaseOrder->status          = 0;

            if( $purchaseOrder->save() ) {
                $purchaseOrderId = $purchaseOrder->id;

                $quotationDetails = QuotationDetail::where('status', 1)
                    ->where('selected', 1)
                    ->where('quotations_id', $request->id)
                    ->get();

                if( $quotationDetails ) {
                    foreach ( $quotationDetails as $details ){
                        $purchaseOrderDetail = new PurchaseOrderDetail();
                        $purchaseOrderDetail->purchase_orders_id = $purchaseOrderId;
                        $purchaseOrderDetail->presentation_id = $details->presentation_id;
                        $purchaseOrderDetail->quantity = $details->quantity;
                        $purchaseOrderDetail->price_unit = $details->unit_price;
                        $purchaseOrderDetail->sub_total = $details->total;/*ya no se usara*/
                        $purchaseOrderDetail->igv = 0;/*Solo se usara en la tabla Purchase order*/
                        $purchaseOrderDetail->total = $details->total;
                        if( $purchaseOrderDetail->save() ) {
                            $cant++;
                            $total += $details->total;
                        }
                    }
                }
            }

            if( $cant > 0 ) {
                $subTotal   = ( 100 / 118 ) * $total;
                $igv        = ( $this::IGV * $subTotal );
                $purchaseOrder->status  = 1;
                $purchaseOrder->subtotal    = round( $subTotal, 2 );
                $purchaseOrder->igv         = round( $igv, 2 );
                $purchaseOrder->total       = round( $total, 2 );

                $quotation->status = 5;
                $quotation->save();

                if( $purchaseOrder->save() ) {
                    $response['status'] = true;
                    $response['msg']    = 'OK';

                    $this->logAdmin( 'Orden de compra generado ID::' . $purchaseOrder->id );
                } else {
                    $response['msg']    = 'Error al intentar guardar los datos.';
                    $this->logAdmin( 'No se pudo actualizar orden de compra ID::' . $purchaseOrder->id );
                }

            } else {
                $response['msg']    = 'La cotización no tiene items.';
                $this->logAdmin( 'Orden de compra anulado por falta de items ID::' . $purchaseOrder->id );
            }

        } else {
            $response['msg'] = 'No se pudo realizar la operación.';
        }

        return response()->json( $response );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if( ! $request->ajax() ) return redirect( '/' );

        $response   = [];
        $numPerPage = 20;
        $search     = $request->search;

        $data = PurchaseOrder::where('purchase_orders.status', '!=', 2)
                    ->where('purchase_orders.sites_id', 1)
                    ->search( $search )
                    ->join('providers', 'providers.id', 'purchase_orders.provider_id')
                    ->orderBy('purchase_orders.id', 'desc')
                    ->select(
                        'purchase_orders.id',
                        'purchase_orders.code',
                        'purchase_orders.date_reg',
                        'purchase_orders.subtotal',
                        'purchase_orders.igv',
                        'purchase_orders.total',
                        'purchase_orders.status',
                        'providers.name',
                        'providers.business_name',
                        'providers.type_person',
                        'providers.document',
                        'providers.type_document',
                        'providers.type_document as statusProvider'
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

    public function approve( Request $request ) {
        if( ! $request->ajax() ) return redirect('/');

        $response = [
            'status'    => false,
            'msg'       => ''
        ];

        $purchaseOrder = PurchaseOrder::findOrFail( $request->id );
        if( $purchaseOrder->status === 1 ) {
            $site           = 1;

            $correlative            = PurchaseOrder::getCorrelative( $site );
            $purchaseOrder->code    = 'OC-00' . $site. '-000'. $correlative;
            $purchaseOrder->status  = 3;

            if( $purchaseOrder->save() ) {
                $response['status'] = true;
                $response['msg'] = 'OK';
                $this->logAdmin('Orden de compra aprobada ID::' . $purchaseOrder->id );
            } else {
                $response['msg'] = 'No se pudo aprobar la orden de compra.';
                $this->logAdmin('No se pudo aprobar la orden de compra ID::' . $purchaseOrder->id );
            }

        } else {
            $response['msg'] = 'No se pudo realizar la operación';
            $this->logAdmin('Intentó aprobar la Orden de compra ID::' . $purchaseOrder->id );
        }

        return response()->json( $response );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
