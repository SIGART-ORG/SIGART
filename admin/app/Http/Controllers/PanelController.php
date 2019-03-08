<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;

class PanelController extends Controller
{
    public function index(){

        $permiso = Access::sideBar();
        return view('dashboard', [
            'menu' => 0,
            'sidebar' => $permiso
        ]);
    }
}
