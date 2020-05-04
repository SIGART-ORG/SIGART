<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    const TABLE_NAME = 'presentation';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'products_id',
        'unity_id',
        'description',
        'equivalence',
        'status'
    ];

    public function stocks() {
        return $this->hasMany( 'App\Models\ToolStock', 'presentation_id', 'id');
    }
}
