<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;

class HolidayController extends Controller
{
    protected function _validate() {
        $this->validate( request(), [
            'day'      => 'required',
            'month'      => 'required',
            'description'      => 'required',
        ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $criterio_bd = "";
        switch ($criterio){
            case 'nombre':
                $criterio_bd = 'description';
                break;
        }
        if($buscar == '' or $criterio_bd == "") {
            $holiday = Holiday::SelectList()
                ->FilterNotStatus(2)
                ->orderBy('month', 'asc')
                ->orderBy('day', 'asc')
                ->paginate($num_per_page);
        }else{
            $holiday = Holiday::SelectList()
                ->FilterNotStatus(2)
                ->Search([$criterio_bd, $buscar])
                ->orderBy('month', 'asc')
                ->orderBy('day', 'asc')
                ->paginate($num_per_page);
        }
        return [
            'pagination' => [
                'total' => $holiday->total(),
                'current_page' => $holiday->currentPage(),
                'per_page' => $holiday->perPage(),
                'last_page' => $holiday->lastPage(),
                'from' => $holiday->firstItem(),
                'to' => $holiday->lastItem()
            ],
            'records' => $holiday
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
        $holiday = new Holiday();
        $holiday->day = $request->day;
        $holiday->month = $request->month;
        $holiday->description = $request->description;
        $holiday->status = 1;
        $holiday->save();
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
        $holiday = Holiday::findOrFail($request->id);
        $holiday->day = $request->day;
        $holiday->month = $request->month;
        $holiday->description = $request->description;
        $holiday->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $holiday = Holiday::findOrFail($request->id);
        $holiday->status = 2;
        $holiday->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $holiday = Holiday::findOrFail($request->id);
        $holiday->status = 0;
        $holiday->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $holiday = Holiday::findOrFail($request->id);
        $holiday->status = 1;
        $holiday->save();
    }
}
