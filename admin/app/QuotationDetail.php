<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $table = 'quotation_details';
    protected $fillable = [
        'quotations_id',
        'presentation_id',
        'quantity',
        'unit_price',
        'total',
        'selected',
        'status'
    ];

    public function scopeSelected( $query, $selected ) {
        if( ! empty( $selected ) && $selected ) {
            return $query->where('quotation_details.selected', 1);
        }
    }
}
