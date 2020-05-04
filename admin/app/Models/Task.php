<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'service_stages_id',
        'code',
        'date_start_prog',
        'name',
        'description',
        'date_end_prog',
        'date_start',
        'date_end',
        'observation',
        'status'
    ];

    public function serviceStage() {
        return $this->belongsTo( 'App\Models\ServiceStage', 'service_stages_id', 'id' );
    }

    public function AssignedWorkers() {
        return $this->hasMany( 'App\Models\AssignedWorker', 'tasks_id', 'id' );
    }

    public function observeds() {
        return $this->hasMany( 'App\Models\TaskObserved', 'tasks_id', 'id' );
    }

    public function getTasks( $stage, $search = '' ) {
        $data = self::where( 'service_stages_id', $stage )
            ->where( 'status', '!=', 2 )
            ->orderBy( 'code', 'asc' )
            ->orderBy( 'date_start_prog', 'asc' )
            ->orderBy( 'date_end_prog', 'asc' )
            ->search( $search )
            ->get();

        return $data;
    }

    public function scopeSearch( $query, $search ) {
        if( ! empty( $search ) ) {
            return $query->where( 'name', '%', $search . '%' );
        }
        return $query;
    }

    public static function generateCorrelative( $stage ) {
        $count = self::where( 'service_stages_id', $stage )->count();
        return '#TAR' . $stage . '-' . ( $count + 1 );
    }

    public function updateCorrelative( $stage ) {
        $count = self::where( 'service_stages_id', $stage )->where('code', '!=',  '')->count();
        return '#TAR' . $stage . '-' . ( $count + 1 );
    }

    public static function updatedAllTasksByStage( $stage, $status ) {
        self::where( 'service_stages_id', $stage )
            ->whereNotIn( 'status', [0,2] )
            ->update(['status' => $status]);
    }
}
