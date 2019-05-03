<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $table = 'presentation';
    protected $fillable = [
        'products_id',
        'unity_id',
        'description',
        'equivalence',
        'status'
    ];
}
