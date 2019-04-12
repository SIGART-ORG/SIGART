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
            $response = Product::where('products.status', '!=', 2)
                ->where('categories.status', 1)
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.id',
                    'products.category_id',
                    'products.unity_id',
                    'products.user_reg',
                    'products.name',
                    'products.description',
                    'products.pricetag',
                    'products.slug',
                    'products.status',
                    'categories.name as category'
                )
                ->selectRaw('(select 
                                    products_images.image_admin
                                from 
                                    products_images 
                                where products_images.products_id = products.id and products_images.status = 1
                                    and products_images.image_default = 1
                                limit 1 ) as image')
                ->orderBy('name', 'asc')
                ->paginate($num_per_page);
        }else{
            $response = Product::where('products.status', '!=', 2)
                ->where( function( $query ) use( $search ) {
                    $query->where('products.name', 'like', '%'.$search.'%')
                        ->orWhere('products.description', 'like', '%'.$search.'%');
                })
                ->where('categories.status', 1)
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.id',
                    'products.category_id',
                    'products.unity_id',
                    'products.user_reg',
                    'products.name',
                    'products.description',
                    'products.pricetag',
                    'products.slug',
                    'products.status',
                    'categories.name as category'
                )
                ->selectRaw('(select 
                                    products_images.image_admin
                                from 
                                    products_images 
                                where products_images.products_id = products.id and products_images.status = 1
                                    and products_images.image_default = 1
                                limit 1 ) as image')
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

    public function show( Request $request ) {

    }
}
