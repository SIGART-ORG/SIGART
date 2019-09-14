<?php

namespace App\Http\Controllers;

use App\PurchaseRequest;
use App\Quotation;
use App\QuotationDetail;
use Illuminate\Http\Request;

class QuotationAprovedController extends Controller
{
    public static $arrMsgs = [];

    public function __construct()
    {
        self::displayErrosMsg();
    }

    public static function displayErrosMsg() {
        $arrMsg = [
            'E-SOLC-COMP-001' => 'Error E-SOLC-COMP-001: Solicitud de compra no encontrado.',
            'E-SOLC-COMP-002' => 'Error E-SOLC-COMP-002: Solicitud de compra ya seleccionado.'
        ];
        return self::$arrMsgs = $arrMsg;
    }

    public function getMsg( $code ) {
        return self::$arrMsgs[$code];
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    public function select( Request $request ) {
        if( ! $request->ajax() ) return redirect( '/' );

        $status = false;
        $msg    = '';
        $content    = $request->arData;
        $pr         = $request->pr;
        $quoSelect  = [];

        try {
            $PurchaseRequest = PurchaseRequest::findOrFail($pr);
            $permit = false;
            switch ( $PurchaseRequest->status ) {
                case 0:
                case 2:
                    $msg = $this->getMsg( 'E-SOLC-COMP-001' );
                break;
                case 3:
                    $msg = $this->getMsg( 'E-SOLC-COMP-002' );
                    break;
                case 1:
                    $permit = true;
                    break;
            }

            if ( $permit ) {
                foreach ($content as $idx => $row) {
                    if ($idx > 0) {
                        foreach ( $row['quotation'] as $quotation ) {
                            if( $quotation['selected'] ) {
                                $quoDet = QuotationDetail::findOrFail( $quotation['id'] );
                                $quoDet->selected = 1;
                                if ( $quoDet->save() ) {
                                    if( ! in_array( $quoDet->quotations_id, $quoSelect )) {
                                        $quoSelect[] = $quoDet->quotations_id;
                                    }
                                }
                            }
                        }
                    }
                }

                if (count( $quoSelect ) > 0) {
                    /*
                     * Marcar como cerrado la solicitud de cotización
                     */
                    $PurchaseRequest->status = 3;
                    if( $PurchaseRequest->save() ) {
                        /*
                         * Cambiar de estado a las cotizaciones seleccionadas.
                         */
                        Quotation::whereIn('id', $quoSelect)
                                    ->where('purchase_request_id', $pr)
                                    ->where('status', 3)
                                    ->update(['status' => 4]);
                        $status = true;
                    }
                }

                return response()->json([
                    'status'    => $status,
                    'msg'       => $msg
                ]);

            } else {
                return response()->json([
                    'status' => $status,
                    'msg'   => $msg
                ]);
            }
        } catch( \Exception $e ) {
            return response()->json([
                'status'    => $status,
                'msg'       => $e->getMessage()
            ]);
        }
    }

    public function cancelQuotation( Request  $request ) {
        if( ! $request->ajax() ) return redirect( '/' );

        try {
            $response = [
                'status' => false,
                'msg' => ''
            ];

            $quotation = Quotation::findOrFail( $request->id );

            if ($quotation->status == 4) {
                $quotation->status = 6;
                if ($quotation->save()) {
                    $response['status'] = true;
                    $response['msg'] = 'OK';
                } else {
                    $response['msg'] = 'Error al actualizar los datos';
                }
            } else {
                $response['msg'] = 'Cotización no puede ser cancelada.';
            }

            return response()->json($response);

        } catch ( \Exception $e ) {
            return response()->json([
                'status' => false,
                'msg'   => $e->getMessage()
            ]);
        }
    }
}
