<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QueryDB\IconQuery;
use App\Access;
use App\Http\Requests\IconRequest;
use App\Icon;

class IconController extends Controller
{
    protected $icons;

    public function __construct(IconQuery $icons)
    {
        $this->icons = $icons;
    }


    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/icon', [
            "menu" => 6,
            'sidebar' => $permiso
        ]);
    }
    
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $buscar = $request->buscar;
        $criterio_bd = "name";
        if($buscar == '' or $criterio_bd == "") {
            $icons = $this->icons->getPaginatedByField('status', '<>', 2,$num_per_page,'name', 'asc');
        }else{

            $icons = $this->icons->getPaginatedByField('status', '<>', 2,$num_per_page,'name', 'asc',$criterio_bd,$buscar);
        }
        return [
            'pagination' => [
                'total' => $icons->total(),
                'current_page' => $icons->currentPage(),
                'per_page' => $icons->perPage(),
                'last_page' => $icons->lastPage(),
                'from' => $icons->firstItem(),
                'to' => $icons->lastItem()
            ],
            'records' => $icons
        ];
    }

    public function select(Request $request){
        if(!$request->ajax()) return redirect('/');
        $icons = Icon::where('status', '<>', 2)
                    ->where('name', 'like', '%'.$request->search.'%')
                    ->orderBy('name', 'asc')
                    ->get();
        return ['icons' => $icons];
    }

    public function store(IconRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $icon = $this->icons->getModel();
        $icon->name = $request->nombre;
        $icon->group = $request->grupo;
        $icon->status = 1;
        $icon->save();
        $this->logAdmin("Registró un nuevo icono.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IconRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $icon = $this->icons->findOrFail($request->id);
        $icon->name = $request->nombre;
        $icon->group = $request->grupo;
        $icon->save();
        $this->logAdmin("Actualizó los datos del icono:",$icon);
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $icon = $this->icons->findOrFail($request->id);
        $icon->status = 0;
        $icon->save();
        $this->logAdmin("Desactivó el icono:".$icon->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $icon = $this->icons->findOrFail($request->id);
        $icon->status = 1;
        $icon->save();
        $this->logAdmin("Activó el icono:".$icon->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $icon = $this->icons->findOrFail($request->id);
        $icon->status = 2;
        $icon->save();
        $this->logAdmin("Dió de baja el icono:".$icon->id);
    }
}
