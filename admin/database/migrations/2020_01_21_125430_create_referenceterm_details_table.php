<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencetermDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referenceterm_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('referenceterms_id');
            $table->text('description');
            $table->tinyInteger('quantity')->default( 0 );
            $table->tinyInteger('status')->default( 1 );
            $table->foreign('referenceterms_id')->references('id')->on('referenceterms');
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
        Schema::dropIfExists('referenceterm_details');
    }
}
