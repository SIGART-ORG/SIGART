<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Module;
use App\Access;
use DB;

class AccessController extends Controller
{
    protected $_moduleDB = 'access';
    protected $_page = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $pagina = [];
        $modulo = new Module();
        $mod = $modulo->where('status', '<>', 2)->get();
        $page = new Page();
        $minimo = 0;
        foreach($mod as $index=>$fila){
            if($index == 0){
                $minimo = $fila['id'];
            }
            $pag = $page->where('status', '<>', 2)
                        ->where('module_id', $fila['id'])
                        ->select(DB::raw('id, name, icon, (SELECT access.id FROM access WHERE access.role_id = '.$request->role_id.' AND access.page_id = pages.id and access.status = 1) AS access'))
                        ->get();
            $pagina[$fila['id']]['modulo'] = $fila['id'];
            $pagina[$fila['id']]['pages'] = $pag;
        }
        $response = [
            'datos' => $mod,
            'pages' => $pagina,
            'minimo' => $minimo
        ];
        return $response;
    }

    public function dashboard($role){
        $breadcrumb = [
            [
                'name' => 'Módulos del sistema',
                'url' => route('role.dashboard')
            ],
            [
                'name' => 'Permisos de usuarios',
                'url' => route('access.dashboard', ['id' => $role])
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];
        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            'role' => $role,
            'menu'         =>  $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
        ]);
    }

    public function accessSystem(Request $request){
        $access = Access::where('role_id', $request->role_id)
                    ->where('page_id', $request->page_id)
                    ->get()
                    ->first();
        if(isset($access->id)){
            if($access->status == 1){
                $access->status = 2;
                $access->save();
            }else{
                $access->status = 1;
                $access->save();
            }
        }else{
            $register = new Access();
            $register->role_id = $request->role_id;
            $register->page_id = $request->page_id;
            $register->save();
        }
    }
}
