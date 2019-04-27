<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductsImages;
use App\Products;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $response = ProductsImages::where('status', 1)
            ->where('products_id', $request->id)
            ->select(
                'id',
                'products_id',
                'image_admin',
                'image_default'
            )
            ->get();
        return [ 'galery' => $response ];
    }

    public function defaultImage( Request $request ){

        ProductsImages::where('products_id', $request->product)
                            ->where('image_default', 1)
                            ->update([
                                'image_default' => 0
                            ]);

        $newDefault = ProductsImages::findOrFail($request->id);
        $newDefault->image_default = 1;
        $newDefault->update();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}