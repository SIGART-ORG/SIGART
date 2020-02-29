<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'purchase_order_details';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro de detalle de orden de compra.');
            $table->unsignedBigInteger('purchase_orders_id')->comment('Id de la orden de compra ( Purchase_orders ).');
            $table->unsignedBigInteger('presentation_id')->comment('Id de la tabla presentaciones (presentation).');
            $table->integer('quantity')->default(0)->comment('Cantidad del producto solicitado.');
            $table->decimal('price_unit', 10, 2)->default(0)->comment('Precio unitario del producto.');
            $table->decimal('sub_total', 10, 2)->default(0)->comment('Precio de la cantidad por precio unitario del producto.');
            $table->decimal('igv', 10, 2)->default(0)->comment('Monto del IGV(18%)');
            $table->decimal('total', 10, 2)->default(0)->comment('Sumatoria del IGV mas el sub total.');
            $table->tinyInteger( 'is_confirmed' )->default(0)->comment('0: default, 1: producto entro a almacen');
            $table->tinyInteger('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado");
            $table->foreign('purchase_orders_id')->references('id')->on('purchase_orders');
            $table->foreign('presentation_id')->references('id')->on('presentation');
            $table->timestamps();
        });

        $description = "Base de datos que contendra los items de la ordenes de compras";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Orden de compra - detalle: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_details');
    }
}
