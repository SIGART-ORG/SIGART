<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAttachment extends Model
{
    const TABLE_NAME = 'service_attachments';
    protected $table = self::TABLE_NAME;

    public function user() {
        return $this->belongsTo( 'App\User', 'user_valid', 'id' );
    }

    public function service() {
        return $this->belongsTo( 'App\Models\Service', 'services_id', 'id' );
    }
}
