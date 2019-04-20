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
                'id' => 0,
                'name' => 'Persona Natural'
            ],
            [
                'id' => 1,
                'name' => 'Persona Juridico'
            ]
        ];
    }
}