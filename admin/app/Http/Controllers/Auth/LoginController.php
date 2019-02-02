<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $this->validateLogin($request);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])){
            $this->logWeb("info","Ha iniciado session " );
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
        $this->logWeb("info", "Cerró sessión ");
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
