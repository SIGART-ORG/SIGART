<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationAproved extends Model
{
    protected $table = 'quotation_aproveds';
    protected $fillable = ['purchase_request_id', 'providers_id', 'user_reg', 'status'];
}
