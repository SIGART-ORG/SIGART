<?php

namespace App\Http\Controllers;

use App\Helpers\HelperSigart;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function allRegister(Request $request){

        if(!$request->ajax()) return redirect('/');

        $departament = HelperSigart::completeNameUbigeo( $request->departament );

        $data = Province::orderBy('name', 'asc')
            ->where('departament_id', $departament)
            ->select('id', 'name')
            ->get();

        $provinces = [];
        foreach ( $data as $pro ) {
            $row = new \stdClass();
            $row->id = HelperSigart::completeNameUbigeo( $pro->id );
            $row->name = $pro->name;
            $provinces[] = $row;
        }
        return ['provinces' => $provinces];
    }
}
