<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\PurchaseRequest;
use \App\PurchaseRequestDetail;

class PurchaseRequestController extends Controller
{

    public function dashboard(){

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
