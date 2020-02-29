<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsToSalesQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_quotations', function (Blueprint $table) {
            $table->string( 'activity', 250 )->comment( 'ACTIVIDAD' );
            $table->text( 'objective' )->comment( 'OBJETIVO DEL SERVICIO' );
            $table->tinyInteger('execution_time_days')->default( 1 )->comment( 'PLAZO DE EJECUCIÓN DEL SERVICIO EN DÍAS');
            $table->unsignedBigInteger('service_payment_methods_id');
            $table->tinyInteger( 'warranty_num' )->default(0)->comment('GARANTÍA DEL SERVICIO - NÚMERO DE MESES');
            $table->foreign('service_payment_methods_id')->references('id')->on('service_payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_quotations', function (Blueprint $table) {
            //
        });
    }
}
