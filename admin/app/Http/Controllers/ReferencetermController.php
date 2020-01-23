<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
use App\Models\Referenceterm;
use App\Models\ReferencetermDetail;
use App\SalesQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

class ReferencetermController extends Controller
{
    const PATH_PDF_REFERENCE_TERM = '/reference/';

    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function dashboard( Request $request ) {

        $saleQuotation = $request->saleQuotation ? $request->saleQuotation : 0;

        $breadcrumb = [
            [
                'name' => 'Terminos de referencia',
                'url' => route( 'reference-term.dashboard' )
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
            'component'     => 'reference-term',
            'saleQuotation' => $saleQuotation
        ]);
    }

    public function generate( Request $request ) {

        $saleQuotation = $request->saleQuotation;

        $register = $this->register( $saleQuotation );

        return response()->json($register);
    }

    private function register( $saleQuotationId ) {

        $response = [
            'status' => false
        ];

        $exist = $this->existReferenceTerms( $saleQuotationId );

        if( $exist['status'] ) {

            $user = Auth()->user();
            $userId = $user->id;

            $saleQuotation = $exist['saleQuotation'];

            $reference = $exist['reference'];
            $reference->sales_quotations_id = $saleQuotationId;
            $reference->customers_id = $saleQuotation->customers_id;
            $reference->area = $reference->_area;
            $reference->activity = 'SERVICIO DE COLOCACION DE PUERTAS';
            $reference->objective = 'ELABORACION Y COLOCACION DE PUERTAS EN EL CENTRO EDUCATIVO PARTICULAR LORD BRAIN.';
            $reference->specialized_area = $reference->_specialized_area;
            $reference->execution_time_days = 5;
            $reference->execution_time_text = $reference->execution_time_text( 5 );
            $reference->execution_address = 'prueba 123';
            $reference->district_id = '150101';
            $reference->method_payment = 'CON DEPOSITO DEL 50% AL INICIO Y 50% AL FINALIZAR EL SERVICIO PREVIA PRESENTACION DEL COMPROBANTE DE PAGO.';
            $reference->conformance_grant = $reference->_conformance_grant;
            $reference->warranty_num = 15;
            $reference->warranty_text = $reference->warranty_text( 15 );
            $reference->users_id_reg = $userId;

            if( $reference->save() ) {
                $idReference = $reference->id;
                $this->registerDetails( $idReference, $saleQuotation->servicerequest->serviceRequestDetails->where('status', 1) );
                $this->generatePdf( $reference );

                $response['status'] = true;
            }

        }

        return $response;
    }

    private function existReferenceTerms( $saleQuotationId ) {

        $response = [
            'status' => false,
            'msg' => 'No se puede realizar la operación'
        ];

        $saleQuotation = SalesQuote::findOrFail( $saleQuotationId );

        if( $saleQuotation->status ===  8 ) {
            $reference = Referenceterm::where( 'status', '!=', 2 )
                ->where( 'sales_quotations_id', $saleQuotationId )
                ->first();

            $response['status'] = true;
            $response['saleQuotation'] = $saleQuotation;
            $response['type'] = 'EXIST';

            if( ! $reference ) {
                $reference = new Referenceterm();
                $response['type'] = 'NEW';
            }

            $response['reference'] = $reference;
        }

        return $response;
    }

    private function registerDetails( $reference, $details ) {

        ReferencetermDetail::where( 'status', 1 )
            ->where( 'referenceterms_id', $reference )
            ->update(['status' => 2 ]);

        if( count( $details ) ) {
            foreach( $details as $detail ) {
                $referenceDetail = new ReferencetermDetail();
                $referenceDetail->referenceterms_id = $reference;
                $referenceDetail->description = $detail->description;
                $referenceDetail->quantity = $detail->quantity;
                $referenceDetail->save();

            }
        }
        return true;
    }

    private function generatePdf( $reference ) {
        $response = [
            'status' => false
        ];

        if( $reference ) {

            $title = 'TERMINO DE REFERENCIA';

            $getReference = new \stdClass();
            $getReference->id = $reference->id;
            $getReference->area = $reference->area;
            $getReference->activity = $reference->activity;
            $getReference->objective = $reference->objective;
            $getReference->specializedArea = $reference->specialized_area;
            $getReference->daysExecution = $reference->execution_time_days;
            $getReference->executionAddress = $reference->execution_address;
            $getReference->addressReference = $reference->address_reference;
            $getReference->methodPayment = $reference->method_payment;
            $getReference->conformanceGrant = $reference->conformance_grant;
            $getReference->warrantyMonth = $reference->warranty_num;
            $getReference->obervations = $reference->obervations;

            $data = [
                'title' => $title,
                'refe' => $getReference
            ];

            $filename   = Str::slug( $title. '-' . $reference->id ) . '.pdf';
            $path       = public_path() . self::PATH_PDF_REFERENCE_TERM . $filename;

            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('mintos.PDF.pdf-reference-terms', $data);
            $pdf->save( $path );

            $reference->pdf = $filename;
            $reference->save();

            $response['path'] = $path;
            $response['filename'] = $filename;
            $response['title'] = $title;
        }

        return $response;
    }

    public function getData( Request $request ) {

        $response = [
            'status' => false,
            'msg' => 'No se encontro el término de referencia para la cotización seleccionada.'
        ];

        $saleQuotation = $request->saleQuotation ? $request->saleQuotation : 0;

        $saleQuotationData = SalesQuote::findOrfail( $saleQuotation );
        if( $saleQuotationData->status === 8 ) {
            $referenceTerm = Referenceterm::where( 'sales_quotations_id', $saleQuotation )
                ->where( 'status', '!=', 2 )
                ->first();

            if( $referenceTerm ) {
                $response['status'] = true;

                $response['reference'] = new \stdClass();
                $response['reference']->id = $referenceTerm->id;
                $response['reference']->area = $referenceTerm->area;
                $response['reference']->activity = $referenceTerm->activity;
                $response['reference']->objective = $referenceTerm->objective;
                $response['reference']->specializedArea = $referenceTerm->specialized_area;
                $response['reference']->daysExecution = $referenceTerm->execution_time_days;
                $response['reference']->executionAddress = $referenceTerm->execution_address;
                $response['reference']->addressReference = $referenceTerm->address_reference;
                $response['reference']->methodPayment = $referenceTerm->method_payment;
                $response['reference']->conformanceGrant = $referenceTerm->conformance_grant;
                $response['reference']->warrantyMonth = $referenceTerm->warranty_num;
                $response['reference']->obervations = $referenceTerm->obervations;
                $response['reference']->pdf = asset( self::PATH_PDF_REFERENCE_TERM . $referenceTerm->pdf );
                $response['reference']->details = [];
                $response['reference']->customer = new \stdClass();

                $customer = $referenceTerm->customer;
                $name = $customer->name;
                if ($customer->type_person === 1) {
                    $name .= ' ' . $customer->lastname;
                }
                $document = $customer->typeDocument->name . ': ' . $customer->document;

                $response['reference']->customer->id = $customer->id;
                $response['reference']->customer->name = $name;
                $response['reference']->customer->document = $document;

                $ubigeo = HelperSigart::ubigeo( $referenceTerm->district_id );
                $response['reference']->ubigeo = new \stdClass();
                $response['reference']->ubigeo->district = $ubigeo['district_id'] ? $ubigeo['district_id'] : '';
                $response['reference']->ubigeo->province = $ubigeo['province_id'] ? $ubigeo['province_id'] : '';
                $response['reference']->ubigeo->departament = $ubigeo['departament_id'] ? $ubigeo['departament_id'] : '';

                $details = $referenceTerm->referencetermDetails->where('status', 1);

                foreach( $details as $detail ) {
                    $row = new \stdClass();
                    $row->id = $detail->id;
                    $row->description = $detail->description;
                    $row->quantity = $detail->quantity;

                    $response['reference']->details[] = $row;
                }
            }
        }

        return response()->json( $response );
    }

    public function update( Request $request ) {
        $id = $request->id;
        $daysExecution = $request->daysExecution ? $request->daysExecution : 1;
        $warrantyMonth = $request->warrantyMonth ? $request->warrantyMonth : 12;

        $reference = Referenceterm::findOrFail( $id );
        $reference->activity = $request->activity;
        $reference->objective = $request->objective;
        $reference->execution_time_days = $daysExecution;
        $reference->execution_time_text = $reference->execution_time_text( $daysExecution );
        $reference->execution_address = $request->executionAddress;
        $reference->district_id = $request->district;
        $reference->address_reference = $request->addressReference;
        $reference->method_payment = $request->methodPayment;
        $reference->warranty_num = $warrantyMonth;
        $reference->warranty_text = $reference->warranty_text( $warrantyMonth );;
        $reference->obervations = $request->obervations;

        if( $reference->save() ) {
            $this->generatePdf( $reference );
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }
}
