<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedWorker extends Model
{
    protected $table = 'assigned_workers';

    protected $fillable = [
        'tasks_id',
        'users_id',
        'user_in_charge',
        'status'
    ];

    public function task() {
        return $this->belongsTo( 'App\Models\Task', 'tasks_id', 'id' );
    }

    public function user() {
        return $this->belongsTo( 'App\User', 'users_id', 'id' );
    }
}
