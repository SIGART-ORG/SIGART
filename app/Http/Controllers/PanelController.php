<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;

class PanelController extends Controller
{
    public function index(){

        $permiso = Access::sideBar();
        return view('inc/contenido', [
            'sidebar' => $permiso 
        ]);
    }
}
