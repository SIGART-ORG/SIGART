<?php

namespace App\Http\Controllers;

use App\Access;
use App\Http\Requests\uploadExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\PurchaseRequest;
use App\Quotation;
use App\QuotationDetail;
use \App\PurchaseRequestDetail;
use DB;

class PurchaseRequestController extends Controller
{
    protected $_moduleDB    = 'purchase-request';
    protected $_page        = 18;
    protected $_sub_menu    = '';

    const PATH_PDF_QUOTATION_REQ = '/pdf/quotation/';
    const PATH_UPLOAD_EXCEL = '/uploads/quotations/';

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

        return response()->json([
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $response
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
        if( ! $request->ajax() ) return redirect('/');

        if( count( $request->purchaseRequest ) >  0) {
            $purchaseRequest = new PurchaseRequest();
            $allRegister = $purchaseRequest::count();

            $user_id = Auth::user()->id;

            $purchaseRequest->user_reg = $user_id;
            $purchaseRequest->code = date('Ymd') . '-' . ($allRegister + 1);
            $purchaseRequest->date = date('Y-m-d');
            $purchaseRequest->sites_id = 1;/*ID se la sede*/
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
                return response()->json(['status' => true], 200);
            }else{
                $this->logAdmin("Purchase request not register.", $request->purchaseRequest, 'error');
                return response()->json(['status' => false], 200);
            }

        }
        return response()->json(['status' => false], 200);
    }

    protected function getSQLPrice() {
        $siteSesion = session('siteDefault');
        return '(SELECT
            stocks.price
        FROM
            stocks
        WHERE
            stocks.sites_id = ' . $siteSesion . '
                AND stocks.presentation_id = presentation.id) AS price';
    }

    public function getDetails( $id ){
        $subQueryPrice = $this->getSQLPrice();

        $requestDetails = \App\PurchaseRequestDetail::where('purchase_request_detail.status', 1)
            ->where('purchase_request_detail.purchase_request_id', $id)
            ->join('presentation', 'presentation.id', '=', 'purchase_request_detail.presentation_id')
            ->join('unity', 'unity.id', '=', 'presentation.unity_id')
            ->leftJoin('products', 'products.id', '=', 'presentation.products_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'purchase_request_detail.id',
                'purchase_request_detail.presentation_id',
                'purchase_request_detail.quantity',
                'presentation.description',
                'presentation.equivalence',
                'presentation.stock',
                'unity.name as unity',
                'products.name as products',
                'categories.name as category',
                DB::raw( $subQueryPrice )
            )
            ->get();

        return response()->json([
            'reqDetails' => $requestDetails,
            'providers' => $this->getProviderSelect( $id )
        ]);
    }

    public function getProviderSelect( $id ) {
        $data = Quotation::where( 'quotations.status', '!=', 2 )
                ->where( 'quotations.purchase_request_id', $id )
                ->with( 'provider' )
                ->orderBy( 'quotations.created_at', 'desc' )
                ->get();

        $response = [];
        foreach ( $data as $row ) {
            $response[] = [
                'id'            => $row->provider->id,
                'quotation'     => $row->id,
                'name'          => $row->provider->name,
                'typePerson'    => $row->provider->type_person,
                'businessName'  => $row->provider->business_name,
                'document'      => $row->provider->document,
                'typeDocument'  => $row->provider->type_document,
                'status'        => $row->provider->status,
                'reg'           => date( 'd/m/Y h:i a', strtotime( $row->created_at ) ),
                'pdf'           => $row->pdf,
                'excel'           => $row->excel,
                'pdfUrl'        => asset( self::PATH_PDF_QUOTATION_REQ . $row->pdf ),
                'excelUrl'        => asset( self::PATH_UPLOAD_EXCEL . $row->excel ),
                'generatePdf'   => route( 'quotation.generate-pdf', [$row->id]),
                'generateExcel'   => route( 'quotation.generate-excel', [$row->id]),
                'statusReq'     => $row->status
            ];
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $breadcrumb = [
            [
                'name' => 'Solicitud de compra',
                'url' => route( 'pr.index' )
            ],
            [
                'name' => 'Detalle',
                'url' => '#'
            ]
        ];

        $this->_sub_menu    = 'purchase-request-details';
        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            "menu"          => $this->_page,
            'sidebar'       => $permiso,
            "moduleDB"      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'subMenu'       => $this->_sub_menu,
            'prId'          => $id
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
                'priceTag'          => 'Precio Referencial',
                'quantity'          => 'Cantidad',
                'unity'             => '',
                'quotation'         => []
            ];

            $providers      = [];
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

            $subQueryPrice = $this->getSQLPrice();
            $requestDetail = PurchaseRequestDetail::where( 'purchase_request_detail.status', '!=', '2' )
                            ->where( 'presentation.status', '!=', 2 )
                            ->where( 'purchase_request_detail.purchase_request_id', $id )
                            ->join( 'presentation', 'presentation.id', '=', 'purchase_request_detail.presentation_id')
                            ->join( 'unity', 'unity.id', '=', 'presentation.unity_id' )
                            ->leftJoin( 'products', 'products.id', '=', 'presentation.products_id' )
                            ->leftJoin( 'categories', 'categories.id', '=', 'products.category_id' )
                            ->select(
                                'purchase_request_detail.id',
                                'purchase_request_detail.presentation_id',
                                'purchase_request_detail.quantity',
                                'presentation.description',
                                'products.name',
                                'categories.name as category',
                                'unity.name as unity',
                                DB::raw( $subQueryPrice )
                            )
                            ->get();

            foreach( $requestDetail as $detail ) {
                $presentation = $detail->category . ' ' . $detail->name . ' ' . $detail->description;

                $quotation  = [];
                $aSmallest   = [];
                foreach( $providers as $prv ){

                    $presentaations = $prv['details'];
                    $keyPres        = array_search( $detail->presentation_id, array_column( $presentaations, 'presentation') );
                    $idQuote        = ( ! empty( $presentaations[$keyPres]['id'] ) ? $presentaations[$keyPres]['id'] : 0 );
                    $idPres         = ( ! empty( $presentaations[$keyPres]['presentation'] ) ? $presentaations[$keyPres]['presentation'] : 0 );
                    $unitPrice      = ( ! empty( $presentaations[$keyPres]['unitPrice'] ) ? $presentaations[$keyPres]['unitPrice'] : 0 );

                    if( ( $unitPrice * 100) > 0){
                        $aSmallest[] = $unitPrice * 100;
                    }
                    $quotation[] = [
                        'id'        => $idQuote,
                        'pvCode'    => $prv['pvCode'],
                        'pvId'      => $prv['pvId'],
                        'pvname'    => $prv['pvname'],
                        'presentation' => $idPres,
                        'priceUnit' => $unitPrice,
                        'isDisabled' => ( $unitPrice > 0 ? true : false ),
                        'selected'  => false,
                    ];
                }
                $lowerPrice = 0;
                if( ! empty( $aSmallest ) && count( $aSmallest ) > 0 ){
                    $lowerPrice = min( $aSmallest );
                    $keyLower   = array_search( ( $lowerPrice / 100 ), array_column( $quotation, 'priceUnit' ) );
                    if( $lowerPrice == 500 ){
                        //echo $keyLower;
                    }
                    $quotation[$keyLower]['selected'] = true;
                }

                $response['content'][] = [
                    'id'                => $detail->id,
                    'presentationId'    => $detail->presentation_id,
                    'name'              => $presentation,
                    'priceTag'          => $detail->price,
                    'quantity'          => $detail->quantity,
                    'unity'             => $detail->unity,
                    'quotation'         => $quotation,
                    'lowerPrice'        => ( $lowerPrice / 100 ),
                    'checkedProduct'    => true,
                ];
            }
        }

        return $response;
    }

    public function readExcel( uploadExcel $request ) {
        if(!$request->ajax()) return redirect('/');

        $quotation = $request->id;

        $directory = 'temps';

        $response = [
            'status'    => false,
            'errors'    => [],
            'info'      => [],
            'saved'     => 0
        ];

        $path = $request->file( 'file-upload' )->store( $directory );

        $collections = Excel::toCollection( new ImportExcel(), $path );

        if( $collections ) {
            foreach( $collections as $colection ) {
                foreach ( $colection as $idx => $products ) {
                    if( $idx > 1 ) {
                        $sku = $products[0];
                        $priceUnit = $products[4];

                        if( !empty( $sku ) && !empty( $priceUnit ) ) {
                            $quotationDetails = QuotationDetail::where( 'quotation_details.quotations_id', $quotation )
                                ->where( 'quotation_details.status', 1 )
                                ->where( 'presentation.sku', $sku )
                                ->where( 'presentation.status', 1 )
                                ->join( 'presentation', 'presentation.id', '=', 'quotation_details.presentation_id' )
                                ->select( 'quotation_details.id', 'quotation_details.quantity' )
                                ->first();

                            if( $quotationDetails ) {
                                $qd = QuotationDetail::find( $quotationDetails->id );
                                $qd->unit_price = $priceUnit;
                                $qd->total = $priceUnit * $quotationDetails->quantity;
                                $qd->save();
                            }

                            $allQuotationDetails = QuotationDetail::where( 'quotation_details.quotations_id', $quotation )
                                ->where( 'quotation_details.status', 1 )
                                ->select( 'quotation_details.id', 'quotation_details.total' )
                                ->get();
                            $total = 0;
                            foreach( $allQuotationDetails as $qDet ) {
                                $total += $qDet->total;
                            }

                            $quotationClass = Quotation::findOrFail( $quotation );
                            $quotationClass->total;
                            $quotationClass->save();
                        }
                    }
                }
            }
        }

        $response['status'] = true;
        return response()->json( $response );

    }
}
