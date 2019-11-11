<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SiteVourcher extends Model
{
    const TABLE_NAME = 'site_vourchers';

    protected $table = self::TABLE_NAME;

    public function getNumberVoucherSite( $typeVoucher, $format = 'inline') {

        $correlative = DB::table( self::TABLE_NAME )->where( 'status', 1 )
            ->where( 'sites_id', session( 'siteDefault' ) )
            ->where( 'type_vouchers_id', $typeVoucher )
            ->select( 'id', 'serie', 'number' )
            ->first();

        if( $correlative ) {
            $response = [];
            $status = false;
            switch ($format) {
                case 'inline':
                    $status = true;
                    $response['status'] = true;
                    $response['correlative'] = ( ! empty( $correlative->serie ) ? $correlative->serie . '-' : '') . $correlative->number;
                    break;
            }

            if(  $status ) {
                return $response;
            } else {
                return ['status' => false, 'message' => 'Tipo de formato incorrecto'];
            }
        }

        return ['status' => false, 'message' => 'No se encontró algun registro que coincida con su selección'];
    }

    public function increaseCorrelative( $typeVoucher, $increase = 1 ) {

        DB::table( self::TABLE_NAME )->where( 'sites_id', session( 'siteDefault' ) )
            ->where( 'type_vouchers_id', $typeVoucher )
            ->where( 'status', 1 )
            ->increment( 'number', $increase );

        return true;

    }
}
