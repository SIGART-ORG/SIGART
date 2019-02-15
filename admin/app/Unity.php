<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    protected $table = 'unity';
    protected $fillable = ['name', 'equivalence', 'root', 'status'];
}
