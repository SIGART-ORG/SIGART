<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\PurchaseRequest;
use App\Quotation;
use App\QuotationDetail;
use \App\PurchaseRequestDetail;

class PurchaseRequestController extends Controller
{
    protected $_moduleDB    = 'purchase-request';
    protected $_page        = 18;

    public function dashboard(){
        $permiso = Access::sideBar( $this->_page );
        return view('modules/pages', [
            "menu"      => $this->_page,
            'sidebar'   => $permiso,
            "moduleDB"  => $this->_moduleDB
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $num_per_page = 21;
        $search = $request->search;

        $response = PurchaseRequest::where('purchase_request.status', '!=', 2)
                    ->leftJoin('users', 'purchase_request.user_reg', 'users.id')
                    ->search( $search )
                    ->select(
                        'purchase_request.id',
                        'purchase_request.user_reg',
                        'purchase_request.code',
                        'purchase_request.date',
                        'purchase_request.status',
                        'users.name',
                        'users.last_name'
                    )
                    ->selectRaw('(select 
                                    count(purchase_request_detail.id) 
                                from purchase_request_detail
                                where purchase_request_detail.purchase_request_id = purchase_request.id
                                and purchase_request_detail.status != 2
                                ) as items')
                    ->orderBy('date', 'desc')
                    ->orderBy('code', 'desc')
                    ->paginate($num_per_page);

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        if( count($request->purchaseRequest) >  0){
            $purchaseRequest = new PurchaseRequest();
            $allRegister = $purchaseRequest::count();

            $user_id = Auth::user()->id;

            $purchaseRequest->user_reg = $user_id;
            $purchaseRequest->code = date('Ymd') . '-' . ($allRegister + 1);
            $purchaseRequest->date = date('Y-m-d');
            $purchaseRequest->status = 1;

            if($purchaseRequest->save()){
                $newPurchaseRequestId = $purchaseRequest->id;
                foreach ( $request->purchaseRequest as $req ){
                    $purchaseRequestDetail = new PurchaseRequestDetail();
                    $purchaseRequestDetail->purchase_request_id = $newPurchaseRequestId;
                    $purchaseRequestDetail->presentation_id = $req['id'];
                    $purchaseRequestDetail->quantity = $req['value'];
                    $purchaseRequestDetail->status = 1;
                    if( !$purchaseRequestDetail->save() ){
                        $this->logAdmin("Purchase request item not register. ({$newPurchaseRequestId})", $req, 'error');
                    }
                }
                $this->logAdmin("Purchase request register ok. ({$newPurchaseRequestId})", $request->purchaseRequest);
            }else{
                $this->logAdmin("Purchase request not register.", $request->purchaseRequest, 'error');
            }

        }
    }

    public function getDetails( $id ){
        $response = \App\PurchaseRequestDetail::where('purchase_request_detail.status', 1)
            ->where('purchase_request_detail.purchase_request_id', $id)
            ->join('presentation', 'presentation.id', '=', 'purchase_request_detail.presentation_id')
            ->join('unity', 'unity.id', '=', 'presentation.unity_id')
            ->join('products', 'products.id', '=', 'presentation.products_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'purchase_request_detail.id',
                'purchase_request_detail.presentation_id',
                'purchase_request_detail.quantity',
                'presentation.description',
                'presentation.equivalence',
                'presentation.stock',
                'unity.name as unity',
                'products.name as products',
                'categories.name as category'
            )
            ->get();

        return ['response' => $response];
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

    public function quote( Request $request ){

        if(!$request->ajax()) return redirect('/');

        $response = [
            'status'    => false,
            'msg'      => ''
        ];

        $id             = $request->id;
        $detailrequest  = [];
        $providers      = [];

        $purchase = PurchaseRequest::findOrFail( $id );
        if( $purchase->id > 0 ){
            $response['status'] = true;
            $response['code'] = $purchase->code;
            $response['date'] = date( 'd/m/y', strtotime( $purchase->date ) );
            $response['content'] = [];
            $response['content'][0] = [
                'id'                => 'id',
                'product'           => 'Productos',
                'presentationId'    => 0,
                'quantity'          => 'Cantidad',
                'unity'             => '',
                'quotation'         => []
            ];

            $providers      = [];
            $quotationprev  = [];
            $quotation      = Quotation::where( 'quotations.purchase_request_id', $id )
                                ->where( 'quotations.status', '!=', 2 )
                                ->join( 'providers', 'providers.id', 'quotations.providers_id' )
                                ->select(
                                    'quotations.id',
                                    'providers.id as pv_id',
                                    'providers.name as pv_name'
                                )
                                ->get();
            $contPv = 1;
            foreach( $quotation as $qut ){
                $detailsQut = [];
                $detailQuotation = QuotationDetail::where( 'status', '!=', 2 )
                                    ->where( 'quotations_id', $qut->id )
                                    ->select(
                                        'id',
                                        'presentation_id',
                                        'unit_price'
                                    )
                                    ->get();
                foreach( $detailQuotation as $dqut ) {
                    $detailsQut[] = [
                        'id'            => $dqut->id,
                        'presentation'  => $dqut->presentation_id,
                        'unitPrice'     => $dqut->unit_price
                    ];
                }

                $response['content'][0]['quotation'][] = [
                    'id'        => $qut->id,
                    'pvCode'    => 'Pv' . $contPv,
                    'pvId'      => $qut->pv_id,
                    'pvname'    => $qut->pv_name
                ];

                $providers[] = [
                    'id'        => $qut->id,
                    'pvCode'    => 'Pv' . $contPv,
                    'pvId'      => $qut->pv_id,
                    'pvname'    => $qut->pv_name,
                    'details'   => $detailsQut
                ];
                $contPv++;
            }

            $requestDetail = PurchaseRequestDetail::where( 'purchase_request_detail.status', '!=', '2' )
                            ->where( 'presentation.status', '!=', 2 )
                            ->where( 'products.status', '!=', 2 )
                            ->where( 'purchase_request_detail.purchase_request_id', $id )
                            ->join( 'presentation', 'presentation.id', 'purchase_request_detail.presentation_id')
                            ->join( 'products', 'products.id', 'presentation.products_id' )
                            ->join( 'categories', 'categories.id', 'products.category_id' )
                            ->join( 'unity', 'unity.id', 'presentation.unity_id' )
                            ->select(
                                'purchase_request_detail.id',
                                'purchase_request_detail.presentation_id',
                                'purchase_request_detail.quantity',
                                'presentation.description',
                                'products.name',
                                'categories.name as category',
                                'unity.name as unity'
                            )
                            ->get();
            foreach( $requestDetail as $detail ) {
                $presentation = $detail->category . ' ' . $detail->name . ' ' . $detail->description;

                $quotation = [];
                foreach( $providers as $prv ){

                    $presentaations = $prv['details'];
                    $keyPres        = array_search( $detail->presentation_id, array_column( $presentaations, 'presentation') );
                    $quotation[] = [
                        'id'        => ( ! empty( $presentaations[$keyPres]['id'] ) ? $presentaations[$keyPres]['id'] : 0 ),
                        'pvCode'    => $prv['pvCode'],
                        'pvId'      => $prv['pvId'],
                        'pvname'    => $prv['pvname'],
                        'presentation' => ( ! empty( $presentaations[$keyPres]['presentation'] ) ? $presentaations[$keyPres]['presentation'] : 0 ),
                        'priceUnit' => ( ! empty( $presentaations[$keyPres]['unitPrice'] ) ? $presentaations[$keyPres]['unitPrice'] : 0 )
                    ];
                }

                $response['content'][] = [
                    'id'                => $detail->id,
                    'presentationId'    => $detail->presentation_id,
                    'name'              => $presentation,
                    'quantity'          => $detail->quantity,
                    'unity'             => $detail->unity,
                    'quotation'         => $quotation
                ];
            }
        }

        return $response;
    }
}
