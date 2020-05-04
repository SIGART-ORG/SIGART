<?php

namespace App\Models;

use App\Presentation;
use Illuminate\Database\Eloquent\Model;

class OutputOrderDetails extends Model
{
    const TABLE_NAME = 'output_order_details';
    protected $table =  self::TABLE_NAME;

    public function presentation() {
        return $this->belongsTo( Presentation::class, 'presentation_id', 'id' );
    }
}
