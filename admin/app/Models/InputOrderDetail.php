<?php

namespace App\Models;

use App\Presentation;
use Illuminate\Database\Eloquent\Model;

class InputOrderDetail extends Model
{
    const TABLE_NAME = 'input_order_details';
    protected $table = self::TABLE_NAME;

    public function presentation() {
        return $this->belongsTo( Presentation::class, 'presentation_id', 'id' );
    }

    public function inputOrder() {
        return $this->belongsTo( InputOrder::class, 'input_orders_id', 'id' );
    }
}
