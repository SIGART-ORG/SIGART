<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequirementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requirement_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger( 'service_requirements_id' );
            $table->unsignedBigInteger( 'presentation_id' );
            $table->tinyInteger( 'quantity' )->default( 0 );
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign( 'service_requirements_id' )->references( 'id' )->on( 'service_requirements' );
            $table->foreign( 'presentation_id' )->references( 'id' )->on( 'presentation' );
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
        Schema::dropIfExists('service_requirement_details');
    }
}
