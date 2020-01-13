<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'service_requests';
    public function customer() {
        return $this->belongsTo( 'App\Customer', 'customers_id', 'id');
    }

    public function serviceRequestDetails() {
        return $this->hasMany( 'App\Models\ServiceRequestDetail', 'service_requests_id', 'id');
    }
}
