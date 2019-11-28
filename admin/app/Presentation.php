<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Presentation extends Model
{
    const TABLE_NAME = 'presentation';
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        'products_id',
        'unity_id',
        'description',
        'equivalence',
        'status'
    ];

    public function product() {
        return $this->belongsTo( 'App\Product', 'products_id');
    }

    public function unity() {
        return $this->belongsTo( 'App\Unity', 'unity_id');
    }

    public function scopeWherePresentation( $query, $arData ) {
        if( ! empty( $arData ) && count( $arData ) > 0 ){
            foreach ( $arData as $row ){
                $query->where( $row['col'], $row['operator'], $row['value'] );
            }
        }
        return $query;
    }

    public function scopeSearch( $query, $search, $stock )
    {
        if( $search != "") {
            if( $stock === '' ) {
                return $query->where(function ($query) use ($search) {
                    $query->where(self::TABLE_NAME . '.description', 'like', '%' . $search . '%')
                        ->orWhere('products.name', 'like', '%' . $search . '%')
                        ->orWhere('products.description', 'like', '%' . $search . '%')
                        ->orWhere('categories.name', 'like', '%' . $search . '%')
                        ->orWhere('unity.name', 'like', '%' . $search . '%');
                });
            } else {
                return $query->where(function ($query) use ($search) {
                    $query->where(self::TABLE_NAME . '.description', 'like', '%' . $search . '%')
                        ->orWhere('unity.name', 'like', '%' . $search . '%');
                });
            }
        }
    }

    public function scopeColumnsSelectStock( $query, $stock ) {
        $siteSesion = session('siteDefault');

        $subQueryStock = '(SELECT 
            stocks.stock
        FROM
            stocks
        WHERE
            stocks.sites_id = ' . $siteSesion . '
                AND stocks.presentation_id = presentation.id) AS stock';

        $subQueryPrice = '(SELECT 
            stocks.price
        FROM
            stocks
        WHERE
            stocks.sites_id = ' . $siteSesion . '
                AND stocks.presentation_id = presentation.id) AS price';

        if( $stock !== '' ) {
            return $query->select(
                'unity.name as unity',
                'presentation.id as presentation_id',
                'presentation.description as presentation',
                'presentation.unity_id',
                'presentation.pricetag_purchase as pricetag',
                DB::raw( $subQueryStock )
            );
        } else {
            return $query->select(
                'products.id',
                'products.category_id',
                'products.user_reg',
                'products.name',
                'products.description',
                'products.slug',
                'products.status',
                'categories.name as category',
                'unity.name as unity',
                'presentation.id as presentation_id',
                'presentation.description as presentation',
                'presentation.unity_id',
                'presentation.equivalence',
                'presentation.pricetag_purchase as pricetag',
                DB::raw( $subQueryStock ),
                DB::raw( $subQueryPrice )
            );
        }
    }

    public function scopeWhereTypeProduct( $query, $type ) {
        if( ! empty( $type ) || $type > 0 ) {
            return $query->where( 'products.cod_type_service', $type );
        }
    }

}
