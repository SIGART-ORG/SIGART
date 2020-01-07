<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SupplantController extends Controller
{
    public function supplant(User $user){
        $originalUser = auth()->id();

        if( $user->id !== $originalUser){
            session()->put('original-user', $originalUser);
            session()->put('original-name-user', auth()->user()->name);

            auth()->login($user);

            $access = User::getUserSitesRoles( auth()->user()->id );

            session([
                'access' => $access['data'],
                'defaultAccess' => $access['default'],
                'siteDefault' => $access['siteDefault'],
                'roleDefault' => $access['roleDefault']
            ]);

//            dd( $access, session( 'roleDefault' ) );
            return back();
        }
    }

    public function reverse(){
        $originalUser = session()->get('original-user');
        auth()->loginUsingId($originalUser);
        session()->forget('original-user');
        session()->forget('original-name-user');

        $access = User::getUserSitesRoles( $originalUser );

        session([
            'access' => $access['data'],
            'defaultAccess' => $access['default'],
            'siteDefault' => $access['siteDefault'],
            'roleDefault' => $access['roleDefault']
        ]);
        return back();
    }
}
