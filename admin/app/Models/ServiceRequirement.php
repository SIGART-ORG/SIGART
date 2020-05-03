<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequirement extends Model
{
    const TABLE_NAME = 'service_requirements';
    protected $table = self::TABLE_NAME;

    public function service() {
        return $this->belongsTo( Service::class,  'services_id', 'id' );
    }

    public function serviceRequirementDetails() {
        return $this->hasMany( ServiceRequirementDetail::class, 'service_requirements_id', 'id' );
    }
}
