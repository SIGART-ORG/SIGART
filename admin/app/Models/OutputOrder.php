<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutputOrder extends Model
{
    const TABLE_NAME = 'output_orders';
    protected $table = self::TABLE_NAME;

    public function service() {
        return $this->belongsTo( Service::class, 'services_id', 'id' );
    }

    public function serviceRequirement() {
        return $this->belongsTo( ServiceRequirement::class, 'service_requirements_id', 'id' );
    }

    public function ouputsOrderDetails() {
        return $this->hasMany( OutputOrderDetails::class, 'output_orders_id', 'id' );
    }
}
