<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;

class LogActionController extends Controller
{
    protected $_moduleDB = 'logs';

    public function index(){
        $permiso = Access::sideBar();
        return view('modules.log', [
            "menu" => 2,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
        ]);
    }
}
