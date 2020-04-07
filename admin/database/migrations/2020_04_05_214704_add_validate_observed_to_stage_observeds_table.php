<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidateObservedToStageObservedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stage_observeds', function (Blueprint $table) {
            $table->tinyInteger( 'is_validate_reply' )->default( 0 );
            $table->dateTime( 'validate_date' )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stage_observeds', function (Blueprint $table) {
            //
        });
    }
}
