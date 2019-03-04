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
        //print_r($optional);
        switch($type){

            case "info":
                Log::info($message,$optional->toArray());
                break;
            case "emergency":
                Log::emergency($message,$optional->toArray());
                break;
            case "alert":
                Log::alert($message, $optional->toArray());
                break;
            case "error":
                Log::error($message, $optional->toArray());
                break;
            case "warning":
                Log::warning($message, $optional->toArray());
                break;
            case "notice":
                Log::notice($message, $optional->toArray());
                break;
            case "debug":
                Log::debug($message, $optional->toArray());
                break;
        }
    }
}
