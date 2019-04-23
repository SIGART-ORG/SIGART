<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $fillable = ['name', 'departament_id', 'province_id'];
}
