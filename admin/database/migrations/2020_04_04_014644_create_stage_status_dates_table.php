<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStageStatusDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stage_status_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_stages_id');
            $table->tinyInteger( 'stage_status' )->index();
            $table->dateTime( 'register' );
            $table->tinyInteger(  'type' )->default( 0 );
            $table->bigInteger( 'user_reg' )->index();
            $table->text( 'comment' )->nullable();
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign('service_stages_id')->references('id')->on('service_stages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stage_status_dates');
    }
}
