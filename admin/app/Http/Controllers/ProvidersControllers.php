<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\Provider;
use \App\Helpers\HelperSigart;

class ProvidersControllers extends Controller
{
    protected $_moduleDB = 'providers';

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
        $permiso = Access::sideBar();
        return view('modules/pages', [
            "menu" => 15,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
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
                if( $tel['idTable'] > 0 ){

                    $telephone = \App\Telephone::findOrFail( $tel['idTable'] );

                } else {

                    $telephone = new \App\Telephone();

                }

                $predetermined = 0;
                if( $predeterminedRow == $tel['id'] ){
                    $predetermined = 1;
                }

                $telephone->number = $tel['number'];
                $telephone->type_telephone_id = $tel['typeTelf'];
                $telephone->providers_id = $provider;
                $telephone->predetermined = $predetermined;
                $telephone->save();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
