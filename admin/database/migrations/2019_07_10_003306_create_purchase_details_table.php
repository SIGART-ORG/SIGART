<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'purchase_details';
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('purchases_id')->comment('Id de la tabla compras ( Purchases ).');
            $table->unsignedBigInteger('presentation_id')->comment('Id de la tabla presentaciones ( Presentation ).');
            $table->integer('quantity')->default(0)->comment('Cantidad del producto solicitado.');
            $table->decimal('price_unit', 10, 2)->default(0)->comment('Precio unitario del producto.');
            $table->decimal('sub_total', 10, 2)->default(0)->comment('Precio de la cantidad por precio unitario del producto.');
            $table->decimal('igv', 10, 2)->default(0)->comment('Monto del IGV(18%)');
            $table->decimal('total', 10, 2)->default(0)->comment('Sumatoria del IGV mas el sub total.');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado");
            $table->foreign('purchases_id')->references('id')->on('purchases');
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
        Schema::dropIfExists('purchase_details');
    }
}
