<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

use Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const IGV = (18 / 100);
    const PAGINATE = 100;
    const DATE_FORMAT = 'd/m/Y';

    public function logAdmin($message, $optional = [], $type = "info")
    {
        if (Auth::check()) {
            $user = Auth::user();
            $admin = $user->name . " " . $user->last_name;
            $message = $admin . " " . $message;
        }
        if (is_object($optional)) {
            $optional = (array)$optional;
        }
        switch ($type) {

            case "info":
                Log::info($message, $optional);
                break;
            case "emergency":
                Log::emergency($message, $optional);
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

    public function sendMail($to, $subject, $template, $vars, $from = 'Automatic', $attach = '')
    {
        $dataMail = new \stdClass();
        $dataMail->from = $from;
        $dataMail->to = $to;
        $dataMail->subject = $subject;
        $dataMail->body = '';
        $dataMail->vars = $vars;
        $dataMail->attach = $attach;

        \Mail::to( $to )->send( new SendMail( $dataMail, $template ) );
    }

    public function getUrlWeb( $params = '' ) {
        return env( 'APP_URL_WEB' ) . '/' . ( $params !== '' ? $params : '' );
    }
}
