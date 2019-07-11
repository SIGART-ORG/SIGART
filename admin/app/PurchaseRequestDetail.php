<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
    protected $table = 'purchase_request_detail';
    protected $fillable = ['purchase_request_id', 'presentation_id', 'quantity', 'status'];
}
