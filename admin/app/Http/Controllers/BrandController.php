<?php

namespace App\Http\Controllers;

use App\Access;
use App\Http\Requests\Brand\BrandCreateRequest;
use App\Http\Requests\Brand\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $_moduleDB = 'vuex';
    protected $_page = 0;

    public function index() {
        $records = Brand::whereNotIn( 'status', [2] )
            ->orderBy('name')
            ->paginate( self::PAGINATE );

        $brands = [];
        foreach ( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->name = $record->name;
            $row->description = $record->description;
            $row->icon = $record->icon;
            $row->status = $record->status;
            $row->presentations = $record->presentations->whereNotIn( 'status', [2] )->count();

            $brands[] = $row;
        }

        return response()->json([
            'status' => true,
            'pagination' => [
                'total' => $records->total(),
                'current_page' => $records->currentPage(),
                'per_page' => $records->perPage(),
                'last_page' => $records->lastPage(),
                'from' => $records->firstItem(),
                'to' => $records->lastItem()
            ],
            'brands' => $brands
        ], 200);
    }

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Marcas',
                'url' => route( 'brand.dashboard' )
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
            'component'     => 'brand'
        ]);
    }

    public function allBrands() {
        $records = Brand::where( 'status', 1 )
            ->orderBy('name')
            ->get();

        $brands = [];
        foreach ( $records as $record ) {
            $row = new \stdClass();
            $row->id = $record->id;
            $row->name = $record->name;

            $brands[] = $row;
        }

        return response()->json([
            'status' => true,
            'brands' => $brands
        ], 200);
    }

    public function store( BrandCreateRequest $request ) {
        $response = [
            'status' => false
        ];

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        if( $brand->save() ) {
            $response['status'] = true;
        }

        return response()->json( $response, 200 );
    }

    public function update( BrandUpdateRequest $request ) {
        $response = [
            'status' => false
        ];

        $brand = Brand::findOrFail( $request->id );
        $brand->name = $request->name;
        $brand->description = $request->description;
        if( $brand->save() ) {
            $response['status'] = true;
        }

        return response()->json( $response, 200 );
    }

    public function delete( Brand $brand ) {
        $response = [
            'status' => false
        ];

        $brand->status = 2;
        if( $brand->save() ) {
            $response['status'] = true;
        }

        return response()->json( $response, 200 );
    }

    public function activate( Request $request, Brand $brand ) {
        $response = [
            'status' => false
        ];
        if( $brand->status !== 2 ) {
            $brand->status = $request->activate ? 1 : 0;
            if( $brand->save() ) {
                $response['status'] = true;
            }
        }
        return response()->json( $response, 200 );
    }
}
