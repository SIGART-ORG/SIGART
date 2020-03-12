<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    const TABLE_NAME = 'purchases';
    protected $table = self::TABLE_NAME;

    public function typeVoucher() {
        return $this->belongsTo( 'App\Models\TypeVoucher', 'type_vouchers_id', 'id' );
    }

    public function purchaseOrder() {
        return $this->belongsTo( 'App\PurchaseOrder', 'purchase_orders_id', 'id' );
    }
}
