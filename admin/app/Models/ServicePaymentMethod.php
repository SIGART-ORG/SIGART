<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePaymentMethod extends Model
{
    const TABLE_NAME = 'service_payment_methods';

    protected $table = self::TABLE_NAME;
}
