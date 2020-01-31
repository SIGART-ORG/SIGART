<?php

namespace App\Http\Controllers;

use App\Helpers\HelperSigart;
use Illuminate\Http\Request;
use App\Models\Departament;

class DepartamentController extends Controller
{
    public function allRegister(Request $request){

        if(!$request->ajax()) return redirect('/');

        $data = Departament::orderBy('name', 'asc')
            ->select('id', 'name')
            ->get();

        $departaments = [];
        foreach ( $data as $dep ) {
            $row = new \stdClass();
            $row->id = HelperSigart::completeNameUbigeo( $dep->id );
            $row->name = $dep->name;
            $departaments[] = $row;
        }
        return ['departaments' => $departaments];
    }
}
