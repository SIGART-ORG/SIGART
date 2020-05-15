<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputOrder extends Model
{
    protected $table = 'input_orders';
    protected $fillable = [
        'purchases_id',
        'code',
        'date_input_reg',
        'user_reg',
        'date_input',
        'user_input',
        'status'
    ];

    public function purchase() {
        return $this->belongsTo( Purchase::class, 'purchases_id', 'id' );
    }
}
