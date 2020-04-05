<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservedAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observed_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('stage_observeds_id');
            $table->string( 'name', 250 );
            $table->text( 'file' );
            $table->tinyInteger( 'type' )->default(0);
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign('stage_observeds_id')->references('id')->on('stage_observeds');
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
        Schema::dropIfExists('observed_attachments');
    }
}
