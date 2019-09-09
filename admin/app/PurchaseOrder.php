<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $fillable = [
        'sites_id',
        'provider_id',
        'quotations_id',
        'user_reg',
        'user_aproved',
        'code',
        'date_reg',
        'subtotal',
        'igv',
        'total',
        'status',
        'status'
    ];

    public function scopeSearch( $query, $search ) {
        if( ! empty( $search ) ) {
            return $query->where( function( $query ) use( $search ) {
                $searchFormat = '%' . $search . '%';
                $query->where('purchase_orders.code', 'like', $searchFormat)
                    ->orWhere('providers.name', 'like', $searchFormat)
                    ->orWhere('providers.business_name', 'like', $searchFormat)
                    ->orWhere('providers.document', 'like', $searchFormat);
            });
        }
    }

    public static function getCorrelative( $site ) {
        return self::where('code', '!=', 'S/C')
                ->where('sites_id', $site)
                ->count() + 1;
    }
}
