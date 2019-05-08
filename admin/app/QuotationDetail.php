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
}
