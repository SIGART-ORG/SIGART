<?php

namespace App\Http\Controllers;

use App\Access;
use App\Provider;
use App\PurchaseRequest;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quotation;
use App\QuotationDetail;
use App\Http\Requests\Quotation\QuotationSave;
use Illuminate\Support\Str;
use Illuminate\View\View;
use PDF;

class QuotationController extends Controller
{
    protected $_moduleDB    = 'quotation';
    protected $_page        = 19;

    const PATH_PDF_QUOTATION_REQ = '/pdf/quotation/';
    const PATH_PDF_QUOTATION_REQ_NS = '/pdf/quotation';

    public function dashboard(){
        $breadcrumb = [
            [
                'name' => 'Cotizaciones',
                'url' => route( 'quotation.index' )
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
        if(!$request->ajax()) return redirect('/');

        $response       = [];
        $num_per_page   = 20;
        $search         = $request->search;

        $status = 200;
        $data = Quotation::whereIn('quotations.status', [4, 5, 6] )
            ->join('purchase_request', 'purchase_request.id', 'quotations.purchase_request_id')
            ->join('providers', 'providers.id', 'quotations.providers_id')
            ->search( $search )
            ->select(
                'quotations.id',
                'quotations.status',
                'purchase_request.code',
                'purchase_request.date',
                'providers.type_person',
                'providers.name',
                'providers.business_name',
                'providers.type_document',
                'providers.document'
            )
            ->orderBy('purchase_request.date', 'desc')
            ->paginate($num_per_page);

        $response['pagination'] = [
            'total'         => $data->total(),
            'current_page'  => $data->currentPage(),
            'per_page'      => $data->perPage(),
            'last_page'     => $data->lastPage(),
            'from'          => $data->firstItem(),
            'to'            => $data->lastItem()
        ];
        $response['records'] = $data;
        $response['status'] = $status;

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
        if(!$request->ajax()) return redirect('/');

        $dataRequest = $request->quotation;
        $purchaseRequestId = $dataRequest['idPR'];
        $providerId = $dataRequest['idProvider'];
        $user_id = Auth::user()->id;

        $detailsPurchaseRequest = \App\PurchaseRequestDetail::where('purchase_request_detail.status', 1)
            ->where('purchase_request_id', $purchaseRequestId)
            ->where( 'presentation.status', 1 )
            ->where( 'unity.status', 1 )
            ->join('presentation', 'presentation.id', '=', 'purchase_request_detail.presentation_id')
            ->join('unity', 'unity.id', '=', 'presentation.unity_id')
            ->leftJoin('products', 'products.id', '=', 'presentation.products_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'purchase_request_detail.id',
                'purchase_request_detail.purchase_request_id',
                'purchase_request_detail.presentation_id',
                'purchase_request_detail.quantity',
                'presentation.description',
                'products.name as product',
                'categories.name as category',
                'unity.name as unity'
            )
            ->get();

        if( count( $detailsPurchaseRequest ) > 0 ){
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

                $PRClass = PurchaseRequest::findOrFail( $purchaseRequestId );
                $providerClass = Provider::findOrFail( $providerId );
                $pdf = $this->generatePDF( $PRClass, $providerClass, $detailsPurchaseRequest, $quotationId );
                if( $providerClass->email ) {
                    $template = 'quotation-request';
                    $vars = [
                        'name' => $providerClass->name
                    ];
                    $attach = self::PATH_PDF_QUOTATION_REQ . $pdf['filename'];
                    $this->sendMail( $providerClass->email, $pdf['title'], $template, $vars, '', $attach );
                }

                $this->logAdmin("Quotation register ok. ({$quotationId})", ['PR' => $purchaseRequestId, 'Prov' => $providerId]);
                return response()->json([
                    'status'    => true,
                ]);
            }else{
                $this->logAdmin("Quotation not register.", ['PR' => $purchaseRequestId, 'Prov' => $providerId], 'error');
                return response()->json([
                    'status'    => false,
                ]);
            }
        }

        return  response()->json([
            'status' => false,
            'msg'   => 'No se encontraron materiales o herramientas seleccionadas.'
        ]);
    }

    public function generatePDFRequest( Request $request ) {

        $quotation = Quotation::findOrFail( $request->id );

        $pr         = $quotation->purchase_request_id;
        $provider   = $quotation->providers_id;

        $PRClass = PurchaseRequest::findOrFail( $pr );
        $providerClass = Provider::findOrFail( $provider );
        $detailsPurchaseRequest = \App\PurchaseRequestDetail::where( 'purchase_request_detail.status', 1 )
            ->where( 'purchase_request_detail.purchase_request_id', $pr )
            ->where( 'presentation.status', 1 )
            ->where( 'products.status', 1 )
            ->where( 'categories.status', 1 )
            ->where( 'unity.status', 1 )
            ->join('presentation', 'presentation.id', '=', 'purchase_request_detail.presentation_id')
            ->join('products', 'products.id', '=', 'presentation.products_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('unity', 'unity.id', '=', 'presentation.unity_id')
            ->select(
                'purchase_request_detail.id',
                'purchase_request_detail.purchase_request_id',
                'purchase_request_detail.presentation_id',
                'purchase_request_detail.quantity',
                'presentation.description',
                'products.name as product',
                'categories.name as category',
                'unity.name as unity'
            )
            ->get();

        $pdf = $this->generatePDF( $PRClass, $providerClass, $detailsPurchaseRequest, $request->id );
        return response()->json([
            'status'    => true,
            'filename'  => $pdf['filename'],
            'path'      => $pdf['path']
        ]);
    }

    public function generatePDF( $objPR, $objProvider, $details, $quotationId ) {

        $provider = $objProvider->name;
        $title = 'solicitud de cotización Nro ' . $objPR->code;
        $data = [
            'title'     => $title,
            'typePerson'=> $objProvider->type_person,
            'provider'  => $provider,
            'code'      => $objPR->code,
            'details'   => $details
        ];

        $filename   = Str::slug( $title. '-' . $objProvider->id ) . '.pdf';
        $path       = public_path() . self::PATH_PDF_QUOTATION_REQ . $filename;
        $pdf        = PDF::loadView( 'mintos.PDF.pdf-quotation', $data);
        $pdf->save( $path );

        $quotation = Quotation::findOrFail( $quotationId );
        $quotation->pdf = $filename;
        $quotation->save();

        return [
            'path'      => $path,
            'filename'  => $filename,
            'title'     => $title
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $response               = [];
        $quotation              = Quotation::findOrFail( $request->id );

        $response['headboard']  = [
            'provider'  => $quotation->provider->name,
            'create'    => date( 'd/m/Y H:i a', strtotime( $quotation->created_at ))
        ];
        $response['purchase']   = ! empty( $quotation->purchase_request_id ) ? $quotation->purchase_request_id : 0;
        $response['comment']    = ! empty( $quotation->comment ) ? $quotation->comment : '';
        $response['attach']     = ! empty( $quotation->attach ) ? $quotation->attach : '';
        $response['details']    = [];

        $select = false;
        if( ! empty( $request->selected ) && $request->selected == 1 ) {
            $select = true;
        }

        $details = QuotationDetail::where( 'quotation_details.quotations_id', $request->id )
                    ->where( 'quotation_details.status', 1 )
                    ->selected( $select )
                    ->join( 'presentation', 'presentation.id', 'quotation_details.presentation_id')
                    ->join( 'unity', 'unity.id', 'presentation.unity_id')
                    ->leftjoin( 'products', 'products.id', 'presentation.products_id' )
                    ->select(
                        'quotation_details.id',
                        'quotation_details.quantity',
                        'quotation_details.unit_price',
                        'quotation_details.total',
                        'quotation_details.selected',
                        'presentation.description as presentation',
                        'products.name as products',
                        'unity.name as unity'
                    )
                    ->get();
        foreach ( $details as $idx => $rowDetails ){
            $rowDetails->cont        = $idx + 1;
            $response['details'][]  = $rowDetails;
        }

        return response()->json( [ 'response' => $response ] );

    }

    public function save( QuotationSave $request ){
        if(!$request->ajax()) return redirect('/');

        $response = [
            'status' => false,
        ];

        $id         = $request->id;
        $details    = $request->quotation;
        $comment    = $request->comment;

        $quotation  = Quotation::findOrFail( $id );
        $quotation->comment = $comment;
        $quotation->status  = 3;
        $quotation->save();

        $countErrors = 0;
        foreach( $details as $detail ){
            $unitPrice = $detail['unit_price'];

            $quotationDetails = QuotationDetail::findOrFail( $detail['id'] );
            $quotationDetails->unit_price   = $unitPrice;
            $quotationDetails->total        = round( $unitPrice * $quotationDetails->quantity, 2 );

            if( ! $quotationDetails->save() ){
                $countErrors++;
            }
        }

        if( $countErrors === 0 ) {
            $response['status'] = true;
        }

        return response()->json( $response, 200 );
    }

    public function dataProviders( Request $request ) {
        if( ! $request->ajax() ) return redirect( '/' );

        $status     = false;
        $response    = [];

        $data = Quotation::where( 'quotations.status', '!=', 2 )
                    ->where ('quotations.purchase_request_id', $request->pr )
                    ->where ('providers.status', '!=', 2 )
                    ->join( 'providers', 'providers.id', 'quotations.providers_id' )
                    ->select(
                        'quotations.id',
                        'providers.name',
                        'providers.business_name',
                        'providers.type_person'
                    )
                    ->orderBy( 'providers.name' )
                    ->orderBy( 'providers.business_name' )
                    ->get();

        if( count( $data ) > 0 ){
            $status = true;
            foreach ( $data as $row ) {
                $name = $row->name;
                if( $row->type_person == 2 ) {
                    $name = $row->business_name;
                }

                $dataRow        = new \stdClass();
                $dataRow->id    = $row->id;
                $dataRow->name  = $name;
                $response[]     = $dataRow;
            }
        }

        return response()->json([
            'status'    => $status,
            'response'  => $response
        ], 200);
    }
}
