<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    public function customer() {
        return $this->belongsTo( 'App\Customer', 'customers_id', 'id');
    }
}
