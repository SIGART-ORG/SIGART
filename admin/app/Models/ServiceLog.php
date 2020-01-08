<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceLog extends Model
{
    protected $table = 'service_logs';
    protected $fillable = [
        'services_id',
        'description',
        'binnacles_id'
    ];

    public function registerLog( $service, $message, $type ) {
        $this->services_id = $service;
        $this->description = $message;
        $this->binnacles_id = $type;
        $this->save();

        return true;
    }
}
