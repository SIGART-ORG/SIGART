<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    protected $_moduleDB    = 'tool';
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

    public function index( Request $request ) {

        $ToolClass = new Tool();
        $num_per_page = 20;

        $response = $ToolClass::where( $ToolClass::TABLE_NAME . '.status', '!=', 2 )
            ->where('unity.status', '!=', 2 )
            ->whereNull( $ToolClass::TABLE_NAME . '.products_id' )
            ->join( 'unity', 'unity.id', '=', $ToolClass::TABLE_NAME . '.unity_id' )
            ->select(
                $ToolClass::TABLE_NAME . '.id',
                $ToolClass::TABLE_NAME . '.sku',
                $ToolClass::TABLE_NAME . '.unity_id',
                $ToolClass::TABLE_NAME . '.description',
                'unity.name as unity_name'
            )
            ->orderBy( $ToolClass::TABLE_NAME . '.description', 'asc' )
            ->orderBy( $ToolClass::TABLE_NAME . '.sku', 'asc' )
            ->paginate( $num_per_page );

        return response()->json(
            [
                'pagination' => [
                    'total' => $response->total(),
                    'current_page' => $response->currentPage(),
                    'per_page' => $response->perPage(),
                    'last_page' => $response->lastPage(),
                    'from' => $response->firstItem(),
                    'to' => $response->lastItem()
                ],
                'records' => $response
            ]
        );
    }
}
