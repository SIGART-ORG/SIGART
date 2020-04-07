<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StageObserved extends Model
{
    const TABLE_NAME = 'stage_observeds';
    protected $table = self::TABLE_NAME;

    public function serviceStage() {
        return $this->belongsTo( 'App\Models\ServiceStage', 'service_stages_id', 'id' );
    }
}
