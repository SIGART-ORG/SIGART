<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceStage extends Model
{
    protected $table = 'service_stages';
    protected $fillable = [
        'services_id',
        'name',
        'date_start',
        'date_end',
        'type',
        'status'
    ];

    const paginate = 20;

    public function service() {
        return $this->belongsTo( 'App\Models\Service', 'services_id', 'id' );
    }

    public function tasks() {
        return $this->hasMany( 'App\Models\Task', 'service_stages_id', 'id' );
    }

    public function getStages( $service, $search ) {
        $data = self::where( 'status', '!=', 2 )
            ->where( 'services_id', $service )
            ->search( $search )
            ->orderBy( 'date_start', 'asc' )
            ->orderBy( 'date_end', 'asc' )
            ->select()
            ->get( $search );
        return $data;
    }

    public function scopeSearch( $query, $search ) {
        if( ! empty( $search ) ) {
            return $query->where( 'name', 'like', '%' . $search . '%' );
        }
    }
}
