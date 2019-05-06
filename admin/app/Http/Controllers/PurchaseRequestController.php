<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\PurchaseRequest;
use \App\PurchaseRequestDetail;

class PurchaseRequestController extends Controller
{
    protected $_moduleDB = 'purchase-request';

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/pages', [
            "menu" => 18,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
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
}
