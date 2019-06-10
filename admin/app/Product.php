<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'unity_id', 'user_reg', 'name', 'description', 'pricetag', 'status'];

    public function scopeSearchList( $query, $search ){
        if( ! empty( $search ) ) {
            return $query->where( $this->table . '.name', 'like', '%'.$search.'%')
                ->orWhere( 'presentation.description', 'like', '%'.$search.'%')
                ->orWhere( 'presentation.sku', 'like', '%'.$search.'%')
                ->orWhere( 'unity.name', 'like', '%'.$search.'%')
                ->orWhere( $this->table . '.description', 'like', '%'.$search.'%')
                ->orWhere( 'categories.name', 'like', '%' . $search . '%');
        }
    }

    public function scopeSearch($query, $search)
    {
        if( $search != "") {
            return $query->where(function ($query) use ($search) {
                $query->where( $this->table .'.name', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('products.description', 'like', '%' . $search . '%')
                    ->orWhere('categories.name', 'like', '%' . $search . '%')
                    ->orWhere('unity.name', 'like', '%' . $search . '%');
            });
        }
    }

    public function scopeColumnsSelect($query){
        return $query->select(
            'products.id',
            'products.category_id',
            'products.user_reg',
            'products.name',
            'products.description',
            'products.pricetag',
            'products.slug',
            'products.status',
            'categories.name as category',
            'unity.name as unity',
            'presentation.id as presentation_id',
            'presentation.description as presentation',
            'presentation.unity_id',
            'presentation.equivalence',
            'presentation.stock'
        )
            ->selectRaw('(select 
                                    products_images.image_admin
                                from 
                                    products_images 
                                where products_images.products_id = products.id and products_images.status = 1
                                    and products_images.image_default = 1
                                limit 1 ) as image');
    }

    public function scopeWhereProduct( $query, $arData ) {
        if( ! empty( $arData ) && count( $arData ) > 0 ){
            foreach ( $arData as $row ){
                $query->where( $row['col'], $row['operator'], $row['value'] );
            }
        }
        return $query;
    }
}
