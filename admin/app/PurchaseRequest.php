<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'purchase_request';
    protected $fillable = ['code', 'date', 'status'];

    public function scopeSearch( $query, $search ){
        if( !empty($search) ){
            return $query->where( function ( $query ) use ($search) {
                $query->where('code', 'like', '%' . $search . '%')
                    ->orWhere('date', 'like', '%' . $search . '%');
            });
        }
    }
}
