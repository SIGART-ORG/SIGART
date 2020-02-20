<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'sales';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('services_id')->comment('Id de la tabla servicio( services ).');
            $table->unsignedBigInteger('type_vouchers_id')->comment('Id de tipo de comprobante( type_vouchers ).');
            $table->unsignedBigInteger('type_payment_methods_id')->comment('Id de tipo de método de pago( type_payment_methods ).');
            $table->string('serial_doc', 10)->comment('Serie de la venta.');
            $table->string('number_doc', 10)->comment('Número de la venta.');
            $table->decimal( 'subtotal', 10, 2)->default(0)->comment('Monto total de la venta sin el IGV.');
            $table->decimal( 'igv', 10, 2)->default(0)->comment('Monto del IGV del total de la venta.');
            $table->decimal( 'total', 10, 2)->default(0)->comment('Monto del total de la venta(inc IGV).');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente de pago\n 2: Anulado,\n 3: Pagado");
            $table->foreign('services_id')->references('id')->on('services');
            $table->foreign('type_vouchers_id')->references('id')->on('type_vouchers');
            $table->foreign('type_payment_methods_id')->references('id')->on('type_payment_methods');
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
        Schema::dropIfExists('sales');
    }
}
