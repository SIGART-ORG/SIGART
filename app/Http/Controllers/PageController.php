<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required',
        ] );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $num_per_page = 20;

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $criterio_bd = '';
        switch ($criterio){
            case 'nombre':
                $criterio_bd = 'pages.name';
                break;
            case 'modulo':
                $criterio_bd = 'modules.name';
                break;
        }

        if($buscar == '' or $criterio_bd == "") {
            $pages = Page::join('modules', 'pages.module_id', '=', 'modules.id')
                ->where('modules.status', '<>', 2)
                ->where('pages.status', '<>', 2)
                ->select(
                    'pages.id', 
                    'pages.module_id', 
                    'pages.name', 
                    'pages.view_panel', 
                    'pages.url', 
                    'pages.status', 
                    'modules.name as module_name'
                    )
                ->orderBy('pages.name', 'asc')
                ->paginate($num_per_page);
        }else{
            $pages = Page::join('modules', 'pages.module_id', '=', 'modules.id')
                ->where('modules.status', '<>', 2)
                ->where('pages.status', '<>', 2)
                ->where($criterio_bd, 'like', '%'.$buscar.'%')
                ->select(
                    'pages.id',
                    'pages.module_id', 
                    'pages.name', 
                    'pages.view_panel', 
                    'pages.url', 
                    'pages.status', 
                    'modules.name as module_name')
                ->orderBy('pages.name', 'asc')
                ->paginate($num_per_page);
        }

        return [
            'pagination' => [
                'total' => $pages->total(),
                'current_page' => $pages->currentPage(),
                'per_page' => $pages->perPage(),
                'last_page' => $pages->lastPage(),
                'from' => $pages->firstItem(),
                'to' => $pages->lastItem()
            ],
            'records' => $pages
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
        $page = new Page();
        $page->name = $request->nombre;
        $page->url = $request->url;
        $page->module_id = $request->modulo;
        $page->status = 1;
        $page->save();
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
        $page = Page::findOrFail($request->id);
        $page->name = $request->nombre;
        $page->url = $request->url;
        $page->module_id = $request->modulo;
        $page->save();
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
        $page = Page::findOrFail($request->id);
        $page->status = 0;
        $page->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $page = Page::findOrFail($request->id);
        $page->status = 1;
        $page->save();
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $page = Page::findOrFail($request->id);
        $page->status = 2;
        $page->save();
    }
}