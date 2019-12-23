<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use App\ServiceRequest;
use App\Models\ServiceRequestDetail;
class GenerateListMaterialsController extends Controller
{
    protected $_moduleDB = 'list-materials';
    protected $_page = 29;

    public function listMaterials($service){
        //dd($service);
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

    public function storeMaterialesRequest(){

    }
}
