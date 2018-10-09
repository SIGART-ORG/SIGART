<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required',
        ] );
    }

    public function index (Request $request){
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
            $roles = Role::where('status', '<>', 2)->orderBy('name', 'asc')->paginate($num_per_page);
        }else{
            $roles = Role::where('status', '<>', 2)
                ->where($criterio_bd, 'like', '%'.$buscar.'%')
                ->orderBy('name', 'asc')->paginate($num_per_page);
        }
        return [
            'pagination' => [
                'total' => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page' => $roles->perPage(),
                'last_page' => $roles->lastPage(),
                'from' => $roles->firstItem(),
                'to' => $roles->lastItem()
            ],
            'records' => $roles
        ];
    }

    public function selectRole(Request $request){
        if(!$request->ajax()) return redirect('/');
        $roles = Role::where('status', '=', 1)
            ->select('id', 'name')
            ->orderBy('name', 'asc')->get();
        return ['roles' => $roles];
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
        $role = new Role();
        $role->name = $request->nombre;
        $role->status = 1;
        $role->save();
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
        $role = Role::findOrFail($request->id);
        $role->name = $request->nombre;
        $role->save();
    }

    public function show(Request $request){
        if(!$request->ajax()) return redirect('/');
        $role = Role::findOrFail($request->id);
        return $role;
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
        $role = Role::findOrFail($request->id);
        $role->status = 0;
        $role->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $role = Role::findOrFail($request->id);
        $role->status = 1;
        $role->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $role = Role::findOrFail($request->id);
        $role->status = 2;
        $role->save();
    }
}
