<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskObserved extends Model
{
    const TABLE_NAME = 'task_observeds';
    protected $table = self::TABLE_NAME;

    public function task() {
        return $this->belongsTo( 'App\Models\Task', 'tasks_id', 'id' );
    }
}
