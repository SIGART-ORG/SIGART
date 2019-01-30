<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use App\Access;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\QueryDB\UserQuery;

class UserController extends Controller
{
    protected $users;
    public function __construct(UserQuery $users)
    {
        $this->users = $users;
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
        $key = "paginated_".$request->page;
        if($buscar == '' or $criterio_bd == "") {
            $users = Cache::remember($key, 1, function() use($num_per_page) {
                return $this->users->getPaginated($num_per_page);
            });
        }else{ 
            $key.= $criterio."-".$buscar;
            $users = Cache::remember($key, 1, function() use($num_per_page,$buscar,$criterio_bd) {
                return $this->users->getPaginated($num_per_page,$criterio_bd,$buscar);
            });
               
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

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/user', [
            "menu" => 2,
            'sidebar' => $permiso
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $user = $this->users->getModel();
        $user->password = bcrypt($request->documento);
        $user->role_id = $request->rol;
        $user->name = $request->nombre;
        $user->last_name = $request->apellido;
        $user->address = $request->direccion;
        $user->email = $request->correo;
        $user->document = $request->documento;
        $user->phone = $request->phone;
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
    public function update(UserRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $user = $this->users->findOrFail($request->id);
        $user->role_id = $request->rol;
        $user->name = $request->nombre;
        $user->last_name = $request->apellido;
        $user->address = $request->direccion;
        $user->email = $request->correo;
        $user->document = $request->documento;
        $user->phone = $request->phone;
        $user->birthday = date('Y-m-d', strtotime($request->cumpleanos));
        $user->date_entry = date('Y-m-d', strtotime($request->ingreso));
        $user->status = 1;
        $user->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 0;
        $user->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 1;
        $user->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 2;
        $user->save();
    }

    public function profile(){
        $permiso = Access::sideBar();
        return view('modules/profile', [
            "menu" => 0,
            'sidebar' => $permiso
        ]);
    }

    public function dataSesion(Request $request){
        if(!$request->ajax()) return redirect('/');
        $userId = Auth::user();
        $user = $this->users->findOrFail($userId);
        return $user[0];
    }
}
