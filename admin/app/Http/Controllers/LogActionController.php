<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LogActionController extends Controller
{
    protected $_moduleDB = 'logs';
    protected $_page = 2;

    public function index( Request $request ){

        $fileLog = $request->filelog ? $request->filelog: '';
        $cryptFileLog = '';

        if( $fileLog !== '' ) {
            $cryptFileLog = Crypt::encrypt( $fileLog );
        }

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
            'menu'          =>  $this->_page,
            'sidebar'       => $permiso,
            'moduleDB'      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'filelog'       => $cryptFileLog !== '' ? $cryptFileLog : ''
        ]);
    }
}
