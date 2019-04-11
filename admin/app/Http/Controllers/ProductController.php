<?php

namespace App\Http\Controllers;

use App\Access;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str as Str;
use Image;

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
                ->selectRaw('(select 
                                    products_images.image_admin
                                from 
                                    products_images 
                                where products_images.products_id = products.id and products_images.status = 1
                                    and products_images.image_default = 1
                                limit 1 ) as image')
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
                ->selectRaw('(select 
                                    products_images.image_admin
                                from 
                                    products_images 
                                where products_images.products_id = products.id and products_images.status = 1
                                    and products_images.image_default = 1
                                limit 1 ) as image')
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

    public function upload(Request $request){
        if($request->file('file')) {
            $marcaAgua = public_path() . '/images/marca_agua.png';

            /*carpeta Products debe de estar con permiso www-data*/
            $path = public_path().'/products/';
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $image = $request->file('file');

            $img = Image::make($image);
            $uniqid = uniqid();
            $tempNameOriginal   = 'image-original-' . $uniqid . '.' . $image->getClientOriginalExtension();
            $tempNameGalery     = 'image-galery-' . $uniqid . '.' . $image->getClientOriginalExtension();
            $tempNameAdmin      = 'image-admin-' . $uniqid . '.' . $image->getClientOriginalExtension();
            $tempNamefacebook   = 'image-facebbok-' . $uniqid . '.' . $image->getClientOriginalExtension();

            $img->save($path . $tempNameOriginal, 100);

            $watermark = Image::make( $marcaAgua );
            $watermark->opacity(30);
            $img->insert( $watermark, 'center', 10, 10 );

            $img->resize( 350, 230 );
            $img->save( $path . $tempNameAdmin, 100 );

            $img->resize( 255, 167 );
            $img->save( $path . $tempNameGalery, 100 );

            $img->resize( 1200, 628 );
            $img->save( $path . $tempNamefacebook, 100 );

            $default = 0;
            $existImages = \App\ProductsImages::where('products_id', $request->id)
                ->where('image_default', 1)->doesntExist();
            if($existImages){
                $default = 1;
            }

            $productsImage = new \App\ProductsImages();
            $productsImage->products_id = $request->id;
            $productsImage->image_original = $tempNameOriginal;
            $productsImage->image_galery = $tempNameGalery;
            $productsImage->image_admin = $tempNameAdmin;
            $productsImage->image_facebook = $tempNamefacebook;
            $productsImage->image_default = $default;
            $productsImage->save();


            return Response()->json([
                'status' => 200
            ]);
        }else {
            return Response()->json(array('test'=>false));
        }
    }
}
