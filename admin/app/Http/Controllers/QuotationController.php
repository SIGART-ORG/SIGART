<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quotation;
use App\QuotationDetail;

class QuotationController extends Controller
{
    protected $_moduleDB = 'quotation';

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/pages', [
            "menu" => 19,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if(!$request->ajax()) return redirect('/');

        $num_per_page = 21;
        $search = $request->search;


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

        if( count($detailsPurchaseRequest) > 0 ){
            $quotation = new Quotation();
            $quotation->purchase_request_id = $purchaseRequestId;
            $quotation->providers_id        = $providerId;
            $quotation->user_reg            = $user_id;
            $quotation->status              = 1;
            if( $quotation->save() ){
                $quotationId = $quotation->id;
                foreach ( $detailsPurchaseRequest as $rowPR ) {
                    $quotationDetails = new QuotationDetail();
                    $quotationDetails->quotations_id    = $quotationId;
                    $quotationDetails->presentation_id  = $rowPR->presentation_id;
                    $quotationDetails->quantity         = $rowPR->quantity;
                    if( !$quotationDetails->save() ){
                        $this->logAdmin("Quotation item not register. ({$quotationId})", $rowPR, 'error');
                    }
                }
                $this->logAdmin("Quotation register ok. ({$quotationId})", ['PR' => $purchaseRequestId, 'Prov' => $providerId]);
            }else{
                $this->logAdmin("Quotation not register.", ['PR' => $purchaseRequestId, 'Prov' => $providerId], 'error');
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
