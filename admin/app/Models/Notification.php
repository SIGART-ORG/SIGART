<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const TABLE_NAME = 'notifications';
    protected $table = self::TABLE_NAME;

    public function relCustomerFrom() {
        return $this->belongsTo( CustomerLogin::class, 'customerFrom', 'id' );
    }

    public function scopeIsNotSeen($query, $status){
        if(!empty($status)){
            $query->whereNull('dateSeen');
        }
    }
}
