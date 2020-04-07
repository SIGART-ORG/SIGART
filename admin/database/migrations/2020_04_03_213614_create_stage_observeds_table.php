<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStageObservedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stage_observeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_stages_id');
            $table->string( 'name', 250 );
            $table->text( 'description' );
            $table->text( 'reply' )->nullable();
            $table->bigInteger( 'user_reply' )->default(0)->index();
            $table->dateTime( 'date_reply' )->nullable();
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
        Schema::dropIfExists('stage_observeds');
    }
}
