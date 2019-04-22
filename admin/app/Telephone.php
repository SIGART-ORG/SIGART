<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $table = 'telephones';
    protected $fillable = ['number', 'type_telephone_id', 'providers_id', 'customers_id', 'predetermined', 'status'];
}
