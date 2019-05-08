<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationAprovedDetail extends Model
{
    protected $table = 'quotation_aproved_details';
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
