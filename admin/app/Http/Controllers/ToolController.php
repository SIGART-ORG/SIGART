<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    protected $_moduleDB    = 'input-order';
    protected $_page        = 26;

    public function dashboard() {
        $breadcrumb = [
            [
                'name' => 'Herramientas',
                'url' => route( 'tool.index' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar( $this->_page );

        return view('mintos.content', [
            'menu'          => $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
        ]);
    }
}
