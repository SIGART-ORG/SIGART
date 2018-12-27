<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;

class SiteController extends Controller
{
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
        $criterio_bd = "name";
        if($buscar == '') {
            $module = Site::SelectList()
                ->FilterNotStatus(2)
                ->OrderBySite(['name', 'asc'])
                ->paginate($num_per_page);
        }else{
            $module = Site::SelectList()
                ->FilterNotStatus(2)
                ->SearchSite([$criterio_bd, $buscar])
                ->OrderBySite(['name', 'asc'])
                ->paginate($num_per_page);
        }
        return [
            'pagination' => [
                'total' => $module->total(),
                'current_page' => $module->currentPage(),
                'per_page' => $module->perPage(),
                'last_page' => $module->lastPage(),
                'from' => $module->firstItem(),
                'to' => $module->lastItem()
            ],
            'records' => $module
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
