<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    protected $table = 'type_documents';
    protected $fillable = ['name', 'status'];
}
