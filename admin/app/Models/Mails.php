<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    protected $table = 'mails';
    protected $fillable = ['from', 'to', 'subject', 'body', 'dateSend', 'status'];

    public function scopeSearch( $query, $search ) {
        if( ! empty( $search ) ) {
            return $query->where(function ($q) use ($search) {
                $q->where( 'subject', 'like', '%' . $search . '%' )
                    ->orWhere( 'to', 'like', '%' . $search . '%' )
                    ->orWhere( 'from', 'like', '%' . $search . '%' );
            });
        }
    }
}
