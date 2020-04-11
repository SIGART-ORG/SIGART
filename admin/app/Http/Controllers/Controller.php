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
    const PAGINATE = 20;
    const DATE_FORMAT = 'd/m/Y';
    const FORMAT_DATE_COMPLETE = 'd/m/Y h:i a';
    const DATE_FORMAT_REPORT = 'Y-m-d';
    const DATE_FORMAT_COMP = 'd/m/Y h:i:s a';

    const UPLOAD_VOUCHER = 'uploads/voucher/';
    const PATH_PDF_SALE = '/sales/';

    const WEB_PATH_VOUCHER = '/uploads/voucher/';

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
        try {
            $dataMail = new \stdClass();
            $dataMail->from = $from;
            $dataMail->to = $to;
            $dataMail->subject = $subject;
            $dataMail->body = '';
            $dataMail->vars = $vars;
            $dataMail->attach = $attach;

            \Mail::to( $to )->send( new SendMail( $dataMail, $template ) );
        } catch ( \Exception $e ) {
            return $e;
        }
    }

    public function getUrlWeb( $params = '' ) {
        return env( 'APP_URL_WEB' ) . '/' . ( $params !== '' ? $params : '' );
    }

    public function getDateFormat( $date ) {
        $dateFormated = '---';
        if( !empty( $date ) ) {
            $dateFormated = date( self::DATE_FORMAT, strtotime( $date ) );
        }

        return $dateFormated;
    }

    protected function getDateComplete( $date ) {
        return $date ? date( self::FORMAT_DATE_COMPLETE, strtotime( $date ) ) : '---';
    }

    public function getDataUser( $user ) {
        $data = [
            'name' => '',
            'document' => '',
            'role' => ''
        ];

        if( $user ) {
            $data['name'] = $user->name . ' ' . $user->last_name;
            $data['document'] = $user->document;
        }

        return $data;
    }

    public function getDataCustomer( $customer ) {
        $data = [
            'name' => '',
            'document' => '',
            'typeDocument' => ''
        ];

        if( !empty( $customer ) ) {
            $data['name'] = $customer->type_person === 1 ? $customer->name . ' ' . $customer->lastname : $customer->name;
            $data['document'] = $customer->document;
            $data['typeDocument'] = $customer->typeDocument->name;
            $data['email'] = $customer->email;
        }

        return $data;
    }

    public function getDataProviderV2( $provider ) {
        $data = [
            'name' => '',
            'document' => '',
            'typeDocument' => ''
        ];

        if( !empty( $provider ) ) {
            $data['name'] = $provider->name;
            $data['document'] = $provider->document;
            $data['typeDocument'] = $provider->typeDocument->name;
        }

        return $data;
    }

    public function calculatePorc( $total, $partial, $text = '' ) {
        return round( ( $partial / $total ) * 100, 2 ) . ( $text !== '' ? ' ' . $text : '' );
    }

    public function getStatus( $type, $status ) {
        $statusName = '';

        switch ( $type ) {
            case 'service':
                switch ( $status ) {
                    case 0:
                        $statusName = 'Desactivado';
                        break;
                    case 1:
                        $statusName = 'Generado';
                        break;
                    case 2:
                        $statusName = 'Eliminado';
                        break;
                    case 3:
                        $statusName = 'Por Iniciar';
                        break;
                    case 4:
                        $statusName = 'En proceso';
                        break;
                    case 5:
                        $statusName = 'Terminado';
                        break;
                    case 6:
                        $statusName = 'Finalizado';
                        break;
                    case 7:
                        $statusName = 'Pagado';
                        break;
                }
                break;
            case 'purchase':
                switch ( $status ) {
                    case 0:
                        $statusName = 'Desactivado';
                        break;
                    case 1:
                        $statusName = 'Pendiente';
                        break;
                    case 2:
                        $statusName = 'Anulado';
                        break;
                    case 3:
                        $statusName = 'Recepcionado';
                        break;
                    case 4:
                        $statusName = 'Pagado';
                        break;
                }
                break;
            case 'task':
            case 'stage':
                switch ( $status ) {
                    case 0:
                        $statusName = 'Desactivado';
                        break;
                    case 1:
                        $statusName = 'Por Iniciar';
                        break;
                    case 2:
                        $statusName = 'Eliminado';
                        break;
                    case 3:
                        $statusName = 'En proceso';
                        break;
                    case 4:
                        $statusName = 'Terminado';
                        break;
                    case 5:
                        $statusName = 'Observado';
                        break;
                    case 6:
                        $statusName = 'Finalizado';
                        break;
                }
                break;
            case 'observation':
                switch ( $status ) {
                    case 0:
                        $statusName = 'Desactivado';
                        break;
                    case 1:
                        $statusName = 'Pendiente';
                        break;
                    case 2:
                        $statusName = 'Eliminado';
                        break;
                    case 3:
                        $statusName = 'Obs. Aceptada';
                        break;
                    case 4:
                        $statusName = 'Obs. Denegada';
                        break;
                }
                break;
        }

        return $statusName;
    }

    public function orderArraybyColumn( $array, $column = 'id', $order = 'asc' ) {

        $arrayreturn = [];

        if( $order === 'asc' ) {
            $arrayTemp = collect( $array )->sortByDesc( $column )->reverse()->toArray();
        } else {
            $arrayTemp = collect( $array )->sortBy( $column )->reverse()->toArray();
        }

        foreach ( $arrayTemp as $row ) {
            $arrayreturn[] = $row;
        }

        return $arrayreturn;
    }
}
