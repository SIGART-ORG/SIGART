<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $table = 'icons';
    protected $fillable = ['name', 'group', 'status'];
}
