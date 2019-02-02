<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function arrayDays(Request $request){
        if(!$request->ajax()) return redirect('/');
        $numberDays = cal_days_in_month(CAL_GREGORIAN, $request->month, date('Y'));
        $aDays = [];
        for ($day = 1; $day <= $numberDays; $day++){
            $aDays[] = $day;
        }
        return ['days' => $aDays];
    }
}
