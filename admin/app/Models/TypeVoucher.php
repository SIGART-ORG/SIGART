<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeVoucher extends Model
{
    const TABLE_NAME = 'type_vouchers';

    protected $table = self::TABLE_NAME;

    public function siteVouchers() {
        return $this->hasMany( 'App\Models\SiteVourcher', 'type_vouchers_id', 'id' );
    }
}
