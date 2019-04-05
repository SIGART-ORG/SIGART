<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products');
    }


    public function mostSeen(){

    }

    public function apiAllProducts(Request $request){
//        if(!$request->ajax()) return redirect('/');
        $num_per_page = 21;
        $search = $request->search;
        if($search == '') {
            $response = Product::where('status', '!=', 2)
                ->orderBy('name', 'asc')
                ->paginate($num_per_page);
        }else{
            $response = Product::where('status', '!=', 2)
                ->where( function( $query ) use( $search ) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                })
                ->orderBy('name', 'asc')
                ->paginate($num_per_page);
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
