<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('input_orders_id')->nullable();
            $table->unsignedBigInteger('presentation_id')->comment('Id de la tabla presentaciones ( Presentation ).');
            $table->decimal( 'price_unit', 10,2 )->default(0);
            $table->decimal( 'quantity', 10,2 )->default(0);
            $table->decimal( 'subTotal', 10, 2 )->default(0);
            $table->tinyInteger( 'is_delivered' )->default( 0 );
            $table->text( 'comment' )->nullable();
            $table->tinyInteger( 'status' )->default( 1 );
            $table->foreign('presentation_id')->references('id')->on('presentation');
            $table->foreign( 'input_orders_id' )->references( 'id' )->on( 'input_orders' );
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
        Schema::dropIfExists('input_order_details');
    }
}
