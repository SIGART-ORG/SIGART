<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Service;
use App\Models\ServiceAttachment;
use App\Models\SiteVourcher;
use Illuminate\Http\Request;
use DB;
use PDF;;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function index( Request $request ) {

        $paginate = 20;
        $search = $request->search ? $request->search : '';
        $sales = [];

        $results = Sale::orderBy( 'created_at', 'desc' )
            ->paginate( $paginate );

        foreach ( $results as $result ){
            $row = new \stdClass();
            $row->id = $result->id;
            $row->typeDocument = $result->typeVoucher->name;
            $row->document = $result->serial_doc . '-' . $result->number_doc;
            $row->subtotal = $result->subtotal;
            $row->igv = $result->igv;
            $row->total = $result->total;
            $row->pdf = $result->pdf ? asset( self::PATH_PDF_SALE . $result->pdf ): '';
            $row->newPdf = route( 'sale.pdf', ['id' => $result->id]);
            $row->customer = new \stdClass();
            $row->customer->name = $result->business_name_customer;
            $row->customer->document = $result->customer_document;

            $service = $result->service;
            $row->service = new \stdClass();
            $row->service->id = $service->id;
            $row->service->document = $service->serial_doc . '-' . $service->number_doc;
            $row->service->total = $service->total;

            $sales[] = $row;
        }

        $response = [
            'status' => true,
            'pagination' => [
                'total' => $results->total(),
                'current_page' => $results->currentPage(),
                'per_page' => $results->perPage(),
                'last_page' => $results->lastPage(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem()
            ],
            'records' => $sales
        ];

        return response()->json( $response );
    }

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Facturación',
                'url' => route( 'sale.dashboard' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'sale',
        ]);
    }

    public function generate( Request $request ) {

        $response = [
            'status' => false
        ];

        $service = $request->service;
        $typeVoucher = $request->typeVoucher;

        $sale = new Sale();
        $sale->services_id = $service;
        $sale->type_vouchers_id = $typeVoucher;
        $sale->type_payment_methods_id = 1;
        $sale->serial_doc = '';
        $sale->number_doc = '';
        $sale->subtotal = 0;
        $sale->igv = 0;
        $sale->total = 0;
        $sale->date_emission = date( 'Y-m-d' );
        $sale->date_pay = date( 'Y-m-d' );
        $sale->company_name = 'D\' Pintart E.I.R.L';
        $sale->business_name_customer = '';
        $sale->company_document = '';
        $sale->customer_document = '';
        $sale->customer_type_document = '';
        $sale->pay_mount = '';
        $sale->observation = '';

        if( $sale->save() ) {
            $response['status'] = true;
        }

        return response()->json( $response );
    }

    public function newSale( Request $request ) {

        $code = $request->code ? $request->code : '';

        $breadcrumb = [
            [
                'name' => 'Facturación',
                'url' => route( 'sale.dashboard' )
            ],
            [
                'name' => 'Nuevo Registro',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar();

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'component'     => 'sale-new',
            'code'          => $code
        ]);
    }

    public function searchByCode( Request $request ) {
        $response = [
            'status' => false,
            'msg' => 'No se encontro el servicio relacionado al código',
            'service' => []
        ];
        $code = $request->code ? $request->code : '';

        $voucher = ServiceAttachment::where( 'code_validation', $code )
            ->where( 'status', 1 )->where( 'is_valid', 1 )
            ->first();

        if( $voucher ) {
            $dataService = $voucher->service;
            if( $dataService->is_send_order_pay > 0 && $dataService->is_send_order_pay !== 4 ) {
                $service = $this->getFormatService($dataService, $code);
                $service->minPay = $voucher->mount;
                $service->maxPay = $voucher->mount;
                $response['status'] = true;
                $response['msg'] = 'OK.';
                $response['service'] = $service;
            } else {
                $document = $dataService->serial_doc . '-' . $dataService->number_doc;
                if( $dataService->is_send_order_pay === 4 ) {
                    $response['msg'] = 'El <strong>Servicio ' . $document . '</strong> ya se encuentrá pagado en su totalidad.';
                } else {
                    $response['msg'] = 'No se genero ninguna orden de pago relacionado a este servicio.';
                }
            }
        }

        return response()->json( $response, 200 );
    }

    public function search( Request $request ) {
        $search = $request->search ? $request->search : '';

        $response = [
            'data' => []
        ];

        if( strlen( trim( $search ) ) > 2 ) {
            /*
             * @column is_send_order_pay int
             * @value 0: Default
             * @value 1: 1ra orden de pago - generado
             * @value 2: 1ra orden de pago - pagada
             * @value 3: 2da orden de pago - generado
             * @value 4: 2da orden de pago - pagada
             * */
            $services = Service::whereNotIn( 'is_send_order_pay', [0, 4])
                ->where( function( $query ) use( $search ) {
                    $query->where( DB::raw( "CONCAT(`serial_doc`, '-', `number_doc`)" ), 'like', '%' . $search . '%' )
                    ->orWhereHas( 'serviceRequest.customer', function( $subQuery ) use( $search ) {
                        $subQuery->where( DB::raw( "CONCAT(`name`, ' ', `lastname`)" ), 'like' , '%' . $search . '%' )
                            ->orWhere( 'document', 'like', '%' . $search . '%' );
                    });
                })
                ->limit( 20 )
                ->orderBy( 'created_at', 'desc' )
                ->get();

            foreach ( $services as $service ) {
                $response['data'][] = $this->getFormatService( $service );
            }
        }

        return response()->json( $response );
    }

    private function getFormatService( $service, $code = '' ) {
        $row = new \stdClass();

        $outstanding = round( $service->sales->sum( 'pay_mount' ), 2 );
        $minPay = ( $outstanding <= $service->pay_first ? $service->pay_first - $outstanding : 0 );
        $maxPay = ( $service->total >= $outstanding ) ? round( $service->total - $outstanding, 2 ) : 0;

        $row->id = $service->id;
        $row->document = $service->serial_doc . '-' . $service->number_doc;
        $row->subTotal = $service->sub_total;
        $row->igv = $service->igv;
        $row->total = $service->total;
        $row->paidOut = round( $service->total - $outstanding, 2 );
        $row->outstanding = $outstanding;
        $row->minPay = $minPay;
        $row->maxPay = $maxPay;
        $row->dateEmision = date( 'Y-m-d' );
        $row->today = date( 'Y-m-d' );
        $row->details = $this->getServiceDetails( $service->serviceDetails );
        $row->code = $code;

        $serviceRequest = $service->serviceRequest;
        $customer = $serviceRequest->customer;

        $row->customer = new \stdClass();
        $row->customer->id = $customer->id;
        $row->customer->name = $customer->type_person === 1 ? $customer->name . ' ' . $customer->lastname : $customer->name;
        $row->customer->document = $customer->document;
        $row->customer->typePerson = $customer->type_person;
        $row->customer->typeDocument = $customer->type_document;
        $row->customer->typeDocumentName = $customer->typeDocument->name;
        $row->customer->address = $customer->address;
        $row->customer->ubigeo = HelperSigart::ubigeo( $customer->district_id, 'inline' );

        $typeVoucher        = $customer->type_document === 2 ? 5 : 4;
        $SiteVoucherClass   = new SiteVourcher();
        $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher, 'details' );
        $row->voucher = new \stdClass();
        $row->voucher->typeDocument = $typeVoucher;
        $row->voucher->typeDocuments = $this->typeVoucher( $customer->type_document, $customer->type_person );
        $row->voucher->document = $correlative['status'] ? $correlative['correlative']['serie'] . '-' . $correlative['correlative']['number'] : '';

        return $row;
    }

    private function getServiceDetails( $details ) {
        $data = [];

        foreach ( $details as $detail ) {
            $row = new \stdClass();
            $row->id = $detail->id;
            $row->description = $detail->description;
            $row->priceUnit = $detail->price_unit;
            $row->quantity = $detail->quantity;
            $row->total = $detail->total;

            $data[] = $row;
        }

        return $data;
    }

    private function typeVoucher( $tDocument, $tPerson ) {
        $typeDocuments = [];

        switch ( $tPerson ) {
            case 1:
                if( $tDocument === 2 ) {
                    $typeDocuments[] = [
                        'id' => 5,
                        'name' => 'Factura'
                    ];
                } else {
                    $typeDocuments[] = [
                        'id' => 4,
                        'name' => 'Boleta'
                    ];
                }
                break;
            case 2:
                $typeDocuments[] = [
                    'id' => 5,
                    'name' => 'Factura'
                ];
                break;
        }

        return $typeDocuments;
    }

    public function store( Request $request ) {
        $service = $request->service ? $request->service : 0;
        $amount = $request->amount ? $request->amount : 0;
        $emission = $request->emission ? date( 'Y-m-d', strtotime( $request->emission ) ) : null;
        $code = $request->code ? $request->code : '';
        $serviceVoucher = null;
        $close_service = false;

        $response = [
            'status' => false,
            'msg' => 'No se puede generar el comprobante.'
        ];

        if ( $service > 0 && $amount > 0 && $emission ) {
            $serviceClass = Service::find( $service );

            $outstanding = $serviceClass->sales->sum( 'pay_mount' );
            $minPay = ( $outstanding <= $serviceClass->pay_first ? $outstanding - $serviceClass->pay_first : 0 );
            if( $code !== '' ) {
                $voucherData = ServiceAttachment::where( 'code_validation', $code )
                    ->where( 'status', 1 )->where( 'is_valid', 1 )
                    ->first();
                if( $voucherData ) {
                    $amount = $voucherData->mount;
                    $minPay = $voucherData->mount;
                    $serviceVoucher = $voucherData->id;
                }
            }

            if( $amount >= $minPay ) {
                $serviceRequest = $serviceClass->serviceRequest;
                $customer = $serviceRequest->customer;

                $typeVoucher = $customer->type_document === 2 ? 5 : 4;
                $SiteVoucherClass = new SiteVourcher();
                $correlative = $SiteVoucherClass->getNumberVoucherSite($typeVoucher, 'details');

                if ($correlative['status']) {

                    $subTotal = ( $amount / 1.18 );
                    $igv = $amount - $subTotal;

                    $sale = new Sale();
                    $sale->services_id = $service;
                    $sale->type_vouchers_id = $typeVoucher;
                    $sale->type_payment_methods_id = 1;
                    $sale->serial_doc = $correlative['correlative']['serie'];
                    $sale->number_doc = $correlative['correlative']['number'];
                    $sale->subtotal = round( $subTotal, 2 );
                    $sale->igv = round( $igv, 2 );
                    $sale->total = $amount;
                    $sale->date_emission = $emission;
                    $sale->date_pay = date('Y-m-d');
                    $sale->company_name = 'PINTART PERU S.A.C.';
                    $sale->business_name_customer = $customer->type_person === 1 ? $customer->name . ' ' . $customer->lastname : $customer->name;;
                    $sale->company_document = '20565449258';
                    $sale->customer_document = $customer->document;
                    $sale->customer_type_document = $customer->type_document;
                    $sale->company_address = 'Av. Chacra Cerro Lote. 6b Urb Agraria Chacra Cerro';
                    $sale->company_ubigeo = '150110';
                    $sale->bussiness_address = $customer->address;
                    $sale->bussiness_ubigeo = $customer->district_id;
                    $sale->pay_mount = $amount;
                    $sale->service_attachments_id = $serviceVoucher;

                    if( $sale->save() ) {
                        $serviceClass = Service::find( $service );
                        $outstanding = $serviceClass->sales->sum( 'pay_mount' );
                        $diference = $serviceClass->total - $outstanding;
                        $details = $serviceClass->serviceDetails;
                        $correlative = $sale->serial_doc . '-' . $sale->number_doc;

                        if( $serviceClass->is_send_order_pay === 1 ) {
                            $serviceClass->is_send_order_pay = 2;
                        }

                        if( $serviceClass->status === 1 && ( $outstanding >= $serviceClass->pay_first ) ) {
                            $serviceClass->status = 3;
                            $datareference = $this->getDataRefrence( $serviceClass );
                            $serviceClass->start_date = $datareference->dateStart;
                            $serviceClass->end_date = $datareference->dateEnd;
                        }
                        if( $diference <= floatval( 0 ) && $serviceClass->status === 6 ) {
                            $serviceClass->status = 7;
                            $serviceClass->is_send_order_pay = 4;
                            $serviceClass->end_date_real = date( 'Y-m-d H:i:s' );
                            $msg = 'Marcó como culminado el servicio, debidó a que ya se habia cancelado el total del servicio ' . $serviceClass->serial_doc . '-' . $serviceClass->number_doc . ' ID::' . $serviceClass->id;
                            $this->logAdmin( $msg );
                            $close_service = true;
                        }
                        $serviceClass->save();

                        $SiteVoucherClass->increaseCorrelative($typeVoucher);

                        $this->registerSaleDetails( $sale->id, $amount, $diference, $details, $correlative, $serviceClass->total );
                        $pdf = $this->generatePDF( $sale );

                        if( !empty( $voucherData ) ) {
                            $voucherData->is_valid = 3;
                            $voucherData->save();
                        }

                        $this->logAdmin( 'Se Generó correctamente el comprobante ' . $sale->serial_doc . '-' . $sale->number_doc . ' ID:: ' . $sale->id );
                        if( $close_service ) {
                            $customerData = $this->getDataCustomer( $customer );
                            $this->mailFinishedService( $serviceClass, $customerData );
                        }
                        $response['status'] = true;
                        $response['msg'] = 'Ok.';
                        $response['pdf'] = asset( self::PATH_PDF_SALE . $pdf['filename'] );
                    } else {
                        $response['msg'] = 'NO se puedo registrar el comprobante.';
                    }

                } else {
                    $response['msg'] = 'No se encuentra los correlativos correcpondiente para generar el comprobante de pago';
                }
            } else {
                $response['msg'] = 'El monto mínimo a pagar es de S/' . $minPay;
            }
        }

        return response()->json( $response );
    }

    private function registerSaleDetails( $sale_id, $amount, $diference, $details, $correlative, $total ) {
        if ( $diference > 0 ) {

            $subTotal = ( $amount / 1.18 );

            $porcentaje = $amount > 0 ? ( ( $amount / $total ) * 100 ) : 0;

            $description = 'Adelanto del ' . round( $porcentaje, 2 ) . '% del total de por el servicio ' . $correlative;

            $newSaleDetail = new SaleDetail();
            $newSaleDetail->sales_id = $sale_id;
            $newSaleDetail->description = $description;
            $newSaleDetail->quantity = 1;
            $newSaleDetail->price_unit = round( $subTotal, 2 );
            $newSaleDetail->sub_total = round( $subTotal, 2 );
            $newSaleDetail->save();
        } else {
            foreach ( $details as $detail ) {
                $newSaleDetail = new SaleDetail();
                $newSaleDetail->sales_id = $sale_id;
                $newSaleDetail->description = $detail->description;
                $newSaleDetail->price_unit = $detail->price_unit;
                $newSaleDetail->quantity = $detail->quantity;
                $newSaleDetail->total = $detail->total;
                $newSaleDetail->save();
            }
        }
    }

    private function generatePDF( $sale ) {
        try {
            $title = 'Comprobante de pago';
            $template = 'mintos.PDF.pdf-sale';

            $data = [
                'title' => $title,
            ];

            $filename = Str::slug($title . '-' . $sale->id) . '.pdf';
            $path = public_path() . self::PATH_PDF_SALE . $filename;

            $pdf        = PDF::loadView( $template, $data);
            $pdf->save( $path );

            $sale->pdf = $filename;
            $sale->save();


            $response = [
                'path' => $path,
                'filename' => $filename,
                'title' => $title
            ];

            return $response;
        } catch ( \Exception $e ) {
            return $e->getMessage();
        }
    }

    public function pdf( Request $request ) {
        $id = $request->id ? $request->id : 0;
        $sale = Sale::find( $id );

        if( $sale ) {
            $this->generatePDF( $sale );
        }

        return response()->json([
            'status' => true
        ]);
    }

    private function getDataRefrence( $service ) {

        $serviceRequest = $service->serviceRequest;
        $quotation = $serviceRequest->salesQuotations->sortByDesc( 'created_at' )->first;
        $saleQuotation = $quotation->id ? $quotation->id : false;

        $data = new \stdClass();
        $data->dateStart = '';
        $data->dateEnd = '';

        if( $saleQuotation ) {
            $ref = $saleQuotation->referenceterms->sortByDesc( 'created_at' )->first;
            if( $ref && $ref->id ) {
                $reference = $ref->id;

                $start = $this->getStartDate();
                $end = $this->calculateRangeDuration( $start, $reference->execution_time_days );

                $data->dateStart = $start;
                $data->dateEnd = $end;
            }
        }

        return $data;
    }

    private function getStartDate() {
        $numDay = 1;

        if( date( 'G' ) >= 17 ) {
            $numDay = 2;
        }

        $start = date( 'Y-m-d', strtotime( ' +' . $numDay . ' DAY' ) );
        $dayNumWeek = date( 'N', strtotime( $start ) );

        if( $dayNumWeek === 7 ) {
            $start = date( 'Y-m-d', strtotime( $start . ' +1 DAY' ) );
        }

        return $start;
    }

    private function calculateRangeDuration( $start, $duration ) {
        $end = $start;
        $contador = 1;

        while( $contador <= $duration ) {

            $end = date( 'Y-m-d', strtotime( $end . ' +1 DAY' ) );
            $dayNumWeek = date( 'N', strtotime( $end ) );

            if( $dayNumWeek === 7 ) {
                $end = date( 'Y-m-d', strtotime( $end . ' +1 DAY' ) );
            }

            $contador++;
        }

        return $end;
    }

    public function upload( Request $request ) {
        $idVoucher = $request->id ? $request->id : 0;
        $response = [
            'status' => true,
            'msg' => 'No se puede actualizar la imagen del voucher.'
        ];

        $voucher = Sale::find( $idVoucher );
        if( $voucher && $voucher->status === 1 ) {
            if( $request->hasFile( 'voucherFile' ) ) {
                $voucher->attachment = $this->uploadAttachment( $request->file( 'voucherFile' ) );
            }
            if( $voucher->save() ) {
                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response );
    }

    private function uploadAttachment( $file ) {
        $destinationPath = public_path(self::UPLOAD_VOUCHER );
        $newImage = 'voucher-upload-' . time() . '.' . $file->getClientOriginalExtension();
        $file->move( $destinationPath, $newImage );

        return $newImage;
    }

    private function mailFinishedService( Service $service, $customerData ) {

        $template = 'mailV2.finished-service';
        $title = 'Culminación de Servicio "' . $service->serial_doc . '-' . $service->number_doc . '"';
        $vars = [
            'customerName' => $customerData['name'],
            'subject' => $title,
            'date_finish' => date( 'd/m/Y'),
            'code' => $service->serial_doc . '-' . $service->number_doc
        ];

        $this->sendMail( $customerData['email'], $title, $template, $vars );
    }
}
