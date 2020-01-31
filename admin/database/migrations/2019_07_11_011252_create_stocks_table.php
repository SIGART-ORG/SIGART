<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'stocks';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->integer('sites_id')->unsigned()->comment('Id de la tabla sede( sites ) .');
            $table->unsignedBigInteger('presentation_id')->comment('Id de la tabla presentaciones ( Presentation ).');
            $table->integer('stock')->default(0)->comment('Stock actual del producto.');
            $table->decimal('price', 10, 2)->default(0)->comment('Precio referencial del producto');
            $table->decimal( 'price_buy', 10, 2 )->default(0)->comment( 'El monto por defecto es al 5% del precio de la compra.');
            $table->foreign('sites_id')->references('id')->on('sites');
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
        Schema::dropIfExists('stocks');
    }
}
