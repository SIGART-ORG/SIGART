<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencetermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referenceterms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_quotations_id');
            $table->unsignedBigInteger('customers_id');
            $table->string( 'area', 250 )->comment( 'AREA RESPONSABLE:' );
            $table->string( 'activity', 250 )->comment( 'ACTIVIDAD' );
            $table->text( 'objective' )->comment( 'OBJETIVO DEL SERVICIO' );
            $table->string( 'specialized_area', 250 )->comment('AREA USUARIA Y/O ESPECIALIZADA' );
            $table->tinyInteger('execution_time_days')->default( 1 )->comment( 'PLAZO DE EJECUCIÓN DEL SERVICIO EN DÍAS');
            $table->text('execution_time_text')->comment( 'PLAZO DE EJECUCIÓN DEL SERVICIO EN TEXTO');
            $table->string( 'execution_address', 250 )->comment( 'LUGAR DE PRESTACIÓN DEL SERVICIO' );
            $table->char('district_id', 6)->default(0)->index();
            $table->text( 'address_reference' )->nullable()->comment('REFERENCIA DEL LUGAR DE PRESTACIÓN DEL SERVICIO');
            $table->text( 'method_payment' )->comment('FORMA DE PAGO');
            $table->text( 'conformance_grant' )->comment('OTORGAMIENTO DE LA CONFORMIDAD DEL SERVICIO');
            $table->tinyInteger( 'warranty_num' )->default(0)->comment('GARANTÍA DEL SERVICIO - NÚMERO DE MESES');
            $table->text( 'warranty_text' )->comment('GARANTÍA DEL SERVICIO - TEXT');
            $table->text( 'obervations' )->nullable()->comment('OBSERVACIONES');
            $table->string( 'users_id_reg' )->default(0)->index();
            $table->string( 'pdf' )->nullable();
            $table->tinyInteger( 'status' )->default(1);
            $table->foreign('sales_quotations_id')->references('id')->on('sales_quotations');
            $table->foreign('customers_id')->references('id')->on('customers');
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
        Schema::dropIfExists('referenceterms');
    }
}
