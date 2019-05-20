<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';
    protected $fillable = ['purchase_request_id', 'providers_id', ' user_reg', 'status'];

    public function scopeSearch( $query,  $search ){
        if( ! empty( $search ) ){
            return $query->where( function ( $query ) use( $search ) {
                $searchFormat = '%' . $search . '%';
                $query->where( 'providers.name', 'like', $searchFormat )
                    ->orWhere( 'providers.business_name', 'like', $searchFormat )
                    ->orWhere( 'providers.document', 'like', $searchFormat )
                    ->orWhere( 'purchase_request.code', 'like', $searchFormat )
                    ->orWhere( 'purchase_request.date', 'like', $searchFormat );
            });
        }
    }
}
