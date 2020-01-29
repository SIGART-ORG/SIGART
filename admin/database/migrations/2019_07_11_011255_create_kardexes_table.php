<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'kardexes';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('id de registro.');
            $table->unsignedBigInteger('stocks_id')->comment('Id de la tabla stocks ( stocks ).');
            $table->bigInteger('input_orders_id')->default(0)->index()->comment('Id de la tabla orden de entrada( input_orders ).');
            $table->bigInteger('output_orders_id')->default(0)->index()->comment('Id de la tabla orden de salida( output_orders ).');
            $table->integer('quantity_input')->default(0)->comment('Cantidad de entrada.');
            $table->integer('quantity_output')->default(0)->comment('Cantidad de salida.');
            $table->integer('total')->default(0)->comment('Total.');
            $table->decimal('last_price_unit',10, 2)->default(0)->comment('Ultimo precio unitario de producto.');
            $table->decimal('price_unit',10, 2)->default(0)->comment('Precio unitario de producto.');
            $table->decimal('price_total')->default(0)->comment('Precio total del producto( PU * cantidad ).');
            $table->decimal('last_price_unit_purchase', 10, 2)->default(0)->comment('Último precio unitario de compra');
            $table->decimal('price_unit_purchase', 10, 2)->default(0)->comment('Precio unitario de compra');
            $table->decimal('price_total_purchase', 10, 2)->default(0)->comment('Valor total de la compra');
            $table->decimal( 'price_buy', 10,2)->default(0)->comment( 'Precio de compra en ese momento');
            $table->foreign('stocks_id')->references('id')->on('stocks');
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
        Schema::dropIfExists('kardexes');
    }
}
