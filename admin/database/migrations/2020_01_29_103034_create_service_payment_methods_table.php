<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string( 'title', 50 );
            $table->text( 'description' );
            $table->timestamps();
        });

        $insert = [
            [
                'title' => '50 / 50',
                'description' => 'Con depósito del 50% al inicio y 50% al finalizar el servicio, previa presentación del comprobante de pago.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('service_payment_methods')->insert( $insert );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_payment_methods');
    }
}
