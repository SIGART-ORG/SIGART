<?php

namespace App\Http\Controllers;

use App\Access;
use App\Presentation;
use App\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $_moduleDB = 'stock';
    protected $_page = 17;

    public function dashboard(){
        $breadcrumb = [
            [
                'name' => 'Materiales - Stock',
                'url' => route( 'stock.dashboard' )
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

    public function dashboardTool() {
        $this->_page = 27;

        $breadcrumb = [
            [
                'name' => 'Herramientas - Stock',
                'url' => route( 'stock.tool.dashboard' )
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

    public function index( Request $request ){

        if(!$request->ajax()) return redirect('/');

        $num_per_page = 20;
        $search = $request->search;
        $type = $request->typeproduct;
        $stock = ( $request->stock ? $request->stock : '' );

        $Presentation = new Presentation();

        if( $stock !== '' ) {
            $response = $Presentation::where( $Presentation::TABLE_NAME . '.status', 1 )
                ->whereNull( $Presentation::TABLE_NAME . '.products_id' )
                ->search( $search, $stock )
                ->join( 'unity', 'unity.id', '=', $Presentation::TABLE_NAME . '.unity_id' )
                ->columnsSelectStock( $stock )
                ->orderBy( 'stock', 'desc' )
                ->orderBy( $Presentation::TABLE_NAME . '.description', 'asc')
                ->paginate( $num_per_page );
        } else {
            $response = $Presentation::where( $Presentation::TABLE_NAME . '.status', 1 )
                ->where( 'products.status', 1 )
                ->search( $search, $stock )
                ->whereTypeProduct( $type )
                ->join( 'products', 'products.id', '=', $Presentation::TABLE_NAME . '.products_id' )
                ->join( 'unity', 'unity.id', '=', $Presentation::TABLE_NAME . '.unity_id' )
                ->join( 'categories', 'categories.id', '=', 'products.category_id' )
                ->columnsSelectStock( $stock )
                ->orderBy( 'stock', 'desc' )
                ->orderBy('products.name', 'asc')
                ->orderBy('categories.name', 'asc')
                ->paginate( $num_per_page );
        }

        return [
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $response
        ];
    }
}
