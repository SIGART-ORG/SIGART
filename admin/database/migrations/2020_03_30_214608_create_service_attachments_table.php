<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('services_id')->comment('Id de la tabla servicio( services ).');
            $table->string( 'name', 250 );
            $table->text( 'file' );
            $table->tinyInteger( 'type' )->default(0);
            $table->tinyInteger( 'is_valid' )->default( 0 );
            $table->bigInteger( 'user_valid' )->index()->default(0);
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign('services_id')->references('id')->on('services');
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
        Schema::dropIfExists('service_attachments');
    }
}
