<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('output_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('presentation_id')->comment('Id de la tabla presentaciones ( Presentation ).');
            $table->decimal( 'price_unit', 10,2 )->default(0);
            $table->decimal( 'quantity', 10,2 )->default(0);
            $table->decimal( 'subTotal', 10, 2 )->default(0);
            $table->tinyInteger( 'is_delivered' )->default( 0 );
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign('presentation_id')->references('id')->on('presentation');
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
        Schema::dropIfExists('output_order_details');
    }
}
