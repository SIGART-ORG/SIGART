<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'purchase_orders';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de la orden de compras.');
            $table->unsignedBigInteger('provider_id')->comment('Id del Proveedor.');
            $table->integer('user_reg')->default(0)->index()->comment('Usuario que registro la orden de compra');
            $table->string('code', 6)->unique()->comment('Código interno de la orden de compra.');
            $table->date('date_reg')->comment('Fecha de registro de la orden de compra');
            $table->decimal( 'subtotal', 10, 2)->default(0)->comment('Monto total de la orden de compra sin el IGV.');
            $table->decimal( 'igv', 10, 2)->default(0)->comment('Monto del IGV del total de la compra.');
            $table->decimal( 'total', 10, 2)->default(0)->comment('Monto del total de la compra(inc IGV).');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado");
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->timestamps();
        });

        $description = "Base de datos que contendra los registros de la ordenes de compras";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Orden de compra\n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
