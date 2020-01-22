<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referenceterm extends Model
{
    const TABLE_NAME = 'referenceterms';

    protected $table = self::TABLE_NAME;

    public $_area = 'AREA DE ADMINISTRACIÓN';
    public $_specialized_area = 'AREA DE PRODUCCIÓN';
    public $_execution_time_text  = 'LA EJECUCION DEL PRESENTE SERVICIO SE REALIZARA EN EL PLAZO MAXIMO DE {{days}} CALENDARIO.\n
    LA VIGENCIA DEL SERVICIO SE EXTENDERA A PARTIR DEL DIA SIGUIENTE DE NOTIFICADA LA ORDEN DE SERVICIO.';
    public $_conformance_grant = 'LA CONFORMIDAD SE ENTREGARA UNA VEZ CULMINADO EL SERVICIO Y CON EL VISTO BUENO DE GERENCIA Y EL CLIENTE ';
    public $_warranty_text = 'DECLARACION JURADA DE QUE EL SERVICIO TENDRA TRES {{warranty_month}} DE GARANTIA DEL SERVICIO PRESTADO.';


    public function saleQuotation() {
        return $this->belongsTo( 'App\SalesQuote', 'sales_quotations_id' );
    }

    public function customer() {
        return $this->belongsTo( 'App\Customer', 'customers_id' );
    }

    public function referencetermDetails() {
        return $this->hasMany( 'App\Models\ReferencetermDetail', 'referenceterms_id' );
    }

    public function execution_time_text( $days ) {

        $daysText = $days . ' ';
        $daysText .= $days > 1 ? 'DÍAS' : 'DÍA';

        return str_replace( '{{days}}', $daysText, $this->_execution_time_text );
    }

    public function warranty_text( $month ) {
        $monthText = $month . ' ';
        $monthText .= $month > 1 ? 'MESES' : 'MES';

        return str_replace( '{{warranty_month}}', $monthText, $this->_warranty_text );
    }
}
