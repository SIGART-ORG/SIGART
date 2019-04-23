<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
use Illuminate\Http\Request;

class CustomersControllers extends Controller
{
    protected $_moduleDB = 'customers';

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/pages', [
            "menu" => 16,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
        ]);
    }

    public function configProvider(Request $request){

        if(!$request->ajax()) return redirect('/');

        $typePersons = HelperSigart::getTypePerson();
        $typeTelephone = HelperSigart::getTypeTelephone();

        return [
            'typePerson' => $typePersons,
            'typeTelephone' => $typeTelephone
        ];


    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
