<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger( 'services_id' );
            $table->string( 'name', 250 )->nullable();
            $table->tinyInteger( 'stage' )->default( 0 );
            $table->bigInteger( 'user_valid' )->index()->default( 0 );
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign( 'services_id' )->references( 'id' )->on( 'services' );
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
        Schema::dropIfExists('service_requirements');
    }
}
