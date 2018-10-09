<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Icon;

class IconController extends Controller
{
    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required',
        ] );
    }
    
    public function index(Request $request){
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
            $icons = Icon::where('status', '<>', 2)->orderBy('name', 'asc')->paginate($num_per_page);
        }else{
            $icons = Icon::where('status', '<>', 2)
                ->where($criterio_bd, 'like', '%'.$buscar.'%')
                ->orderBy('name', 'asc')->paginate($num_per_page);
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

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->_validate();
        $icon = new Icon();
        $icon->name = $request->nombre;
        $icon->status = 1;
        $icon->save();
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
        $icon = Icon::findOrFail($request->id);
        $icon->name = $request->nombre;
        $icon->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $icon = Icon::findOrFail($request->id);
        $icon->status = 0;
        $icon->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $icon = Icon::findOrFail($request->id);
        $icon->status = 1;
        $icon->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $icon = Icon::findOrFail($request->id);
        $icon->status = 2;
        $icon->save();
    }
}
