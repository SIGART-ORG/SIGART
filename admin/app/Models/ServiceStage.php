<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Str;

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

    public static function setStateStage( $id ) {
        $stage = self::find( $id );

        $tasks = Task::where( 'service_stages_id', $id )
            ->whereNotIn( 'status', [0,2] )
            ->groupBy( 'status' )
            ->select( 'status', DB::raw('count(*) as total'))
            ->pluck('total','status')->all();

        $status = 1;
        $statusArreglo = [
            1 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0
        ];

        foreach ( $tasks as $idx => $task ) {
            $statusArreglo[$idx] = $task;
        }

        if( $statusArreglo[3] > 0 || $statusArreglo[4] > 0 || $statusArreglo[5] > 0 ) {
            $status = 3;
        }

        if( $statusArreglo[6] > 0 && ( $statusArreglo[3] === 0 && $statusArreglo[4] === 0 && $statusArreglo[5] === 0 ) ) {
            $status = 4;
        }

        $stage->status = $status;
        if( $stage->save() ) {
            Service::setStatus( $stage->services_id );
        }

        return true;
    }

    public static function generateStageByReference( Referenceterm $ref, $serviceId ) {
        $referenceDetails = $ref->referencetermDetails->where( 'status', 1 );
        foreach( $referenceDetails as $referenceDetail ) {
            $stage = new self();
            $stage->services_id = $serviceId;
            $stage->name = Str::substr( $referenceDetail->description, 0, 240 );
            $stage->description = $referenceDetail->description;
            $stage->date_start = date( 'Y-m-d' );
            $stage->date_end = date( 'Y-m-d' );
            $stage->save();
        }

        return true;
    }
}
