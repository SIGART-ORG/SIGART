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
        $records = [];
        $saleQuotation = SalesQuote::whereNotIn( 'status', [ 0, 2, 5, 7, 9 ] )
            ->where( 'service_requests_id', $service->id )
            ->orderBy( 'created_at', 'desc' )
            ->first();

        if( $saleQuotation ) {
            $details = $saleQuotation->salesQuotationsDetails->where( 'status',1 )
                ->where( 'includes_products', 1 );

            foreach ( $details as $detail ) {

                $row = new \stdClass();
                $row->id = $detail->id;
                $row->description = $detail->description;
                $row->quantity = $detail->quantity;
                $row->totalProducts = $detail->total_products;
                $row->products = $this->formatItemsProducts( $detail->quotationProducstDetails->where( 'status', 1 ) );

                $records[] = $row;
            }
        }

        return [
            'records' => $records,
            'saleQuotation' => $saleQuotation->id,
            'name_service' => $service->description
        ];
    }

    private function formatItemsProducts( $collections ) {
        $details = [];

        if( $collections ) {
            foreach( $collections as $collection ) {

                $presentation = $collection->presentation;
                $product = $presentation->product;
                $category = $product->category;
                $unity = $presentation->unity;

                $productName = $presentation->sku;
                $productName .= ' ' . $category->name;
                $productName .= ' ' . $product->name;
                $productName .= ' ' . $presentation->description;

                $priceUnit = $collection->quantity > 0 ? round( $collection->price / $collection->quantity , 2 ) : 0;

                $stocks = $presentation->stocks->where( 'sites_id', session( 'siteDefault') )->first;
                $stock = $stocks->id && $stocks->id->stock > 0 ? $stocks->id->stock : 0;

                $row = new \stdClass();
                $row->id = $collection->id;
                $row->presentation = $presentation->id;
                $row->product = $productName;
                $row->quantity = $collection->quantity;
                $row->unity = $unity->name;
                $row->price = $priceUnit;
                $row->stock = $stock;
                $details[] = $row;
            }
        }

        return $details;
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

//        if( ! $request->ajax() ) return redirect('/');

        $count = 0;
        $saleQuotation = $request->saleQuotation ? $request->saleQuotation : 0;
        $details = $request->details ? $request->details : [];
        $response = [
            'status' => true,
        ];

        if( $details && $saleQuotation > 0 ) {
            foreach ( $details as $detail ) {
                $salesQuotationDetail = $detail['id'];

                $total = 0;

                $salesQuotationDetailClass = SalesQuotationsDetails::findorFail( $salesQuotationDetail );

                if( $salesQuotationDetailClass->includes_products ) {
                    QuotationProductsDetails::where('status', 1)->where('sales_quotations_details_id', $salesQuotationDetail)->update(['status' => 2]);

                    $products = $detail['products'];
                    if ($products) {
                        foreach ($products as $product) {
                            $diference = 0;
                            if ($product['quantity'] > $product['stock']) {
                                $diference = $product['quantity'] - $product['stock'];
                            }
                            if ($product['presentation'] > 0 && $product['quantity'] > 0) {
                                $quotationProductstDetails = new QuotationProductsDetails();
                                $quotationProductstDetails->sales_quotations_details_id = $salesQuotationDetail;
                                $quotationProductstDetails->presentation_id = $product['presentation'];
                                $quotationProductstDetails->quantity = $product['quantity'];
                                $quotationProductstDetails->price = $product['price'];
                                $quotationProductstDetails->difference = $diference;
                                $quotationProductstDetails->status = 1;
                                if ($quotationProductstDetails->save()) {
                                    $count++;
                                    $total += ($product['price'] * $product['quantity']);
                                } else {
                                    $this->logAdmin("Purchase request item not register. ({$salesQuotationDetail})", $product, 'error');
                                }
                            }
                        }
                    }

                    $subtotal = $total + $salesQuotationDetailClass->workforce;
                    $igv = round( $subtotal * 0.18, 2 );
                    $salesQuotationDetailClass->total_products = $total;
                    $salesQuotationDetailClass->sub_total = $subtotal;
                    $salesQuotationDetailClass->igv = $igv;
                    $salesQuotationDetailClass->total = $subtotal + $igv;
                    $salesQuotationDetailClass->save();
                }

            }
        }

        if( $saleQuotation > 0 ) {
            $this->updateGeneral( $saleQuotation );
        }

        $response['count'] = $count;

        return response()->json( $response );
    }

    private function updateGeneral( $id ) {
        $saleQuotation = SalesQuote::find( $id );
        $subTotal = 0;
        if( $saleQuotation ) {
            $details = $saleQuotation->salesQuotationsDetails->where('status', 1);
            if( $details ) {
                foreach( $details as $detail ) {
                    $subTotal = $detail->workforce;
                    $subTotal += $detail->includes_products === 1 ? $detail->total_products : 0;
                }
            }
            dd( $subTotal );

            $igv = round( 0.18 * $subTotal, 2 );
            $total = $subTotal + $igv;
            $saleQuotation->subtot_sale = $subTotal;
            $saleQuotation->tot_igv = $igv;
            $saleQuotation->tot_gral = $total;
            $saleQuotation->save();
        }

        return true;
    }
}
