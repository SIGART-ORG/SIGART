<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

use Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function logAdmin( $message,$optional=[],$type="info"){
        if (Auth::check()) {
            $user = Auth::user();
            $admin = $user->name." ".$user->last_name;
            $message= $admin." ".$message;
        }
        switch($type){

            case "info":
                Log::info($message,$optional);
                break;
            case "emergency":
                Log::emergency($message,$optional);
                break;
            case "alert":
                Log::alert($message, $optional);
                break;
            case "error":
                Log::error($message, $optional);
                break;
            case "warning":
                Log::warning($message, $optional);
                break;
            case "notice":
                Log::notice($message, $optional);
                break;
            case "debug":
                Log::debug($message, $optional);
                break;
        }
    }
}
