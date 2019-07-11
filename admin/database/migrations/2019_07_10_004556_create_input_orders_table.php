<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'input_orders';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registo de orden de entrada.');
            $table->unsignedBigInteger('purchases_id')->comment('Id de la orden de compra ( Purchase_orders ).');
            $table->string('code', 15)->comment('Código interno de la orden de entrada');
            $table->date('date_input_reg')->comment('Fecha de emisión de la orden de entrada.');
            $table->integer('user_reg')->default(0)->index()->comment('Id de usuario que ingreso el registro.');
            $table->date('date_input')->comment('Fecha que se entraron los productos al almacen.');
            $table->integer('user_input')->default(0)->index()->comment('Id del almacenero que recibe los productos.');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Generado\n 2: Anulado,\n 3: Entregado");
            $table->foreign('purchases_id')->references('id')->on('purchases');
            $table->timestamps();
        });

        $description = "Contiene los datos de las ordenes de entrada";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Orden de entrada - detalle: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_orders');
    }
}
