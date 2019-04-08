<?php

namespace App\Http\Controllers;

use App\Access;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str as Str;

class ProductController extends Controller
{

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/product', [
            "menu" => 14,
            'sidebar' => $permiso
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 21;
        $search = $request->search;

        if($search == '') {
            $response = Product::where('products.status', '!=', 2)
                ->where('unity.status', 1)
                ->where('categories.status', 1)
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('unity', 'unity.id', '=', 'products.unity_id')
                ->orderBy('products.name', 'asc')
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
                    'categories.name as category',
                    'unity.name as unity'
                )
                ->paginate($num_per_page);
        }else{
            $response = Product::where('products.status', '!=', 2)
                ->where('unity.status', 1)
                ->where('categories.status', 1)
                ->where( function( $query ) use( $search ) {
                    $query->where('products.name', 'like', '%'.$search.'%')
                        ->orWhere('products.description', 'like', '%'.$search.'%');
                })
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('unity', 'unity.id', '=', 'products.unity_id')
                ->orderBy('products.name', 'asc')
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
                    'categories.name as category',
                    'unity.name as unity'
                )
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $user_id = Auth::user()->id;

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->unity_id = $request->unity_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->pricetag = $request->pricetag;
        $product->slug = Str::slug( $request->name );
        $product->status = 1;
        $product->user_reg = $user_id;
        $product->save();
        $this->logAdmin("Registró un nuevo producto( {$request->nombre} ).");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $product = Product::findOrFail($request->id);
        $product->category_id = $request->category_id;
        $product->unity_id = $request->unity_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->pricetag = $request->pricetag;
        $product->slug = Str::slug( $request->name );
        $product->save();

        $this->logAdmin("Actualizó los datos del producto: ", $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $product = Product::findOrFail($request->id);
        $product->status = 2;
        $product->save();

        $this->logAdmin("Dió de baja el producto: ".$product->id);
    }
}
