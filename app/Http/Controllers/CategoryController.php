<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
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
            $categories = Category::where('status', '<>', 2)->orderBy('name', 'asc')->paginate($num_per_page);
        }else{
            $categories = Category::where('status', '<>', 2)
                ->where($criterio_bd, 'like', '%'.$buscar.'%')
                ->orderBy('name', 'asc')->paginate($num_per_page);
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

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->_validate();
        $Category = new Category();
        $Category->name = $request->nombre;
        $Category->status = 1;
        $Category->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->_validate();
        $Category = Category::findOrFail($request->id);
        $Category->name = $request->nombre;
        $Category->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $Category = Category::findOrFail($request->id);
        $Category->status = 0;
        $Category->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $Category = Category::findOrFail($request->id);
        $Category->status = 1;
        $Category->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $Category = Category::findOrFail($request->id);
        $Category->status = 2;
        $Category->save();
    }
}
