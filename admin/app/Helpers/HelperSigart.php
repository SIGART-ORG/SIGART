<?php
namespace App\Helpers;

use DB;
use phpDocumentor\Reflection\Types\Self_;

class HelperSigart {

    static $_TABLE_DEP = 'departaments';
    static $_TABLE_PROV = 'provinces';
    static $_TABLE_DIST = 'districts';

    public static function completeNameUbigeo($input, $limit = 6) {

        if( strlen( $input ) < $limit ){
            $nroComplement = (int)($limit - strlen( $input ));
            $complement =  '';
            for( $i = 1; $i <= $nroComplement; $i++ ) {
                $complement .= '0';
            }
            $input = $complement . $input;
        }

        return $input;
    }

    public static function getTypePerson() {
        return [
            [
                'id' => 1,
                'name' => 'Persona Natural'
            ],
            [
                'id' => 2,
                'name' => 'Persona Juridico'
            ]
        ];
    }

    public static function getTypeTelephone() {
        return [
            [
                'id' => 1,
                'name' => 'Telf. Fijo'
            ],
            [
                'id' => 2,
                'name' => 'Telf. Celular'
            ]
        ];
    }

    public static function ubigeo( $district, $format = '' ) {

        $response = \App\Models\Departament::where(  self::$_TABLE_DIST . '.id', $district )
                        ->join( self::$_TABLE_PROV, self::$_TABLE_PROV . '.departament_id', '=', self::$_TABLE_DEP . '.id' )
                        ->join( self::$_TABLE_DIST, self::$_TABLE_DIST . '.province_id', '=', self::$_TABLE_PROV . '.id' )
                        ->select(
                            self::$_TABLE_DEP . '.id as departament_id',
                            self::$_TABLE_DEP . '.name as departament_name',
                            self::$_TABLE_PROV . '.id as province_id',
                            self::$_TABLE_PROV . '.name as province_name',
                            self::$_TABLE_DIST . '.id as district_id',
                            self::$_TABLE_DIST . '.name as district_name'
                        )
                        ->get();

        $select = '';
        if( count( $response ) > 0 ) {
            switch ($format) {
                case 'inline':
                    $select = ($response[0]->district_name ? $response[0]->district_name : '') . ' - ' .
                        ($response[0]->province_name ? $response[0]->province_name : '') . ' - ' .
                        ($response[0]->departament_name ? $response[0]->departament_name : '');
                    break;
                default:
                    $select = [
                        'departament_id' => ($response[0]->departament_id ? $response[0]->departament_id : ''),
                        'departament_name' => ($response[0]->departament_name ? $response[0]->departament_name : ''),
                        'province_id' => ($response[0]->province_id ? $response[0]->province_id : ''),
                        'province_name' => ($response[0]->province_name ? $response[0]->province_name : ''),
                        'district_id' => ($response[0]->district_id ? $response[0]->district_id : ''),
                        'district_name' => ($response[0]->district_name ? $response[0]->district_name : '')
                    ];
            }
        }

        return $select;
    }
}
