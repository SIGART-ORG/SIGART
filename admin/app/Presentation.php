<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $table = 'presentation';
    protected $fillable = [
        'products_id',
        'unity_id',
        'description',
        'equivalence',
        'status'
    ];

    public function scopeWherePresentation( $query, $arData ) {
        if( ! empty( $arData ) && count( $arData ) > 0 ){
            foreach ( $arData as $row ){
                $query->where( $row['col'], $row['operator'], $row['value'] );
            }
        }
        return $query;
    }
}
