<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quotation;

class QuotationController extends Controller
{
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

        $dataRequest = $request->quotation;
        $purchaseRequestId = $dataRequest['idPR'];
        $providerId = $dataRequest['idProvider'];
        $user_id = Auth::user()->id;

        $detailsPurchaseRequest = \App\PurchaseRequestDetail::where('status', 1)
            ->where('purchase_request_id', $purchaseRequestId)
            ->select(
                'id',
                'purchase_request_id',
                'presentation_id',
                'quantity'
            )
            ->get();
        echo '<pre>';
        print_r($detailsPurchaseRequest);
        echo '</pre>';
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
