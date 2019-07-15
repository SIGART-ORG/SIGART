<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'output_orders';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro');
            $table->unsignedBigInteger('sales_id')->comment('Id de la tabla venta( sales ).');
            $table->string('code', 15)->comment('Código interno de la orden de salida');
            $table->date('date_input_reg')->comment('Fecha de emisión de la orden de salida.');
            $table->integer('user_reg')->default(0)->index()->comment('Id de usuario que ingreso el registro.');
            $table->date('date_output')->comment('Fecha que se entraron los productos al almacen.');
            $table->integer('user_input')->default(0)->index()->comment('Id del almacenero que entrega los productos.');
            $table->integer('user_output')->default(0)->index()->comment('Id de trabajador que recibe los productos.');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Generado\n 2: Anulado,\n 3: Entregado");
            $table->foreign('sales_id')->references('id')->on('sales');
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
        Schema::dropIfExists('output_orders');
    }
}
