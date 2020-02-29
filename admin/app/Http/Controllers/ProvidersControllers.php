<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\Provider;
use \App\Helpers\HelperSigart;
use PDF;

class ProvidersControllers extends Controller
{
    protected $_moduleDB = 'providers';
    protected $_page = 16;
    public function configProvider(Request $request){

        if(!$request->ajax()) return redirect('/');

        $typePersons = HelperSigart::getTypePerson();
        $typeTelephone = HelperSigart::getTypeTelephone();

        return [
            'typePerson' => $typePersons,
            'typeTelephone' => $typeTelephone
        ];


    }

    public function dashboard()
    {

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 21;
        $search = $request->search;

        $response = Provider::where('status', '!=', 2)
            ->search($search)
            ->orderBy('name', 'asc')
            ->select(
                'id',
                'name',
                'business_name',
                'type_person',
                'document',
                'type_document',
                'legal_representative',
                'document_lp',
                'type_document_lp',
                'email',
                'address',
                'district_id',
                'status'
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
        $providers = new Provider();
        $providers->name = $request->name;
        $providers->type_person = $request->typePerson;
        $providers->document = $request->document;
        $providers->type_document = $request->typeDocument;
        $providers->type_person = $request->typePerson;
        $providers->email = $request->email;
        $providers->address = $request->address;
        $providers->district_id = $request->districtId;
        /*
         * @param $request->typePerson
         * @val 1: persona natural
         * @val 2: persona juridica
         */
        if( $request->typePerson == 2 ){
            $providers->business_name = $request->businessName;
            $providers->legal_representative = $request->legalRepresentative;
            $providers->type_document_lp = $request->typeDocumentLp;
            $providers->document_lp = $request->documentLp;
        }
        if($providers->save()){
            $providerIDNew = $providers->id;
            $this->registerTelephone($providerIDNew, $request->telephones, $request->telfPredetermined );
            $this->logAdmin( 'Registro nuevo proveedor ID::' . $providerIDNew );
        }
    }

    public function registerTelephone( $provider, $arrTelf, $predeterminedRow ) {
        foreach ( $arrTelf as $tel ){

            if( trim( $tel['number'] ) != "" and trim( $tel['typeTelf'] ) != "" ){

                $permit = 0;
                $status = 1;

                $predetermined = 0;
                if ($predeterminedRow == $tel['id']) {
                    $predetermined = 1;
                }

                if( $tel['idTable'] > 0 ){
                    $permit = 2;
                    if( $tel['delete'] == 1 ) {
                        $status = 2;
                        $predetermined = 0;
                    }
                } elseif( $tel['delete'] == 0 ) {
                    $permit = 1;
                    $status = 1;
                    $predetermined = 0;
                }

                if($permit > 0) {

                    if( $permit > 1 ){
                        $telephone = \App\Telephone::findOrFail( $tel['idTable'] );
                    } else {
                        $telephone = new \App\Telephone();
                    }

                    $telephone->number = $tel['number'];
                    $telephone->type_telephone_id = $tel['typeTelf'];
                    $telephone->providers_id = $provider;
                    $telephone->predetermined = $predetermined;
                    $telephone->status = $status;
                    $telephone->save();
                }
            }
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $providers = Provider::findOrFail($request->id);
        $providers->name = $request->name;
        $providers->type_person = $request->typePerson;
        $providers->document = $request->document;
        $providers->type_document = $request->typeDocument;
        $providers->type_person = $request->typePerson;
        $providers->email = $request->email;
        $providers->address = $request->address;
        $providers->district_id = $request->districtId;
        if( $request->typePerson == 2 ){
            $providers->business_name = $request->businessName;
            $providers->legal_representative = $request->legalRepresentative;
            $providers->type_document_lp = $request->typeDocumentLp;
            $providers->document_lp = $request->documentLp;
        }
        if($providers->save()){
            $providerIDNew = $providers->id;
            $this->registerTelephone($providerIDNew, $request->telephones, $request->telfPredetermined );
            $this->logAdmin( 'Actualizó los datos del proveedor' . $providers );
        }
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $provider = Provider::findOrFail($request->id);
        $provider->status = 0;
        $provider->save();
        $this->logAdmin("Desactivó proveedor:".$provider->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $provider = Provider::findOrFail($request->id);
        $provider->status = 1;
        $provider->save();
        $this->logAdmin("Activó el proveedor:".$provider->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $provider = Provider::findOrFail($request->id);
        $provider->status = 2;
        $provider->save();
        $this->logAdmin("Eliminó el proveedor:".$provider->id);
    }

    public function getDataProvider( Request $request ){

        if(!$request->ajax()) return redirect('/');

        $response = [];

        if( $request->id and $request->id > 0 ){
            $telephone = \App\Telephone::where( 'providers_id', $request->id )
                ->where( 'status', 1)
                ->select(
                    'id',
                    'number',
                    'type_telephone_id',
                    'predetermined'
                )
                ->get();

            $response['telephone'] = [];
            $response['predetermined'] = 0;
            foreach( $telephone as $indexTel => $tel ) {

                if($tel->predetermined == 1){
                    $response['predetermined'] = $indexTel;
                }

                $response['telephone'][] = [
                    'id' => $indexTel,
                    'typeTelf' => $tel->type_telephone_id,
                    'number' => $tel->number,
                    'idTable' => $tel->id,
                    'delete' => 0
                ];
            }
        }

        if( $request->district and $request->district != '' ){
            $district = HelperSigart::completeNameUbigeo( $request->district );
            $response['ubigeo'] = HelperSigart::ubigeo( $district );
        }

        return $response;
    }

    public function generatePDF(Request $request){

        $provider = Provider::findOrFail( $request->id );
        $district = HelperSigart::completeNameUbigeo( $provider->district_id );
        $ubigeo = HelperSigart::ubigeo( $district, 'inline' );

        $arrTypeDocument = \App\TypeDocument::where('status', 1)
            ->select('id', 'name')
            ->get();

        $typeDocument = [];
        foreach( $arrTypeDocument as $td ) {
            $typeDocument[$td->id] = $td->name;
        }

        $pdf = PDF::loadView('PDF.myPDF', [
            'provider' => $provider,
            'ubigeo' => $ubigeo,
            'typeDocument' => $typeDocument
        ]);

        return $pdf->download('itsolutionstuff.pdf');
    }

    public function select( Request $request ){
        if(!$request->ajax()) return redirect('/');
        $response = Provider::where('status', '=', 1)
            ->select('id', 'name')
            ->orderBy('name', 'asc')->get();
        return response()->json(['response' => $response], 200);
    }

    public function search( Request $request ) {

        $response = [
            'status'    => false,
            'msg'       => '',
            'data'      => []
        ];

        $search = $request->search;

        if( ! empty( $search ) &&  strlen( $search ) >= 4 ) {

            $data = Provider::where('providers.status', '=', 1)
                ->join('type_documents', 'type_documents.id', 'providers.type_document')
                ->search($search)
                ->select(
                    'providers.id',
                    'providers.name',
                    'providers.business_name',
                    'providers.document',
                    'type_documents.name as typeDocument'
                )
                ->orderBy('name', 'asc')
                ->get();

            foreach ($data as $item) {

                $name = $item->name;

                $row = new \stdClass();
                $row->id = $item->id;
                $row->name = $name;
                $row->document = $item->document;
                $row->typeDocument = $item->typeDocument;

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

}
