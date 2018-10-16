<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModuleListRequest;
use App\Module;

class ModuleController extends Controller
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
    public function index(ModuleListRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $criterio_bd = "";
        switch ($criterio){
            case 'nombre':
                $criterio_bd = 'name';
                break;
        }
        if($buscar == '' or $criterio_bd == "") {
            $module = Module::SelectList()
                        ->FilterNotStatus(2)
                        ->OrderByModule(['name', 'asc'])
                        ->paginate();
        }else{
            $module = Module::SelectList()
                        ->FilterNotStatus(2)
                        ->SearchModule([$criterio_bd, $buscar])
                        ->OrderByModule(['name', 'asc'])
                        ->paginate();
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

    public function selectModule(Request $request){
        if(!$request->ajax()) return redirect('/');
        $modules = Module::where('status', '=', 1)
            ->select('id', 'name')
            ->OrderByModule(['name', 'asc'])
            ->get();
        return ['modules' => $modules];
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
        $module = new Module();
        $module->name = $request->nombre;
        $module->icon = $request->icon;
        $module->status = 1;
        $module->save();
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
        $module = Module::findOrFail($request->id);
        $module->name = $request->nombre;
        $module->icon = $request->icon;
        $module->save();
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
        $module = Module::findOrFail($request->id);
        $module->status = 0;
        $module->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $module = Module::findOrFail($request->id);
        $module->status = 1;
        $module->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $module = Module::findOrFail($request->id);
        $module->status = 2;
        $module->save();
    }
}
