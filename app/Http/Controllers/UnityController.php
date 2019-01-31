<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\Unity;

class UnityController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $root = $request->root;
        $search = $request->buscar;
        if($search != ""){
            $unity = Unity::where('status', '<>', 2)
                ->where('name', 'like', '%'.$search.'%')
                ->where('root', $root)
                ->orderBy('name', 'asc')
                ->paginate($num_per_page);
        }else{
            $unity = Unity::where('status', '<>', 2)
                ->where('root', $root)
                ->orderBy('name', 'asc')
                ->paginate($num_per_page);
        }

        return [
            'pagination' => [
                'total' => $unity->total(),
                'current_page' => $unity->currentPage(),
                'per_page' => $unity->perPage(),
                'last_page' => $unity->lastPage(),
                'from' => $unity->firstItem(),
                'to' => $unity->lastItem()
            ],
            'records' => $unity
        ];
    }

    public function dashboard($root = 0){
        $permiso = Access::sideBar();
        return view('modules/unity', [
            "root" => $root,
            "menu" => 11,
            'sidebar' => $permiso
        ]);
    }

    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        $unity = new Unity();
        $unity->name = $request->nombre;
        $unity->root = $request->root;
        $unity->equivalence = 0;
        $unity->status = 1;
        $unity->save();
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
        $unity = Unity::findOrFail($request->id);
        $unity->name = $request->nombre;
        $unity->save();
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
        $unity = Unity::findOrFail($request->id);
        $unity->status = 0;
        $unity->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $page = Unity::findOrFail($request->id);
        $page->status = 1;
        $page->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $unity = Unity::findOrFail($request->id);
        $unity->status = 2;
        $unity->save();
    }
}
