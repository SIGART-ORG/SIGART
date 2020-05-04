<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'purchases';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('purchase_orders_id')->comment('Id de la compra.');
            $table->unsignedBigInteger('type_vouchers_id')->comment('Id de tipo de comprobante( type_vouchers ).');
            $table->unsignedBigInteger('type_payment_methods_id')->comment('Id de tipo de método de pago( type_payment_methods ).');
            $table->string( 'serial_doc', 5 )->nullable()->comment('Serie de la compra.');
            $table->string( 'number_doc', 11 )->nullable()->comment('Número de la compra.');
            $table->decimal( 'subtotal', 10, 2)->default(0)->comment('Monto total de la compra sin el IGV.');
            $table->decimal( 'igv', 10, 2)->default(0)->comment('Monto del IGV del total de la compra.');
            $table->decimal( 'total', 10, 2)->default(0)->comment('Monto del total de la compra(inc IGV).');
            $table->date( 'date_issue' )->nullable();
            $table->string( 'pdf', 250 )->nullable()->comment('Pdf generado adjunto enviado en el correo.');
            $table->string( 'attach', 250 )->nullable()->comment('Imagen del comprobante');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente de pago\n 2: Anulado,\n 3: Pagado");
            $table->foreign('purchase_orders_id')->references('id')->on('purchase_orders');
            $table->foreign('type_vouchers_id')->references('id')->on('type_vouchers');
            $table->foreign('type_payment_methods_id')->references('id')->on('type_payment_methods');
            $table->timestamps();
        });

        $description = "Base de datos que contendra las compras";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Orden de compra\n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
