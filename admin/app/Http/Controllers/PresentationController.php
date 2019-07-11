<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Presentation;

class PresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function select( Request $request ){
        $presentation = Presentation::where('status', '=', 1)
            ->where('products_id', $request->id )
            ->select('id', 'products_id', 'unity_id', 'description', 'equivalence')
            ->orderBy('id', 'asc')
            ->get();

        $newArray = [];
        foreach( $presentation as $idx => $pres ){
            $newArray[] = [
                'id' => $idx,
                'description' => $pres->description,
                'unity' => $pres->unity_id,
                'equivalence' => $pres->equivalence,
                'delete' => 0,
                'idTable'=> $pres->id
            ];
        }
        return ['presentation' => $newArray];
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
