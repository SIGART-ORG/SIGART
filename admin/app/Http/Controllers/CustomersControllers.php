<?php

namespace App\Http\Controllers;

use App\Access;
use App\Helpers\HelperSigart;
use Illuminate\Http\Request;
use App\Customer;
use PDF;

class CustomersControllers extends Controller
{
    protected $_moduleDB = 'customers';
    protected $_page = 15;

    public function dashboard(){
        $breadcrumb = [
            [
                'name' => 'Clientes',
                'url' => route( 'customers.index' )
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

    public function configCustomer(Request $request){

        if(!$request->ajax()) return redirect('/');

        $typePersons = HelperSigart::getTypePerson();
        $typeTelephone = HelperSigart::getTypeTelephone();

        return [
            'typePerson' => $typePersons,
            'typeTelephone' => $typeTelephone
        ];


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 21;
        $search = $request->search;

        $response = Customer::where('status', '!=', 2)
            ->search($search)
            ->orderBy('name', 'asc')
            ->select(
                'id',
                'name',
                'lastname',
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
        $customers = new Customer();
        $customers->name = $request->name;
        $customers->type_person = $request->typePerson;
        $customers->document = $request->document;
        $customers->type_document = $request->typeDocument;
        $customers->type_person = $request->typePerson;
        $customers->email = $request->email;
        $customers->address = $request->address;
        $customers->district_id = $request->districtId;
        if( $request->typePerson == 2 ){
            $customers->business_name = $request->businessName;
            $customers->legal_representative = $request->legalRepresentative;
            $customers->type_document_lp = $request->typeDocumentLp;
            $customers->document_lp = $request->documentLp;
        }else{
            $customers->lastname = $request->lastname;
        }
        if($customers->save()){
            $customerIDNew = $customers->id;
            $this->registerTelephone($customerIDNew, $request->telephones, $request->telfPredetermined );
            $this->logAdmin( 'Registro nuevo cliente ID::' . $customerIDNew );
        }
    }

    public function registerTelephone( $customer, $arrTelf, $predeterminedRow ) {
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
                    $telephone->customers_id = $customer;
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
        $customers = Customer::findOrFail($request->id);
        $customers->name = $request->name;
        $customers->type_person = $request->typePerson;
        $customers->document = $request->document;
        $customers->type_document = $request->typeDocument;
        $customers->type_person = $request->typePerson;
        $customers->email = $request->email;
        $customers->address = $request->address;
        $customers->district_id = $request->districtId;
        if( $request->typePerson == 2 ){
            $customers->business_name = $request->businessName;
            $customers->legal_representative = $request->legalRepresentative;
            $customers->type_document_lp = $request->typeDocumentLp;
            $customers->document_lp = $request->documentLp;
        }
        if($customers->save()){
            $customerIDNew = $customers->id;
            $this->registerTelephone($customerIDNew, $request->telephones, $request->telfPredetermined );
            $this->logAdmin( 'Actualizó los datos del cliente' . $customers );
        }
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $customer = Customer::findOrFail($request->id);
        $customer->status = 0;
        $customer->save();
        $this->logAdmin("Desactivó cliente:".$customer->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $customer = Customer::findOrFail($request->id);
        $customer->status = 1;
        $customer->save();
        $this->logAdmin("Activó el cliente:".$customer->id);
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
        $customer = Customer::findOrFail($request->id);
        $customer->status = 2;
        $customer->save();
        $this->logAdmin("Eliminó el cliente:".$customer->id);
    }

    public function getDataCustomer( Request $request ){

        if(!$request->ajax()) return redirect('/');

        $response = [];

        if( $request->id and $request->id > 0 ){
            $telephone = \App\Telephone::where( 'customers_id', $request->id )
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

        $customer = Customer::findOrFail( $request->id );
        $district = HelperSigart::completeNameUbigeo( $customer->district_id );
        $ubigeo = HelperSigart::ubigeo( $district, 'inline' );

        $arrTypeDocument = \App\TypeDocument::where('status', 1)
            ->select('id', 'name')
            ->get();

        $typeDocument = [];
        foreach( $arrTypeDocument as $td ) {
            $typeDocument[$td->id] = $td->name;
        }

        $pdf = PDF::loadView('mintos.PDF.pdf-customer', [
            'customer' => $customer,
            'ubigeo' => $ubigeo,
            'typeDocument' => $typeDocument
        ]);

        return $pdf->download('itsolutionstuff.pdf');
    }

    public function examplePDF() {
        return view('mintos.PDF.pdf-customer');
    }
}
