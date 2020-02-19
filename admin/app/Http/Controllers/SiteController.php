<?php

namespace App\Http\Controllers;

use App\Models\SiteVourcher;
use App\Models\TypeVoucher;
use Illuminate\Http\Request;
use App\Site;
use App\Access;

class SiteController extends Controller
{
    protected $_moduleDB = 'sites';
    protected $_page = 7;
    protected function _validate() {
        $this->validate( request(), [
            'nombre'      => 'required',
        ] );
    }

    public function dashboard(){
        $breadcrumb = [
            [
                'name' => 'Sedes',
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
//        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;
        $buscar = $request->buscar;
        $criterio_bd = "name";
        $sites =  [];

        if($buscar == '') {
            $sitesData = Site::SelectList()
                ->FilterNotStatus(2)
                ->OrderBySite(['name', 'asc'])
                ->paginate($num_per_page);
        }else{
            $sitesData = Site::SelectList()
                ->FilterNotStatus(2)
                ->SearchSite([$criterio_bd, $buscar])
                ->OrderBySite(['name', 'asc'])
                ->paginate($num_per_page);
        }

        foreach ( $sitesData as $site ) {
            $row = new \stdClass();
            $row->id = $site->id;
            $row->name = $site->name;
            $row->address = $site->address;
            $row->status = $site->status;

            $siteVouchers = $site->siteVouchers->where( 'status', 1 );
            $row->siteVouchers = [];

            foreach ( $siteVouchers as $siteVoucher ) {
                $sv = new \stdClass();
                $sv->id = $siteVoucher->id;
                $sv->typeVoucher = $siteVoucher->type_vouchers_id;
                $sv->name = $siteVoucher->typeVoucher->name;
                $sv->serie = $siteVoucher->serie;
                $sv->number = $siteVoucher->number;

                $row->siteVouchers[] = $sv;
            }

            $sites[] = $row;
        }

        $typeVoucherData = TypeVoucher::where( 'status', 1 )
            ->orderBy( 'name', 'asc' )
            ->get();

        $typeVouchers = [];

        foreach ( $typeVoucherData as $typeVoucherDatum ) {
            $tvd = new \stdClass();
            $tvd->id = 0;
            $tvd->typeVoucher = $typeVoucherDatum->id;
            $tvd->name = $typeVoucherDatum->name;
            $tvd->serie = '';
            $tvd->number = 1;

            $typeVouchers[] = $tvd;
        }

        $response = [
            'pagination' => [
                'total' => $sitesData->total(),
                'current_page' => $sitesData->currentPage(),
                'per_page' => $sitesData->perPage(),
                'last_page' => $sitesData->lastPage(),
                'from' => $sitesData->firstItem(),
                'to' => $sitesData->lastItem()
            ],
            'records' => $sites,
            'type' => $typeVouchers
        ];

        return response()->json( $response );
    }

    public function select(Request $request){
        if(!$request->ajax()) return redirect('/');
        $sites = Site::where('status', '=', 1)
            ->select('id', 'name')
            ->orderBy('name', 'asc')->get();
        return response()->json(['sites' => $sites]);
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
        $this->_validate();
        $site = new Site();
        $site->name = $request->nombre;
        $site->address = $request->address;
        $site->status = 1;
        $site->save();
        $this->siteVoucher( $request->typeVouchers );
        $this->logAdmin("Registró un nuevo sitio.");
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
        if(!$request->ajax()) return redirect('/');
        $this->_validate();
        $site = Site::findOrFail($request->id);
        $site->name = $request->nombre;
        $site->address = $request->address;
        $site->save();
        $this->siteVoucher( $request->typeVouchers );
        $this->logAdmin("Actualizó los datos del sitio:",$site);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 0;
        $site->save();
        $this->logAdmin("Desactivó el sitio:".$site->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 1;
        $site->save();
        $this->logAdmin("Activó el sitio:".$site->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $site = Site::findOrFail($request->id);
        $site->status = 2;
        $site->save();
        $this->logAdmin("Dió de baja el sitio:".$site->id);
    }

    private function siteVoucher( $siteVouchers ) {
        foreach ( $siteVouchers as $siteVoucher ) {
            $siteVoucherClass = SiteVourcher::find( $siteVoucher['id'] );
            if( !$siteVoucherClass ) {
                $siteVoucherClass = new SiteVourcher();
                $siteVoucherClass->type_vouchers_id = $siteVoucher['typeVoucher'];
            }

            $siteVoucherClass->serie = $siteVoucher['serie'];
            $siteVoucherClass->number = $siteVoucher['number'];
            $siteVoucherClass->status = 1;
            $siteVoucherClass->save();
        }
    }
}
