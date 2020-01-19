<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;

class LogActionController extends Controller
{
    protected $_moduleDB = 'logs';
    protected $_page = 2;
    public function index(){

        $breadcrumb = [
            [
                'name' => 'Proveedores',
                'url' => ''
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];


        $permiso = Access::sideBar(  $this->_page );
        return view('mintos.content', [
            "menu"          =>  $this->_page,
            'sidebar'       => $permiso,
            "moduleDB"      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
        ]);
    }
}
