<?php

namespace App\Http\Controllers;

use App\Helpers\HelperSigart;
use App\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function allRegister(Request $request){

        if(!$request->ajax()) return redirect('/');

        $departament = HelperSigart::completeNameUbigeo( $request->departament );

        $provinces = Province::orderBy('name', 'asc')
            ->where('departament_id', $departament)
            ->select('id', 'name')
            ->get();
        return ['provinces' => $provinces];
    }
}
