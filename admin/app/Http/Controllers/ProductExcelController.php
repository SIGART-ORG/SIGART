<?php

namespace App\Http\Controllers;

use App\Category;
use App\Presentation;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Services\Slug;
use App\Unity;
use Illuminate\Http\Request;
use App\Http\Requests\uploadExcel;
use App\Imports\ImportExcel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductExcelController extends Controller
{
    private $unity      = [];
    private $category   = [];

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if( method_exists( $this, $method = ( 'get' . ucfirst( $name ) ) ) ) {
            $this->$method();
        }else{
            throw new \Exception( 'Cant\'t get property ' . $name );
        }
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if( method_exists( $this, $method = ( 'set' . ucfirst( $name ) ) ) ) {
            return $this->$method( $value );
        }else{
            throw new \Exception( 'Cant\'t ser property '. $name );
        }
    }

    protected function getUnity() {
        return $this->unity;
    }

    protected function setUnity( $data ) {
        $this->unity = $data;
    }

    protected function getCategory() {
        return $this->category;
    }

    protected function setCategory( $value ){
        $this->category = $value;
    }

    public function uploadExcel( uploadExcel $request ){
        if(!$request->ajax()) return redirect('/');

        $directory = 'temps';
        $response = [
            'status'    => false,
            'errors'    => [],
            'info'      => [],
            'saved'     => 0
        ];

        $path = $request->file( 'file-upload' )->store( $directory );

        $collections = Excel::toCollection( new ImportExcel(), $path );
        if( $collections ) {

            $allDataUnity       = $this->_allUnity();
            $allDataCategory    = $this->_allCategory();

            $this->setUnity( $allDataUnity );
            $this->setCategory( $allDataCategory );

            foreach( $collections as $colection ){
                foreach ( $colection as $idx => $products ){
                    if( $idx > 1 ){
                        $sku            = $products[0];
                        $category       = $products[1];
                        $product        = $products[2];
                        $presentation   = $products[3];
                        $unity          = $products[4];
                        $priceTag       = $products[5];
                        $quantiy        = $products[6];

                        if( $this->_existSku( 'sku', $sku ) ) {

                            $dataCategory = $this->_existCategory( $category );
                            if( $dataCategory['status'] == 'new' ){
                                $response['info'][] = [
                                    'msg' => 'Se registró la siguiente Categoría: ' . $dataCategory['name'] . '.'
                                ];
                            }

                            $whereProduct = [];
                            $whereProduct[] = [ 'col' => 'name', 'operator' => '=', 'value' => $product ];
                            $whereProduct[] = [ 'col' => 'category_id', 'operator' => '=', 'value' => $dataCategory['id'] ];
                            $productExist = $this->_existProduct( $whereProduct );

                            if( $productExist['id'] > 0 ){
                                if( $productExist['status'] == 'new' ){
                                    $response['info'][] = [
                                        'msg' => 'Se registró el siguiente Producto: ' . $productExist['name'] . '.'
                                    ];
                                }
                                $dataUnity = $this->_existUnity( $unity );
                                if( $dataUnity['status'] == 'new' ) {
                                    $response['info'][] = [
                                        'msg' => 'Se registró la siguiente unidad de medida: ' . $dataUnity['name'] . '.'
                                    ];
                                }

                                $idUnity    = $dataUnity['id'];
                                $idProduct  = $productExist['id'];

                                $wherePresentation  = [];
                                $wherePresentation[] = [ 'col' => 'description', 'operator' => '=', 'value' => $presentation ];
                                $wherePresentation[] = [ 'col' => 'products_id', 'operator' => '=', 'value' => $idProduct ];
                                $wherePresentation[] = [ 'col' => 'unity_id', 'operator' => '=', 'value' => $idUnity ];

                                $addPresentation    = [];
                                $addPresentation[]  = [ 'col' => 'stock', 'value' => $quantiy ];
                                $addPresentation[]  = [ 'col' => 'pricetag_purchase', 'value' => $priceTag ];
                                $addPresentation[]  = [ 'col' => 'sku', 'value' => $sku ];

                                $savePresentation   = $this->_existPresentacion( $wherePresentation, $addPresentation );
                                switch ( $savePresentation['status'] ) {
                                    case 'new':
                                        $response['saved']++;
                                        break;
                                    case 'registered':
                                        $response['errors'][] = [
                                            'row' => $idx + 1,
                                            'col' => $colection[$idx][3],
                                            'msg' => 'El siguiente producto ya se encuentra resgistrado: ' . $product . '.'
                                        ];
                                        break;
                                    case 'undefined':
                                        $response['errors'][] = [
                                            'row' => $idx + 1,
                                            'col' => $colection[$idx][3],
                                            'msg' => 'No se pudo registrar el producto ' . $product . '.'
                                        ];
                                        break;
                                }

                            }else{
                                $response['errors'][] = [
                                    'row' => $idx + 1,
                                    'col' => $colection[$idx][2],
                                    'msg' => 'No se pudo crear el producto ' . $product . '.'
                                ];
                            }
                        }else{
                            $response['errors'][] = [
                                'row'   => $idx + 1,
                                'col'   => $colection[1][0],
                                'msg'   => 'Código interno ' . $sku . ' ya existe',
                            ];
                        }
                    }
                }
            }
        }

        Storage::deleteDirectory( $directory );

        if( $response['saved'] > 0 ){
            $response['status'] = true;
        }

        return $response;
    }

    public function _existCategory( $category ){
        $key = array_search( $category, array_column( $this->category, 'name') );

        if( $key >= 0 && ! empty( $this->category[$key]['id'] ) ) {
            $response = [
                'id' => $this->category[$key]['id'],
                'name' => $this->category[$key]['name'],
                'status' => 'registered'
            ];
        }else{
            $model = new Category();
            $model->name = $category;
            $model->save();

            $response = [
                'id'        => $model->id,
                'name'      => $model->name,
                'status'    => 'new'
            ];

            $allCategory = $this->_allCategory();
            $this->setCategory( $allCategory );
        }

        return $response;
    }

    public function _existUnity( $unity ) {
        $key = array_search( $unity, array_column( $this->unity, 'name' ) );

        if( $key >= 0 && ! empty( $this->unity[$key]['id'] ) ) {
            $response = [
                'id'        => $this->unity[$key]['id'],
                'name'      => $this->unity[$key]['name'],
                'status'    => 'registered'
            ];
        } else {
            $model              = new Unity();
            $model->name        = $unity;
            $model->equivalence = 1;
            $model->root        = 0;
            $model->save();

            $response = [
                'id'        => $model->id,
                'name'      => $model->name,
                'status'    => 'new'
            ];

            $allUnity = $this->_allUnity();
            $this->setUnity( $allUnity );
        }

        return $response;
    }

    public function _existProduct( $data ){

        $response = [
            'id' => 0,
            'name' => '',
            'category' => 0,
            'status' => 'undefined'
        ];

        if( ! empty( $data ) && is_array( $data ) && count( $data ) > 0 ) {
            $exist = Product::where('status', '!=', 2)
                ->whereProduct($data)
                ->first();

            if ( $exist == null ) {

                $product = new Product();
                foreach ($data as $pr) {
                    $col = $pr['col'];
                    $product->$col = $pr['value'];
                    if( $pr['col'] == 'name' ){
                        $product->slug = Slug::createSlug('product', $pr['value'] );
                    }
                }
                $product->description   = '';
                $product->user_reg      = Auth::user()->id;
                $product->cod_type_service = 1;
                $product->save();

                $response = [
                    'id'        => $product->id,
                    'name'      => $product->name,
                    'category'  => $product->category_id,
                    'status'    => 'new'
                ];
            } else {
                $response = [
                    'id'        => $exist->id,
                    'name'      => $exist->name,
                    'category'  => $exist->category_id,
                    'status'    => 'registered'
                ];
            }
        }

        return $response;
    }

    public function _existSku( $col, $value ){
        $exist = Presentation::where( $col, $value )
            ->exists();

        if( ! $exist ){
            return true;
        }else{
            return false;
        }
    }

    public function _existPresentacion( $data, $addData = [] ){
        $response = [
            'id'        => 0,
            'name'      => '',
            'product'   => 0,
            'unity'     => 0,
            'status'    => 'undefined'
        ];

        if( ! empty( $data ) && is_array( $data ) && count( $data ) ) {
            $exist = Presentation::where('status', '!=', 2)
                ->wherePresentation( $data )
                ->first();

            if( $exist == NULL ) {
                $presentation = new Presentation();
                foreach ( $data as  $row ) {
                    $col                = $row['col'];
                    $presentation->$col = $row['value'];
                    if( $col == 'description') {
                        $presentation->slug = Slug::createSlug('presentation', $row['value'] );
                    }
                }
                foreach ( $addData as $addRow ) {
                    $col                = $addRow['col'];
                    $presentation->$col = $addRow['value'];
                }
                $presentation->stock = 0;
                $presentation->pricetag_purchase = 0;
                $presentation->save();

                $response = [
                    'id'        => $presentation->id,
                    'name'      => $presentation->description,
                    'product'   => $presentation->products_id,
                    'unity'     => $presentation->unity_id,
                    'status'    => 'new'
                ];

            }else{
                $response = [
                    'id'        => $exist->id,
                    'name'      => $exist->description,
                    'product'   => $exist->products_id,
                    'unity'     => $exist->unity_id,
                    'status'    => 'registered'
                ];
            }
        }

        return $response;
    }

    public function _allCategory(){
        $response = [];
        $data = Category::where( 'status', 1 )
            ->select( 'id', 'name' )
            ->get();

        foreach ( $data as $row ) {
            $response[] = [
                'id' => $row->id,
                'name'  => $row->name
            ];
        }

        return $response;
    }

    public function _allUnity(){
        $response = [];
        $data = Unity::where( 'status', 1 )
            ->select( 'id', 'name' )
            ->get();

        foreach ( $data as $row ){
            $response[] = [
                'id' => $row->id,
                'name' => $row->name
            ];
        }

        return $response;
    }

    public function _saveUnity( $name ){
        $unity = new Unity();
        $unity->name = $name;
        $unity->save();
    }

}
