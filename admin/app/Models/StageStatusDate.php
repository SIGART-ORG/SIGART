<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StageStatusDate extends Model
{
    const TABLE_NAME = 'stage_status_dates';
    protected $table = self::TABLE_NAME;

    public function serviceStage() {
        return $this->belongsTo( 'App\Models\ServiceStage', 'service_stages_id', 'id' );
    }

    public static function generateStatus( $stage, $statusCurrent, $newstatus ) {

        $lastStatus = self::where( 'service_stages_id', $stage )
            ->where( 'status', 1 )->orderBy( 'register', 'desc' )->orderBy( 'id', 'desc' )
            ->first();

        if( $lastStatus ) {
            if( $statusCurrent !== $newstatus ) {
                $lastType = $lastStatus->type;
                if ($lastType !== 0 && $lastType !== 3) {
                    $closeType = $lastType === 1 ? 2 : 1;
                    self::registerStatus($stage, $lastStatus->stage_status, $closeType);
                    sleep(1);
                    self::registerStatus($stage, $newstatus, 1);
                }
            }
        } else {
            self::registerStatus( $stage, $statusCurrent, 0, 'Primer movimiento de etapa.' );
            sleep(1);
            self::registerStatus( $stage, $newstatus, 1 );
        }
        return true;
    }

    private static function registerStatus( $stage, $status, $type, $comment = '' ) {
        $user = Auth::user();

        $newStatus = new self();
        $newStatus->service_stages_id = $stage;
        $newStatus->stage_status = $status;
        $newStatus->register = date( 'Y-m-d H:i:s' );
        $newStatus->type = $type;
        $newStatus->user_reg = $user->id;
        $newStatus->comment = $comment;
        $newStatus->save();

        return true;
    }
}
