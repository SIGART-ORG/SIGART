<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Access;

class SiteController extends Controller
{
    protected $_moduleDB = 'sites';

    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required',
        ] );
    }

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/site', [
            "menu" => 7,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
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
        return response()->json([
            'pagination' => [
                'total' => $module->total(),
                'current_page' => $module->currentPage(),
                'per_page' => $module->perPage(),
                'last_page' => $module->lastPage(),
                'from' => $module->firstItem(),
                'to' => $module->lastItem()
            ],
            'records' => $module
        ]);
    }

    public function select(Request $request){
        if(!$request->ajax()) return redirect('/');
        $sites = Site::where('status', '=', 1)
            ->select('id', 'name')
            ->orderBy('name', 'asc')->get();
        return response()->json(['sites' => $sites]);
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
        $this->logAdmin("Registró un nuevo sitio.");
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
        $this->logAdmin("Actualizó los datos del sitio:",$site);
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
        $this->logAdmin("Desactivó el sitio:".$site->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 1;
        $site->save();
        $this->logAdmin("Activó el sitio:".$site->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 2;
        $site->save();
        $this->logAdmin("Dió de baja el sitio:".$site->id);
    }
}
