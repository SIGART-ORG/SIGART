<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    const TABLE_NAME = 'stocks';

    protected $table = self::TABLE_NAME;

    public function presentation() {
        return $this->belongsTo( 'App\Presentation', 'presentation_id', 'id');
    }

    public function site() {
        return $this->belongsTo( 'App\Site', 'sites_id', 'id');
    }
}
