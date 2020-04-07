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

    public function statusdate() {
        return $this->hasMany( 'App\Models\StageStatusDate', 'service_stages_id', 'id' );
    }

    public function observeds() {
        return $this->hasMany( 'App\Models\StageObserved', 'service_stages_id', 'id' );
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
        if( $stage ) {

            $tasks = Task::where('service_stages_id', $id)
                ->whereNotIn('status', [0, 2])
                ->groupBy('status')
                ->select('status', DB::raw('count(*) as total'))
                ->pluck('total', 'status')->all();

            $status = 1;
            $total = 0;
            $statusArreglo = [
                1 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0
            ];

            foreach ($tasks as $idx => $task) {
                $statusArreglo[$idx] = $task;
                $total += $task;
            }

            if ($total > 0) {
                if ($statusArreglo[1] === $total) {
                    $status = 1;
                }

                if ($statusArreglo[4] === $total) {
                    $status = 4;
                }

                if ($statusArreglo[6] === $total) {
                    $status = 6;
                }

                if ($statusArreglo[3] > 0) {
                    $status = 3;
                }

                if ($statusArreglo[5] > 0) {
                    $status = 5;
                }
            }

            $countObs = $stage->observeds->where('status', 1)->count();
            if ($countObs > 0) {
                $status = 5;
            }

            StageStatusDate::generateStatus($id, $stage->status, $status);
            $stage->status = $status;
            if( $stage->save() ) {
                Service::setStatus( $stage->services_id );
            }

            return true;
        } else {
            return false;
        }
    }

    public static function generateStageByReference( Referenceterm $ref, $serviceId ) {
        $referenceDetails = $ref->referencetermDetails->where( 'status', 1 );
        foreach( $referenceDetails as $referenceDetail ) {
            $stage = new self();
            $stage->services_id = $serviceId;
            $stage->code = $stage::generateCorrelative( $serviceId );
            $stage->name = Str::substr( $referenceDetail->description, 0, 240 );
            $stage->description = $referenceDetail->description;
            $stage->date_start = date( 'Y-m-d' );
            $stage->date_end = date( 'Y-m-d' );
            $stage->save();
        }

        return true;
    }

    public static function generateCorrelative( $service ) {
        $count = self::where( 'services_id', $service )->count();
        return '#ET' . $service . '-' . ( $count + 1 );
    }

    public function updateCorrelative( $service ) {
        $count = self::where( 'services_id', $service )->where('code', '!=',  '')->count();
        return '#ET' . $service . 'T' . ( $count + 1 );
    }
}
