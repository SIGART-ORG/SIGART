<?php

namespace App\Http\Controllers;

use App\Access;
use App\Models\Tool;
use App\Models\ToolLog;
use App\Models\ToolStock;
use App\Site;
use Illuminate\Http\Request;
use \Illuminate\Support\Str;

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

        $siteID = session( 'siteDefault' );
        $site = Site::find( $siteID );
        $ToolClass = new Tool();
        $num_per_page = 20;

        $tools = [];

        $response = $ToolClass::where( $ToolClass::TABLE_NAME . '.status', '!=', 2 )
            ->whereNull( $ToolClass::TABLE_NAME . '.products_id' )
            ->orderBy( $ToolClass::TABLE_NAME . '.description', 'asc' )
            ->orderBy( $ToolClass::TABLE_NAME . '.sku', 'asc' )
            ->paginate( $num_per_page );

        foreach ( $response as $tool ) {
            $stock = $tool->stocks->where( 'sites_id', $siteID )->first();
            $row = new \stdClass();
            $row->id = $tool->id;
            $row->description = $tool->description;
            $row->sku = $tool->sku;
            $row->status = $tool->status;
            $row->stock = ( $stock && $stock->id ) ? $stock->stock : 0;

            $tools[] = $row;
        }

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
                'site' => $site ? $site->name : '',
                'records' => $tools
            ]
        );
    }

    public function store( Request $request ) {
        $name = $request->name ? $request->name : '';
        $stock = ( $request->stock && $request->stock > 0 ) ? $request->stock : 0;

        $response = [
            'status' => false,
            'msg' => 'Falta el campo nombre.'
        ];

        if( $name !== '' ) {
            $tool = new Tool();
            $tool->unity_id = 1;
            $tool->sku = $this->generateSKU();
            $tool->slug = $this->generateSlug( Str::slug( $name ) );
            $tool->description = $name;

            if( $tool->save() ) {
                $this->updateStock( $tool->id, $stock );
                $this->logAdmin( 'Registró nueva herramienta - ' . $name . ' ID::' . $tool->id );
                $response['status'] = true;
                $response['msg'] = 'OK.';
            }
        }

        return response()->json( $response );
    }

    public function update( Request $request ) {
        $id = $request->id ? $request->id : '';
        $name = $request->name ? $request->name : '';
        $stock = ( $request->stock && $request->stock > 0 ) ? $request->stock : 0;

        $response = [
            'status' => false,
            'msg' => 'Falta el campo nombre.'
        ];

        $tool = Tool::find( $id );
        $tool->slug = $this->generateSlug( Str::slug( $name ) );
        $tool->description = $name;

        if( $tool->save() ) {
            $this->updateStock( $tool->id, $stock );
            $this->logAdmin( 'Editó herramienta - ' . $name . ' ID::' . $tool->id );
            $response['status'] = true;
            $response['msg'] = 'OK.';
        }

        return response()->json( $response );
    }

    private function generateSlug( $slug, $increment = 0 ) {
        $exist = Tool::where( 'slug', $slug )->exists();
        if( $exist ) {
            $increment++;
            $slug .= '-' . $increment;
            $this->generateSlug( $slug, $increment );
        }

        return $slug;
    }

    private function generateSKU( $increment = 0 ) {
        $sku = 'HERRAMIENTA-';

        $count = Tool::where( 'sku', 'like', $sku . '%' )->count() + 1 + $increment;

        $sku .= $count;

        $exist = Tool::where( 'sku', $sku )->exists();

        if( $exist ) {
            $sku = $this->generateSKU( $increment + 1 );
        }


        return $sku;
    }

    private function updateStock( $presentation, $stockNew ) {
        $site = session( 'siteDefault' );
        $stock = ToolStock::where( 'presentation_id', $presentation )
            ->where( 'sites_id', $site )
            ->first();

        if( !$stock ) {
            $stock = new ToolStock();
            $stock->presentation_id = $presentation;
            $stock->sites_id = $site;
            $stock->stock = $stockNew;
            $stock->save();
            $diference = $stockNew;
            $this->updateToolLog( $stock->id, $diference, $stockNew, true );
        } else {
            $diference = ( -1 * ( $stock->stock - $stockNew ) );
            $this->updateToolLog( $stock->id, $diference, $stockNew );
            $stock->stock = $stockNew;
            $stock->save();
        }
    }

    private function updateToolLog( $stockId, $diference, $totalNew, $isNew = false ) {
        if( $diference !== 0 ) {
            $toolLog = new ToolLog();
            $toolLog->tool_stocks_id = $stockId;
            if ($diference > 0) {
                $comment = 'Se aumento el stock a ' . $totalNew . ' unidades.';
                if ($isNew) {
                    $comment = 'Se agregó herramienta con stock inicial de ' . $diference . ' unidades.';
                }
                $toolLog->input = $diference;
            } else {
                $comment = 'Se redujó el stock a ' . $totalNew . ' unidades.';
                $toolLog->output = abs( $diference );
            }
            $toolLog->total = $totalNew;
            $toolLog->comment = $comment;
            $toolLog->save();
        }
    }

    public function stockDashboard( Request $request ) {
        $idPresentation = $request->id ? $request->id : 0;
        $breadcrumb = [
            [
                'name' => 'Herramientas',
                'url' => route( 'tool.index' )
            ],
            [
                'name' => 'Stock',
                'url' => route( 'tool.stock.index', ['id' => $idPresentation] )
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
            'presentation'  => $idPresentation
        ]);
    }

    public function stock( Request $request ) {
        $idPresentation = $request->id ? $request->id : 0;
        $siteid = session( 'siteDefault' );

        $site = Site::find( $siteid );
        $tool = Tool::find( $idPresentation );

        $dataStock = ToolStock::where( 'presentation_id', $idPresentation )
            ->where( 'sites_id', $siteid )
            ->first();

        $response = [
            'status' => true,
            'msg' => 'OK.',
            'site' => '',
            'tool' => '',
            'sku' => '',
            'stock' => 0,
            'logs' => [],
            'pagination' => [
                'total' => 0,
                'current_page' => 0,
                'per_page' => self::PAGINATE,
                'last_page' => 0,
                'from' => 0,
                'to' => 0
            ]
        ];

        if( $site ) {
            $response['site'] = $site->name;
        }

        if( $tool ) {
            $response['tool'] = $tool->description;
            $response['sku'] = $tool->sku;
        }

        if( $dataStock ) {
            $response['stock'] = $dataStock->stock;

            $dataLogs = ToolLog::where( 'tool_stocks_id', $dataStock->id )
                ->orderBy( 'created_at', 'desc' )
                ->paginate( self::PAGINATE );

            foreach( $dataLogs as $log ) {
                $row = new \stdClass();
                $row->id = $log->id;
                $row->input = $log->input;
                $row->output = ( (-1 ) * $log->output );
                $row->total = $log->total;
                $row->comment = $log->comment;
                $row->createdAt = date( self::DATE_FORMAT_COMP, strtotime( $log->created_at) );

                $response['logs'][] = $row;
            }

            $response['pagination'] = [
                'total' => $dataLogs->total(),
                'current_page' => $dataLogs->currentPage(),
                'per_page' => $dataLogs->perPage(),
                'last_page' => $dataLogs->lastPage(),
                'from' => $dataLogs->firstItem(),
                'to' => $dataLogs->lastItem()
            ];
        }

        return response()->json( $response );
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tool = Tool::findOrFail($request->id);
        $tool->status = 0;
        $tool->save();
        $this->logAdmin("Desactivó herramienta ID::".$tool->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tool = Tool::findOrFail($request->id);
        $tool->status = 1;
        $tool->save();
        $this->logAdmin("Activó herramienta ID::".$tool->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tool = Tool::findOrFail($request->id);
        $tool->status = 2;
        $tool->save();
        $this->logAdmin("Dió de baja la herramienta ID::".$tool->id);
    }
}
