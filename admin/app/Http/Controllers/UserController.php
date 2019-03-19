<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use App\Access;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\QueryDB\UserQuery;
use Image;

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
        $key = "paginated_".$request->page;

        if($buscar != '' ) {
            $key.= "-".$buscar;
        }
        $users = Cache::remember($key, 1, function() use($num_per_page,$buscar) {
            return $this->users->getPaginated($num_per_page, $buscar);
        });

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

        $this->logAdmin("Registró un nuevo usuario.");
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
        $this->logAdmin("Actualizó los datos del usuario:",$user);
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 0;
        $user->save();
        $this->logAdmin("Desactivó al usuario:".$user->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 1;
        $user->save();
        $this->logAdmin("Activó al usuario:".$user->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 2;
        $user->save();
        $this->logAdmin("Dió de baja al usuario:".$user->id);
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

    public function saveData(Request $request){
        $ruta = public_path().'/user/'.$request->id.'/';
        if (!file_exists($ruta)) {
            mkdir($ruta, 0755, true);
        }
        // recogida del form
        $imagenOriginal = $request->file('profile');
        $imagen = Image::make($imagenOriginal);
        $temp_name = $this->random_string() . '.' . $imagenOriginal->getClientOriginalExtension();
        $imagen->resize(300,300);
        $imagen->save($ruta . $temp_name, 100);

    }

    protected function random_string()
    {
        $key = '';
        $keys = array_merge( range('a','z'), range(0,9) );

        for($i=0; $i<10; $i++)
        {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
}
