<?php

namespace App\Http\Controllers;

use App\Models\UserSite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use App\Access;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\QueryDB\UserQuery;
use Image;

class UserController extends Controller
{
    protected $users;
    protected $_moduleDB = 'user';
    protected $_page = 2;

    public function __construct(UserQuery $users)
    {
        $this->users = $users;
    }

    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $num_per_page = 20;

        $buscar = $request->search;
        $key = "paginated_".$request->page;

        if($buscar != '' ) {
            $key.= "-".$buscar;
        }
        $users = Cache::remember($key, 1, function() use($num_per_page,$buscar) {
            return $this->users->getPaginated($num_per_page, $buscar);
        });

        return [
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'records' => $users
        ];
    }

    public function dashboard(){
        $breadcrumb = [
            [
                'name' => 'Colaboradores',
                'url' => route( 'user.index' )
            ],
            [
                'name' => 'Listado',
                'url' => '#'
            ]
        ];


        $permiso = Access::sideBar( $this->_page );
        return view('mintos.content', [
            "menu"          => $this->_page,
            'sidebar'       => $permiso,
            "moduleDB"      => $this->_moduleDB,
            'breadcrumb'    => $breadcrumb,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $response = [
            'status' => false
        ];

        $user = $this->users->getModel();
        $user->password = bcrypt($request->documento);
        $user->role_id = $request->rol;
        $user->name = $request->nombre;
        $user->last_name = $request->apellido;
        $user->address = $request->direccion;
        $user->email = $request->correo;
        $user->document = $request->documento;
        $user->phone = $request->phone;
        $user->birthday = date('Y-m-d', strtotime($request->cumpleanos));
        $user->date_entry = date('Y-m-d', strtotime($request->ingreso));
        $user->status = 1;
        $user->img_profile = '';
        $user->img_cover_page = '';
        if ( $user->save() ) {
            $this->logAdmin("Registró un nuevo usuario.");
            if ( ! empty( $request->access ) ) {
                $this->insertUserSites( $user->id,  $request->access, $request->siteDefault );
            }

            $response['status'] = true;
        }

        return response()->json( $response, 200 );
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {

        $response = [
            'status' => false
        ];

        if(!$request->ajax()) return redirect('/');

        $user = $this->users->findOrFail($request->id);
        $user->role_id = $request->rol;
        $user->name = $request->nombre;
        $user->last_name = $request->apellido;
        $user->address = $request->direccion;
        $user->email = $request->correo;
        $user->document = $request->documento;
        $user->phone = $request->phone;
        $user->birthday = date('Y-m-d', strtotime($request->cumpleanos));
        $user->date_entry = date('Y-m-d', strtotime($request->ingreso));
        $user->status = 1;
        if ( $user->save() ) {
            $this->logAdmin("Actualizó los datos del usuario:", $user);
            if ( ! empty( $request->access ) ) {
                $this->insertUserSites( $user->id, $request->access, $request->siteDefault );
                $userSession = Auth::user();
                if( $userSession->id === $user->id ) {
                    $access = User::getUserSitesRoles( $userSession->id );
                    session(['access' => $access]);
                }
            }

            $response['status'] = true;
        }

        return response()->json(
            $response, 200
        );
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 0;
        $user->save();
        $this->logAdmin("Desactivó al usuario:".$user->id);
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 1;
        $user->save();
        $this->logAdmin("Activó al usuario:".$user->id);
    }

    public function delete(Request $request){
        if(!$request->ajax()) return redirect('/');
        $user = $this->users->findOrFail($request->id);
        $user->status = 2;
        $user->save();
        $this->logAdmin("Dió de baja al usuario:".$user->id);
    }

    public function profile(){
        $permiso = Access::sideBar();
        $this->_moduleDB = 'profile';
        return view('modules/profile', [
            "menu" => 0,
            'sidebar' => $permiso,
            "moduleDB" => $this->_moduleDB
        ]);
    }

    public function dataSesion(Request $request){
        if(!$request->ajax()) return redirect('/');
        $userId = Auth::user()->id;
        $user = $this->users->findOrFail($userId);
        return $user;
    }

    public function saveData(Request $request){
        $userId = Auth::user()->id;
        $user = $this->users->findOrFail($userId);
        $user->name = $request->name;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->document = $request->document;
        $user->address = $request->address;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;

        $path = public_path().'/user/'.$request->id.'/';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        if($request->file('profile')) {
            $imageProfile = $request->file('profile');
            $imgProfile = Image::make($imageProfile);
            $tempNameProfile = 'profile-image-'.$this->random_string().'.' . $imageProfile->getClientOriginalExtension();
            $imgProfile->resize(128, 128);
            if($user->img_profile != "" and file_exists($path . $user->img_profile)){
                unlink($path . $user->img_profile);
                $user->img_profile = '';
            }
            $imgProfile->save($path . $tempNameProfile, 100);
            $user->img_profile = $tempNameProfile;
        }

        if($request->file('coverPage')) {
            $imageCoverPage = $request->file('coverPage');
            $imgCoverPage = Image::make($imageCoverPage);
            $tempNameCoverPage = 'cover-page-image-'.$this->random_string().'.' . $imageCoverPage->getClientOriginalExtension();
            $imgCoverPage->resize(805, 300);
            if($user->img_cover_page != "" and file_exists($path . $user->img_cover_page)){
                unlink($path . $user->img_cover_page);
                $user->img_cover_page = '';
            }
            $imgCoverPage->save($path . $tempNameCoverPage, 100);
            $user->img_cover_page = $tempNameCoverPage;
        }

        $user->save();
        $this->logAdmin("Actualizó los datos del perfil de usuario:",$user);

        return [
            'ok' => true,
            'image_profile' => $user->img_profile,
            'image_cover_page' => $user->img_cover_page
        ];
    }

    protected function random_string()
    {
        $key = '';
        $keys = array_merge(range('a', 'z'), range(0, 9));

        for($i = 0; $i < 5; $i++){
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    public function loginUser(Request $request){
        $num_per_page = 20;

        $buscar = $request->buscar;

        $whereAdd = [];
        $whereAdd[] = (object) [ 'col' => 'role_id', 'oper' => '!=', 'value' => 1 ];

        $users = $this->users->getPaginated($num_per_page, $buscar, $whereAdd);

        $data = [
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'records' => $users
        ];

        $permiso = Access::sideBar();
        return view('modules/userLogin', [
            "menu" => 13,
            'sidebar' => $permiso,
            'data' => $data,
            'buscar' => $buscar
        ]);
    }

    public function getRequest( Request $request){
        return $request->user();
    }

    public function insertUserSites( $user, $userSite, $default ) {
        if ( is_array( $userSite ) && count( $userSite ) ) {
            foreach ( $userSite as $row ) {
                $searchUS = UserSite::where('users_id', $user)
                            ->where('roles_id', $row['role'])
                            ->where('sites_id', $row['site'])
                            ->first();
                if( ! empty( $searchUS )  && ! is_null( $searchUS ) ) {
                    if ( $row['delete'] == 0 ) {
                        if( $searchUS->status !== 1 ) {
                            $searchUS->status = 1;
                        }
                        $searchUS->default = ( $row['siteDefault'] == $default ) ? '1' : '0';
                        $searchUS->save();
                    } else {
                        $searchUS->status = 2;
                        $searchUS->save();
                    }
                } else {
                    if ( $row['delete'] == 0 ) {
                        $newUS = new UserSite();
                        $newUS->users_id = $user;
                        $newUS->roles_id = $row['role'];
                        $newUS->sites_id = $row['site'];
                        $newUS->default = ( $row['siteDefault'] == $default ) ? '1' : '0';
                        $newUS->status = 1;
                        $newUS->save();
                    }
                }
            }
        }
    }

    public function getUserSite( Request $request) {
        if(!$request->ajax()) return redirect('/');

        $response = [];

        $userSites = UserSite::where( 'status', 1 )
            ->where( 'users_id', $request->user )
            ->get();

        foreach ( $userSites as $us ) {
            $response[] = [
                'site' => $us->sites_id,
                'role' => $us->roles_id,
                'default' => $us->default
            ];
        }

        return response()->json( [
            'response' => $response
        ], 200 );
    }

    public function changeSite( Request $request ) {
        $user = Auth::user();
        $userSite = $request->userSite;
        if( $userSite > 0 ) {

            UserSite::where( 'status', 1 )
                ->where( 'users_id', $user->id )
                ->where( 'default', '1' )
                ->update(['default' => '0']);

            $userSiteClass = UserSite::findOrFail( $userSite );
            $userSiteClass->default = '1';

            if( $userSiteClass->save() ) {
                $access = User::getUserSitesRoles( $user->id );
                session([
                    'access' => $access['data'],
                    'defaultAccess' => $access['default']
                ]);
            }

            return response()->json([
                'status' => true,
            ]);
        }
        return response()->json([
            'status' => false,
        ]);
    }
}
