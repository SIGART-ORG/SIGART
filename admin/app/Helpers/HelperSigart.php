<?php
namespace App\Helpers;

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
}