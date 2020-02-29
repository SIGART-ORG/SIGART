<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferencetermDetail extends Model
{
    const TABLE_NAME = 'referenceterm_details';

    protected $table = self::TABLE_NAME;

    public function referenceterm() {
        return $this->belongsTo( 'App\Models\Referenceterm', 'referenceterms_id' );
    }
}
