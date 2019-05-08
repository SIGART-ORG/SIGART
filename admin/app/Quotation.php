<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';
    protected $fillable = ['purchase_request_id', 'providers_id', ' user_reg', 'status'];
}
