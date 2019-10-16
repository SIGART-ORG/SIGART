<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $redirectTo = '/main';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('mintos.main-login');
    }

    public function login(Request $request){
        $this->validateLogin($request);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])){

            $access = User::getUserSitesRoles( Auth::user()->id );
            session(['access' => $access]);
            $this->logAdmin("Ha iniciado sesión" );
            return redirect()->route('main');
        }

        return back()
            ->withErrors(['email' => trans('auth.failed')])
            ->withInput(request(['email']));
    }

    protected function validateLogin(Request $request){
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
    }

    public function logout(Request $request){
        $this->logAdmin("Cerró sesión.");
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
