<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValueServReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'value_serv_reqs';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('service_request_details_id')->comment('Id de la tabla detalle de solicitud de servicio( service_request_details ).');
            $table->unsignedBigInteger('parameters_id')->comment('Id de la tabla parametros( parameters ).');
            $table->string('value', 5)->comment('Valor asignado.');
            $table->integer('status')->default(0)->comment("Estado del registro: \n 0: Desactivado.\n 1: Activado.\n 2: Eliminado.");
            $table->foreign('service_request_details_id')->references('id')->on('service_request_details');
            $table->foreign('parameters_id')->references('id')->on('parameters');
            $table->timestamps();
        });
        $description = "Contiene los valores de los parametros de los items de la solicitud de servicio.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Valores de parametros: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('value_serv_reqs');
    }
}
