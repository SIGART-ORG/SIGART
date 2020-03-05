<?php

namespace App\Http\Controllers;

use App\Access;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str as Str;
use Image;
use Endroid\SimpleExcel\SimpleExcel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends Controller
{

    protected $_moduleDB = 'products';
    protected $_page = 14;

    public function dashboard(){

        $breadcrumb = [
            [
                'name' => 'Productos',
                'url' => route( 'products.index' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];

        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            "menu" => $this->_page,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $search = $request->search;

        $response = Product::where('products.status', '!=', 2)
                ->where('categories.status', 1)
                ->searchList( $search )
                ->join( 'categories', 'categories.id', '=', 'products.category_id')
                ->orderBy('products.name', 'asc')
                ->select(
                    'products.id',
                    'products.category_id',
                    'products.user_reg',
                    'products.name',
                    'products.description',
                    'products.slug',
                    'products.status',
                    'categories.name as category'
                )
                ->selectRaw(
                    "(select
                        count( presentation.id )
                    from presentation
                    where presentation.status != ?
                    and presentation.products_id = products.id
                    ) presentation", [2]
                )
                ->paginate($num_per_page);

        return [
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem()
            ],
            'records' => $response
        ];
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

        $user_id = Auth::user()->id;

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = Str::slug( $request->name );
        $product->status = 1;
        $product->cod_type_service = 1;
        $product->user_reg = $user_id;
        if( $product->save() ) {
            $this->logAdmin("Registró un nuevo producto( {$request->nombre} ).");
        } else {
            $this->logAdmin("Error al intentar registrar un producto( {$request->nombre} ).", [], 'error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $product = Product::findOrFail($request->id);
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = Str::slug( $request->name );
        if ( $product->save() ) {
            $this->logAdmin("Actualizó los datos del producto: ", $product);
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $product = Product::findOrFail($request->id);
        $product->status = 2;
        $product->save();

        $this->logAdmin("Dió de baja el producto: ".$product->id);
    }

    public function upload(Request $request){
        if($request->file('file')) {
            $marcaAgua = public_path() . '/images/marca_agua.png';

            /*carpeta Products debe de estar con permiso www-data*/
            $path = public_path().'/products/';
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $image = $request->file('file');

            $img = Image::make($image);
            $uniqid = uniqid();
            $tempNameOriginal   = 'image-original-' . $uniqid . '.' . $image->getClientOriginalExtension();
            $tempNameGalery     = 'image-galery-' . $uniqid . '.' . $image->getClientOriginalExtension();
            $tempNameAdmin      = 'image-admin-' . $uniqid . '.' . $image->getClientOriginalExtension();
            $tempNamefacebook   = 'image-facebbok-' . $uniqid . '.' . $image->getClientOriginalExtension();

            $img->save($path . $tempNameOriginal, 100);

            $watermark = Image::make( $marcaAgua );
            $watermark->opacity(30);
            //$img->insert( $watermark, 'center', 10, 10 );

            $img->resize( 350, 230 );
            $img->save( $path . $tempNameAdmin, 100 );

            $img->resize( 255, 167 );
            $img->save( $path . $tempNameGalery, 100 );

            $img->resize( 1200, 628 );
            $img->save( $path . $tempNamefacebook, 100 );

            $default = 0;
            $existImages = \App\ProductsImages::where('products_id', $request->id)
                ->where('image_default', 1)->doesntExist();
            if($existImages){
                $default = 1;
            }

            $productsImage = new \App\ProductsImages();
            $productsImage->products_id = $request->id;
            $productsImage->image_original = $tempNameOriginal;
            $productsImage->image_galery = $tempNameGalery;
            $productsImage->image_admin = $tempNameAdmin;
            $productsImage->image_facebook = $tempNamefacebook;
            $productsImage->image_default = $default;
            $productsImage->save();


            return Response()->json([
                'status' => 200
            ]);
        }else {
            return Response()->json(array('test'=>false));
        }
    }

    public function presentation( Request $request ){
        if(!$request->ajax()) return redirect('/');
        $this->controPresentation($request->id, $request->presentation);
    }

    public function controPresentation( $product, $arrPresentation ){
        foreach ( $arrPresentation as $pres ){
            if( trim( $pres['description'] ) != "" and trim( $pres['equivalence'] ) != ""){
                $permit = 0;
                $status = 1;

                if( $pres['idTable'] > 0 ){
                    $permit = 2;
                    if( $pres['delete'] == 1 ) {
                        $status = 2;
                    }
                }elseif ( $pres['delete'] == 0 ){
                    $permit = 1;
                    $status = 1;
                }

                if( $permit > 0){
                    if( $permit > 1){
                        $presentation = \App\Presentation::findOrFail( $pres['idTable'] );
                    }else{
                        $presentation = new \App\Presentation();
                    }
                    $presentation->products_id = $product;
                    $presentation->sku = 'prueba-' . uniqid();
                    $presentation->unity_id = $pres['unity'];
                    $presentation->description = $pres['description'];
                    $presentation->equivalence = $pres['equivalence'];
                    $presentation->pricetag_purchase = $pres['pricetag'];
                    $presentation->slug = Str::slug( $pres['description'] );
                    $presentation->status = $status;
                    $presentation->save();
                }
            }
        }
    }

    public function downloadExcel() {
        $objPHPExcel    = new Spreadsheet();
        $filename       = 'Productos.xlsx';
        $title          = 'Listado de Productos';

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle( $title );
        $objPHPExcel->getActiveSheet()->setCellValue( 'A1', $title );
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical( Alignment::VERTICAL_CENTER );

        $this->generateHeaderExcel( $objPHPExcel );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');

        ob_start();
        $objWriter->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        return [
            'status' => true,
            'file' =>  "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        ];

    }

    public function generateHeaderExcel( Spreadsheet $excel ) {
        $headers = $this->setHeaders();
        if (count($headers)) {
            foreach ($headers as $key => $value) {
                $excel->getActiveSheet()->setCellValue($key, $value);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setSize(11);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }
    }

    private function setHeaders()
    {
        $headers = array(
            'A2' => 'SKU',
            'B2' => 'Categoría',
            'C2' => 'Producto',
            'D2' => 'Presentación',
            'E2' => 'Unid. medida',
            'F2' => 'Prec. Ref.',
            'G2' => 'Cantidad'
        );

        return $headers;
    }

    public function detail( Request $request ) {
        $id = $request->id;

        $response = [
            'status' => false,
            'data' => new \stdClass()
        ];

        $product = Product::find( $id );

        if( $product ) {

            $response['status'] = true;

            $presentations = [];
            $dataPresentations = $product->presentations->where( 'status', '!=', 2 );

            foreach ( $dataPresentations as $presentation ) {
                $row = new \stdClass();
                $row->id = $presentation->id;
                $row->sku = $presentation->sku;
                $row->slug = $presentation->slug;
                $row->name = $presentation->description;
                $row->status = $presentation->status;
                $row->url = $this->getUrlWeb( 'product/' . $product->slug . '/' . $presentation->slug );

                $presentations[] = $row;
            }

            $response['data']->id = $product->id;
            $response['data']->slug = $product->slug;
            $response['data']->url = $this->getUrlWeb( 'product/' . $product->slug );
            $response['data']->name = $product->name;
            $response['data']->category = $product->category->name;
            $response['data']->description = $product->description;
            $response['data']->typeService = $product->cod_type_service === 1 ? 'Servicio de pintura' : 'Servicio de carpinteria';
            $response['data']->status = $product->status;
            $response['data']->image = $this->imageProduct( $product );
            $response['data']->count = count( $presentations );
            $response['data']->presentations = $presentations;
        }

        return response()->json( $response, 200 );
    }

    private function imageProduct( Product $product ) {
        $images = $product->productImages->where( 'status', 1 )->first();
        $image = asset( 'images/product-180x180.png' );
        if( $images ) {
            $image = $images->image_original ? asset( 'uploads/products/' . $product->id . '/' . $images->image_original ) : $image;
        }
        return $image;
    }
}
