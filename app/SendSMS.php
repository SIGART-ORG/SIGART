<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 04/01/19
 * Time: 10:35 PM
 */

namespace App;
use App\Sms;


class SendSMS
{
    const PREF_COUNTRY = '+51';
    const NUMBER_FROM = '927690035';
    const PREF_TEXT = 'SIGART:: ';

    public static function sendSMS($phone, $message){
        $search = [
            'á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä',
            'é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë',
            'í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î',
            'ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô',
            'ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü',
            'ñ', 'Ñ', 'ç', 'Ç'
        ];
        $replace = [
            'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A',
            'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E',
            'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I',
            'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O',
            'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U',
            'n', 'N', 'c', 'C'
        ];
        $message = str_replace($search, $replace, $message);
        $message = strtoupper($message);
        $nexmo = app('Nexmo\Client');

        $to = self::PREF_COUNTRY.$phone;
        $from = self::PREF_COUNTRY.self::NUMBER_FROM;
        $message = self::PREF_TEXT.$message;

        $sms = new Sms();
        $sms->phone = $from;
        $sms->message = $message;
        $sms->save();

        $nexmo->message()->send([
            'to' => $to,
            'from' => $from,
            'text' => $message
        ]);

        return $nexmo;
    }
}