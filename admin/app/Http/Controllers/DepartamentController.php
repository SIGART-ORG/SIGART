<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departament;

class DepartamentController extends Controller
{
    public function allRegister(Request $request){

        if(!$request->ajax()) return redirect('/');

        $departaments = Departament::orderBy('name', 'asc')
            ->select('id', 'name')
            ->get();
        return ['departaments' => $departaments];
    }
}
