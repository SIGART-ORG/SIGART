<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use App\ServiceRequest;
use App\Models\ServiceRequestDetail;

use App\Models\SiteVourcher;
use App\QuotationProducts;
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
        //dd($request->id);

        $response = ServiceRequestDetail::where('status',1)->where('service_requests_id',$service->id)->paginate(20);
        return [
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $response,
            "name_service" => $service->description
        ];
    }

    public function storeMaterialesRequest(Request $request)
    {

        if( ! $request->ajax() ) return redirect('/');

        if( count($request->listmatariales) >  0) {
            $quotationproducts = new QuotationProducts();

            $typeVoucher        = 8;
            $SiteVoucherClass   = new SiteVourcher();
            $correlative        = $SiteVoucherClass->getNumberVoucherSite( $typeVoucher, 'details' );
            $quotationproducts->service_request_id = $request->id_service;
            $quotationproducts->correlative_serie = $correlative['correlative']["serie"];
            $quotationproducts->correlative_number = $correlative['correlative']["number"];
            $quotationproducts->total = $request->price_total;

            if($quotationproducts->save()){
                $newquotationproductsId = $quotationproducts->id;
                foreach ( $request->listmatariales as $req ){
                    $quotationProductstDetails = new QuotationProductsDetails();
                    $quotationProductstDetails->quotation_produc_id = $newquotationproductsId;
                    $quotationProductstDetails->presentation_id = $req['id'];
                    $quotationProductstDetails->quantity = $req['quantity'];
                    $quotationProductstDetails->difference = (int)$req['stock']  - (int)$req["quantity"];
                    $quotationProductstDetails->status = 1;
                    if( !$quotationProductstDetails->save() ){
                        $this->logAdmin("Purchase request item not register. ({$newquotationproductsId})", $req, 'error');
                    }
                }
                $SiteVoucherClass->increaseCorrelative($typeVoucher);
                return response()->json(['status' => true], 200);
            }else{
                return response()->json(['status' => false], 200);
            }

        }
        return response()->json(['status' => false], 200);
    }
}
