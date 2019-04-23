<?php

namespace App\Http\Controllers;

use App\Helpers\HelperSigart;
use App\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function allRegister(Request $request) {
        if(!$request->ajax()) return redirect('/');

        $departament = HelperSigart::completeNameUbigeo( $request->departament );
        $province = HelperSigart::completeNameUbigeo( $request->pronvince );

        $districts = District::orderBy('name', 'asc')
            ->where('departament_id', $departament)
            ->where('province_id', $province)
            ->select('id', 'name')
            ->get();
        return ['districts' => $districts];
    }
}
