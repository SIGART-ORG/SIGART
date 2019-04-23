<?php
namespace App\Helpers;

use DB;

class HelperSigart {

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


        $response = \App\Departament::where( 'district.id', $district )
                        ->join( 'province', 'province.departament_id', '=', 'departament.id' )
                        ->join( 'district', 'district.province_id', '=', 'province.id' )
                        ->select(
                            'departament.id as departament_id',
                            'departament.name as departament_name',
                            'province.id as province_id',
                            'province.name as province_name',
                            'district.id as district_id',
                            'district.name as district_name'
                        )
                        ->get();

        switch( $format ){
            case 'inline':
                $select = ( $response[0]->district_name ? $response[0]->district_name : '' ) . ' - ' .
                        ( $response[0]->province_name ? $response[0]->province_name : '' ) . ' - ' .
                        ( $response[0]->departament_name ? $response[0]->departament_name : '' );
                break;
            default:
                $select = [
                    'departament_id' => ( $response[0]->departament_id ? $response[0]->departament_id : '' ),
                    'departament_name' => ( $response[0]->departament_name ? $response[0]->departament_name : '' ),
                    'province_id' => ( $response[0]->province_id ? $response[0]->province_id : '' ),
                    'province_name' => ( $response[0]->province_name ? $response[0]->province_name : '' ),
                    'district_id' => ( $response[0]->district_id ? $response[0]->district_id : '' ),
                    'district_name' => ( $response[0]->district_name ? $response[0]->district_name : '' )
                ];
        }

        return $select;
    }
}