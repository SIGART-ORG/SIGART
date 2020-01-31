<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\SalesQuotationsDetails;
use App\SalesQuote;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDetail;

use App\Models\SiteVourcher;
use App\QuotationProductsDetails;
class GenerateListMaterialsController extends Controller
{
    protected $_moduleDB = 'list-materials';
    protected $_page = 29;

    public function listMaterials($service){

        $breadcrumb = [
            [
                'name' => 'Listado de Materiales',
                'url' => route( 'services_request.list-materials',$service )
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
            'service_id'    => $service
        ]);
    }

    public function loadMaterials(ServiceRequest $service){

        $response = ServiceRequestDetail::where('status',1)
            ->where('service_requests_id',$service->id)->get();

        $saleQuotations = $service->salesQuotations->whereNotIn( 'status', [ 0, 2, 5, 7, 9 ] )
            ->sortBy( 'created_at' )->first();

        return [
            'records' => $response,
            "name_service" => $service->description
        ];
    }

    private function generateSalesQuotation( $idServiceRequest ) {

        $response = [
            'status' => false
        ];

        $salesQuotation = SalesQuote::whereNotIn( 'status', [ 0, 2, 5, 7, 9 ] )
            ->where( 'service_requests_id', $idServiceRequest )
            ->where( 'is_approved_customer', 0 )
            ->where( 'customer_login_id', 0 )
            ->first();

        if( ! $salesQuotation ) {

            $serviceRequest = ServiceRequest::whereNotIn( 'status', [0, 2] )
                ->where( 'id', $idServiceRequest )
                ->first();

            if( ! $serviceRequest ) {
                $response['msg'] = 'Hubo un problema al realizar la cotización.';
                return $response;
            }

            $typeVoucher        = 8;
            $SiteVoucherClass   = new SiteVourcher();
            $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher, 'details' );

            $salesQuotation = new SalesQuote();
            $salesQuotation->date_emission = date( 'Y-m-d' );
            $salesQuotation->type_vouchers_id = $typeVoucher;
            $salesQuotation->num_serie = $correlative['correlative']['serie'];
            $salesQuotation->num_doc = $correlative['correlative']['number'];
            $salesQuotation->service_requests_id = $idServiceRequest;
            $salesQuotation->customers_id = $serviceRequest->customers_id;
            $salesQuotation->is_approved_customer = 0;
            $salesQuotation->customer_login_id = 0;
            $salesQuotation->status = 1;
            if( ! $salesQuotation->save() ) {

                $SiteVoucherClass->increaseCorrelative($typeVoucher);

                $response['msg'] = 'No se pudo generar la cotización';
                return $response;
            }

        }

        $sqId = $salesQuotation->id;
        $response['status'] = true;
        $response['saleQuotation'] = $sqId;
        $response['collection'] = $salesQuotation;
        return $response;
    }

    private function generateItemSalesQuotation( $saleQuotation, $type ) {

        $response = [
            'status' => false
        ];

        $saleQuotationDetail = SalesQuotationsDetails::where( 'status', 1 )
            ->where( 'sales_quotations_id', $saleQuotation )
            ->where( 'type', $type )
            ->first();

        if( ! $saleQuotationDetail ) {
            $saleQuotationDetail = new SalesQuotationsDetails();
            $saleQuotationDetail->sales_quotations_id = $saleQuotation;
            $saleQuotationDetail->description = 'Total de materiales a usar.';
            $saleQuotationDetail->type = $type;
            if( ! $saleQuotationDetail->save() ) {
                $response['msg'] = 'No se puedo registrar el item de cotización.';
                return $response;
            }
        }

        $response['status'] = true;
        $response['detail'] = $saleQuotationDetail;

        return $response;
    }

    public function storeMaterialesRequest(Request $request)
    {

        if( ! $request->ajax() ) return redirect('/');

        $response = [
            'status' => false
        ];

        if( count($request->listmatariales) >  0) {

            $srId = $request->id_service;

            $salesQuotation = $this->generateSalesQuotation( $srId );

            if( $salesQuotation['status'] ) {
                $sqId = $salesQuotation['saleQuotation'];

                $detailQuotation = $this->generateItemSalesQuotation( $sqId, 1 );

                if( $detailQuotation['status'] ) {

                    $quotationDetailId = $detailQuotation['detail']->id;
                    $total = 0;

                    QuotationProductsDetails::where( 'sales_quotations_details_id', $quotationDetailId )
                        ->where( 'status', '!=', 2 )
                        ->update([
                            'status' => 2
                        ]);

                    foreach ( $request->listmatariales as $req ){
                        $diference = 0;
                        if( $req['quantity'] > $req['stock'] ) {
                            $diference = $req['quantity'] - $req['stock'];
                        }

                        $quotationProductstDetails = QuotationProductsDetails::where( 'sales_quotations_details_id', $quotationDetailId )
                            ->where( 'presentation_id', $req['id'] )
                            ->first();

                        if( ! $quotationProductstDetails ) {
                            $quotationProductstDetails = new QuotationProductsDetails();
                        }

                        $quotationProductstDetails->sales_quotations_details_id = $quotationDetailId;
                        $quotationProductstDetails->presentation_id = $req['id'];
                        $quotationProductstDetails->quantity = $req['quantity'];
                        $quotationProductstDetails->price = $req['price'];
                        $quotationProductstDetails->difference = $diference;
                        $quotationProductstDetails->status = 1;
                        if( $quotationProductstDetails->save() ){
                            $total += ( $req['price'] * $req['quantity'] );
                        } else {
                            $this->logAdmin("Purchase request item not register. ({$quotationDetailId})", $req, 'error');
                        }
                    }

                    $detailQuotation['detail']->sub_total = $total;
                    $detailQuotation['detail']->save();

                    $response['status'] = true;
                    $response['msg'] = 'OK';

                } else {
                    $response['msg'] = $detailQuotation['msg'];
                }

            } else {
                $response['msg'] = $salesQuotation['msg'];
            }

        }else {
            $response['msg'] = 'No se puede generar la lista de cotización de materiales.';
        }

        return response()->json( $response );
    }
}
