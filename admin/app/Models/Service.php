<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'service_requests_id',
        'serial_doc',
        'number_doc',
        'user_reg',
        'user_aproved',
        'is_aproved_customer',
        'date_reg',
        'date_aproved',
        'date_aproved_customer',
        'description',
        'observation'
    ];

    const paginate = 20;

    public function serviceDetails() {
        return $this->hasMany( 'App\Models\ServiceDetail', 'services_id', 'id' );
    }

    public function serviceRequest() {
        return $this->belongsTo( 'App\Models\ServiceRequest', 'service_requests_id', 'id' );
    }

    public function serviceLogs() {
        return $this->hasMany( 'App\Models\ServiceLog', 'services_id', 'id' );
    }

    public function stages() {
        return $this->hasMany( 'App\Models\ServiceStage', 'services_id', 'id' );
    }

    public function sales() {
        return $this->hasMany( 'App\Models\Sale', 'services_id', 'id' );
    }

    public static function getAll( $search ) {
        $data = self::where( 'status', '!=', 2 )
            ->search( $search )
            ->orderBy( 'date_reg', 'desc' )
            ->paginate( self::paginate );
        return $data;
    }

    public function scopeSearch( $query, $search ) {
        if( ! empty( $search ) ) {
            return $query->where( function( $query ) use( $search ) {
                $query->where( 'serial_doc', 'like', '%' . $search . '%' )
                    ->orWhere( 'number_doc', 'like', '%' . $search . '%' );
            });
        }
    }
}
