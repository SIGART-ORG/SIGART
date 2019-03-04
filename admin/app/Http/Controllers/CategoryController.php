<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QueryDB\CategoryQuery;
use App\Access;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
{
    protected $categories;
    public function __construct(CategoryQuery $categories)
    {
        $this->categories = $categories;
    }
    

    public function dashboard(){
        $permiso = Access::sideBar();
        return view('modules/categories', [
            "menu" => 8,
            'sidebar' => $permiso
        ]);
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
            $categories = $this->categories->getPaginatedByField('status', '<>',2,$num_per_page,'name','asc');
        }else{
            $categories = $this->categories->getPaginatedByField('status', '<>',2,$num_per_page,'name','asc',$criterio_bd,$buscar);
        }
        return [
            'pagination' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem()
            ],
            'records' => $categories
        ];
    }

    public function store(CategoryRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $Category = $this->categories->getModel();
        $Category->name = $request->nombre;
        $Category->status = 1;
        $Category->save();
        $this->logAdmin("Registró una nueva categoría.");
    }

    public function update(CategoryRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
 
        $Category = $this->categories->findOrFail($request->id);
        $Category->name = $request->nombre;
        $Category->save();
        $this->logAdmin("Actualizó los datos de la categoría:", $Category);
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $Category = $this->categories->findOrFail($request->id);
        $Category->status = 0;
        $Category->save();
        $this->logAdmin("Desactivó la categoría:".$Category->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $Category = $this->categories->findOrFail($request->id);
        $Category->status = 1;
        $Category->save();
        $this->logAdmin("Activó la categoría:".$Category->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $Category = $this->categories->findOrFail($request->id);
        $Category->status = 2;
        $Category->save();
        $this->logAdmin("Dió de baja la categoría:".$Category->id);
    }
}
