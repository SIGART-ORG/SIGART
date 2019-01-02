<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;

class SiteController extends Controller
{
    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required',
        ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $buscar = $request->buscar;
        $criterio_bd = "name";
        if($buscar == '') {
            $module = Site::SelectList()
                ->FilterNotStatus(2)
                ->OrderBySite(['name', 'asc'])
                ->paginate($num_per_page);
        }else{
            $module = Site::SelectList()
                ->FilterNotStatus(2)
                ->SearchSite([$criterio_bd, $buscar])
                ->OrderBySite(['name', 'asc'])
                ->paginate($num_per_page);
        }
        return [
            'pagination' => [
                'total' => $module->total(),
                'current_page' => $module->currentPage(),
                'per_page' => $module->perPage(),
                'last_page' => $module->lastPage(),
                'from' => $module->firstItem(),
                'to' => $module->lastItem()
            ],
            'records' => $module
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
        $this->_validate();
        $site = new Site();
        $site->name = $request->nombre;
        $site->address = $request->address;
        $site->status = 1;
        $site->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->_validate();
        $site = Site::findOrFail($request->id);
        $site->name = $request->nombre;
        $site->address = $request->address;
        $site->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 0;
        $site->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 1;
        $site->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 2;
        $site->save();
    }
}
