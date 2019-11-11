<?php

namespace App\Http\Controllers;

use App\Access;
use App\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $_moduleDB = 'stock';

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/pages', [
            "menu" => 17,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
        ]);
    }

    public function index( Request $request ){
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 21;
        $search = $request->search;
        $type = $request->typeproduct;

        $response = Product::where('products.status', '!=', 2)
            ->where('unity.status', 1)
            ->where('categories.status', 1)
            ->search( $search )
            ->whereTypeProduct( $type )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('presentation', 'presentation.products_id', '=', 'products.id')
            ->join('unity', 'unity.id', '=', 'presentation.unity_id')
            ->orderBy( 'stock', 'desc' )
            ->orderBy('products.name', 'asc')
            ->orderBy('categories.name', 'asc')
            ->columnsSelect()
            ->paginate($num_per_page);

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
