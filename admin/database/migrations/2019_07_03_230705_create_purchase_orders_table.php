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
            $table->integer('sites_id')->unsigned()->comment('Id de la sede.');
            $table->unsignedBigInteger('provider_id')->comment('Id del Proveedor.');
            $table->unsignedBigInteger('quotations_id')->default(0)->index()->comment('Id de la cotización, si es que fuese necesario.');
            $table->integer('user_reg')->default(0)->index()->comment('Usuario que registro la orden de compra');
            $table->integer('user_aproved')->default(0)->index()->comment('Usuario que aprobó la orden de compra');
            $table->string('code', 15)->index()->comment('Código interno de la orden de compra.');
            $table->date('date_reg')->comment('Fecha de registro de la orden de compra');
            $table->decimal( 'subtotal', 10, 2)->default(0)->comment('Monto total de la orden de compra sin el IGV.');
            $table->decimal( 'igv', 10, 2)->default(0)->comment('Monto del IGV del total de la orden compra.');
            $table->decimal( 'total', 10, 2)->default(0)->comment('Monto del total de la orden compra(inc IGV).');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado,\n 3: Aprobado");
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('sites_id')->references('id')->on('sites');
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
