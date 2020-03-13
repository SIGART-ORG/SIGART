<?php

namespace App\Http\Controllers;

use App\Access;
use \App\Presentation;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PresentationController extends Controller
{
    protected $_moduleDB = 'presentation';
    protected $_page = 14;

    public function dashboard( Request $request ){
        $breadcrumb = [
            [
                'name' => 'Productos',
                'url' => route( 'products.index' )
            ],
            [
                'name' => 'Presentación',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            "menu"          => $this->_page,
            'sidebar'       => $permiso,
            "moduleDB"      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
            'product'       => $request->id
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $num_per_page = 20;
        $response = Presentation::where('presentation.status', '!=', 2)
            ->where('products.status', '!=', 2 )
            ->where('unity.status', '!=', 2 )
            ->where('products_id', $request->id )
            ->join( 'products', 'products.id', 'presentation.products_id')
            ->join( 'unity', 'unity.id', 'presentation.unity_id')
            ->join( 'categories', 'categories.id', '=', 'products.category_id' )
            ->select(
                'presentation.id',
                'presentation.description',
                'presentation.products_id',
                'presentation.sku',
                'presentation.unity_id',
                'presentation.equivalence',
                'categories.name as category',
                'unity.name as unity_name'
            )
            ->selectRaw(
                'concat( categories.name, \' \', products.name, \' \', presentation.description ) as name'
            )
            ->orderBy('id', 'asc')
            ->paginate($num_per_page);

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

    public function select( Request $request ){
        $presentation = Presentation::where('status', '=', 1)
            ->where('products_id', $request->id )
            ->select('id', 'products_id', 'unity_id', 'description', 'equivalence')
            ->orderBy('id', 'asc')
            ->get();

        $newArray = [];
        foreach( $presentation as $idx => $pres ){
            $newArray[] = [
                'id' => $idx,
                'description' => $pres->description,
                'unity' => $pres->unity_id,
                'equivalence' => $pres->equivalence,
                'delete' => 0,
                'idTable'=> $pres->id
            ];
        }

        return response()->json([
            'presentation' => $newArray
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $product = Product::find( $request->product );
        $sku = $this->generateSKU( $product );

        $presentation = new Presentation();
        $presentation->products_id = $request->product;
        $presentation->unity_id = $request->unity;
        $presentation->description = $request->name;
        $presentation->slug = $this->generateSlug( Str::slug( $request->name ) );
        $presentation->sku = $sku;
        $presentation->status = 1;
        if( $presentation->save() ) {
            $this->logAdmin("Registró nueva presentación( {$request->nombre} ).");
        } else {
            $this->logAdmin("Error al intentar registrar una presentación( {$request->nombre} ).", [], 'error');
        }
    }

    private function generateSKU( $product, $increment = 0 ) {
        $sku = Str::substr( Str::upper( $product->category->name ), 0, 3 ) . '-';
        $sku .= Str::substr( Str::upper( $product->name ), 0, 3 ) . '-';

        $count = Presentation::where( 'sku', 'like', '%' . $sku . '%' )->count() + 1 + $increment;

        $sku .= $count;

        $exist = Presentation::where( 'sku', $sku )->exists();

        if( $exist ) {
            $sku = $this->generateSKU( $product, ( $increment+ 1 ) );
        }


        return $sku;
    }

    private function generateSlug( $slug, $increment = 0 ) {
        $exist = Presentation::where( 'slug', $slug )->exists();
        if( $exist ) {
            $increment++;
            $slug .= '-' . $increment;
            $this->generateSlug( $slug, $increment );
        }

        return $slug;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request )
    {
        if(!$request->ajax()) return redirect('/');

        $presentation = Presentation::find( $request->id );
        $presentation->unity_id = $request->unity;
        $presentation->description = $request->name;
        $presentation->status = 1;
        if( $presentation->save() ) {
            $this->logAdmin("Editó nueva presentación( {$request->nombre} ).");
        } else {
            $this->logAdmin("Error al intentar editar una presentación( {$request->nombre} ).", [], 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        $presentation = Presentation::findOrFail( $request->id );
        $presentation->status = 2;
        $presentation->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function search( Request $request ) {

        $response = [
            'status'    => false,
            'msg'       => '',
            'data'      => []
        ];

        $search = $request->search;
        $type = $request->type ? $request->type : '';
        $site = session( 'siteDefault' );

        if( ! empty( $search ) &&  strlen( $search ) >= 4 ) {

            $data = Presentation::where( 'status', '!=', 2 )
                ->with( 'unity:id,name' )
                ->with( 'product:id,name' )
                ->with( 'product.category:id,name')
                ->where( function ( $sq ) use( $search ) {
                    $sq->where( 'presentation.sku', 'like', '%' . $search . '%' )
                        ->orWhere( 'presentation.description', 'like', '%' . $search . '%' )
                        ->orWhereHas( 'product', function( $sq2 ) use( $search ) {
                            $sq2->where( 'name', 'like', '%' . $search . '%' )
                                ->where( 'status' , '!=', '2');
                        })
                        ->orWhereHas( 'unity', function( $sq3 ) use( $search ) {
                            $sq3->where( 'name', 'like', '%' . $search . '%')
                                ->where( 'status' , '!=', '2');
                        })
                        ->orWhereHas( 'product.category', function( $sq4 ) use( $search ) {
                            $sq4->where( 'name', 'like', '%' . $search . '%')
                                ->where( 'status' , '!=', '2');
                        });
                })
                ->get();

            foreach ( $data as $idx => $item ) {
                $row            = new \stdClass();
                $row->id        = $item->id;
                $row->sku       = $item->sku;
                $row->slug      = $item->slug;
                $row->name      = $item->description;
                $row->unity     = $item->unity->name;
                $row->product   = $item->product->name;
                $row->category  = $item->product->category->name;
                $row->stock     = 0;
                $row->priceBuy  = 0;

                if( $type === 'buy' ) {
                    $stock = $item->stocks->where( 'sites_id', $site )->first();
                    $row->stock = !empty( $stock->stock ) ? $stock->stock : 0;
                    $row->priceBuy  = !empty( $stock->price_buy ) ? $stock->price_buy : 0;;
                }

                $response['data'][] = $row;
            }

            if( count( $response['data'] ) > 0 ) {
                $response['status'] = true;
                $response['msg'] = 'OK';
            } else {
                $response['msg'] = 'No se encontraron coincidencias.';
            }

        } else {
            $response['msg'] = 'Ingrese parametros de busqueda';
        }

        return response()->json( $response );
    }

    public function detail( Request $request ) {
        $id = $request->id;

        $response = [
            'status' => false,
            'data' => new \stdClass()
        ];

        $presentation = Presentation::find( $id );

        if( $presentation ) {

            $product = $presentation->product;
            $dataStocks = $presentation->stocks;
            $stocks = [];
            foreach ($dataStocks as $dataStock) {
                $row = new \stdClass();
                $row->id = $dataStock->id;
                $row->site = $dataStock->site->name;
                $row->stock = $dataStock->stock;
                $row->price = $dataStock->price;
                $row->priceBuy = $dataStock->price_buy;

                $stocks[] = $row;
            }

            $response['status'] = true;
            $response['data']->id = $presentation->id;
            $response['data']->sku = $presentation->sku;
            $response['data']->product = $product->name;
            $response['data']->category = $product->category->name;
//            $response['data']->slug = $presentation->slug;
            $response['data']->name = $presentation->description;
            $response['data']->status = $presentation->status;
            $response['data']->image = asset( 'images/product-180x180.png' );;
            $response['data']->url = $this->getUrlWeb( 'product/' . $product->slug . '/' . $presentation->slug );
            $response['data']->unity = $presentation->unity->name;
            $response['data']->stocks = $stocks;
        }

        return response()->json( $response, 200 );
    }
}
