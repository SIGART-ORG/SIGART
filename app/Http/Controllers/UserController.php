<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{
    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required|max:50',
            'apellido'      => 'required|max:50',
            'direccion'      => 'required|max:300',
            'documento' => 'required|min:8|max:8',
            'cumpleanos' => 'required',
            'ingreso' => 'required',
            'correo' => 'required|email'
        ] );
    }

    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $num_per_page = 20;

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $criterio_bd = '';
        switch ($criterio){
            case 'nombre':
                $criterio_bd = 'users.name';
                break;
            case 'apellidos':
                $criterio_bd = 'users.last_name';
                break;
            case 'correo':
                $criterio_bd = 'users.email';
                break;
            case 'documento':
                $criterio_bd = 'users.document';
                break;
            case 'rol':
                $criterio_bd = 'roles.name';
                break;
        }

        if($buscar == '' or $criterio_bd == "") {
            $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                ->where('users.status', '<>', 2)
                ->select(
                    'users.id', 
                    'users.role_id', 
                    'users.name', 
                    'users.last_name', 
                    'users.email', 
                    'users.document', 
                    'users.birthday', 
                    'users.date_entry', 
                    'users.status', 
                    'users.address', 
                    'roles.name as role_name',
                    DB::raw("date_format(users.date_entry, '%Y') year_entry"),
                    DB::raw("(date_format(users.date_entry, '%c') -1) as month_entry"),
                    DB::raw("date_format(users.date_entry, '%e') day_entry"))
                ->orderBy('users.last_name', 'asc')
                ->paginate($num_per_page);
        }else{
            $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                ->where('users.status', '<>', 2)
                ->where($criterio_bd, 'like', '%'.$buscar.'%')
                ->select(
                    'users.id', 
                    'users.role_id', 
                    'users.name', 
                    'users.last_name', 
                    'users.email', 
                    'users.document', 
                    'users.birthday', 
                    'users.date_entry', 
                    'users.status', 
                    'users.address', 
                    'roles.name as role_name',
                    DB::raw("date_format(users.date_entry, '%Y') year_entry"),
                    DB::raw("(date_format(users.date_entry, '%c') - 1) as month_entry"),
                    DB::raw("date_format(users.date_entry, '%e') day_entry"))
                ->orderBy('users.last_name', 'asc')
                ->paginate($num_per_page);
        }

        return [
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'records' => $users
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
        $user = new User();
        $user->password = bcrypt($request->documento);
        $user->role_id = $request->rol;
        $user->name = $request->nombre;
        $user->last_name = $request->apellido;
        $user->address = $request->direccion;
        $user->email = $request->correo;
        $user->document = $request->documento;
        $user->birthday = date('Y-m-d', strtotime($request->cumpleanos));
        $user->date_entry = date('Y-m-d', strtotime($request->ingreso));
        $user->status = 1;
        $user->save();
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
        $user = User::findOrFail($request->id);
        $user->role_id = $request->rol;
        $user->name = $request->nombre;
        $user->last_name = $request->apellido;
        $user->address = $request->direccion;
        $user->email = $request->correo;
        $user->document = $request->documento;
        $user->birthday = date('Y-m-d', strtotime($request->cumpleanos));
        $user->date_entry = date('Y-m-d', strtotime($request->ingreso));
        $user->status = 1;
        $user->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->status = 0;
        $user->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->status = 1;
        $user->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->status = 2;
        $user->save();
    }
}
