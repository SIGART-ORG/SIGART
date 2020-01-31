<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestDetail extends Model
{
    const TABLE = 'service_request_details';
    protected $table = self::TABLE;

    public function serviceRequest() {
        return $this->belongsTo( 'App\Models\ServiceRequest', 'service_requests_id', 'id' );
    }
}
