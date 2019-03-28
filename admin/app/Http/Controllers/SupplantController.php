<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SupplantController extends Controller
{
    public function supplant(User $user){
        $originalUser = auth()->id();

        if( $user->id !== $originalUser){
            session()->put('original-user', $originalUser);
            session()->put('original-name-user', auth()->user()->name);
            auth()->login($user);
            return back();
        }
    }

    public function reverse(){
        $originalUser = session()->get('original-user');
        auth()->loginUsingId($originalUser);
        session()->forget('original-user');
        session()->forget('original-name-user');
        return back();
    }
}
