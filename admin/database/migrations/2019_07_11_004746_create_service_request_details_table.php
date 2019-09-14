<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'service_request_details';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('service_requests_id')->comment('Id de solicitud de servicio( service_requests ).');
            $table->string('name', 20)->comment('Nombre del item de la solicitud de servicio.');
            $table->integer('quantity')->default(0)->comment('Cantidad del item de la solicitud de servicio.');
            $table->text('description')->nullable()->comment('Descripción(opcional) del item de la solicitud de servicio.');
            $table->integer('assumed_customer')->comment("Registro para identificar si los materiales necesarios seran sumados en la cotización.\n0: Se considera.\n1: No se considera.");
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado.\n 1: Activado.\n 2: Eliminado.");
            $table->foreign('service_requests_id')->references('id')->on('service_requests');
            $table->timestamps();
        });
        $description = "Contiene los detalles de la solicitud de servicio.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Solicitudes de servicios - detalle: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_request_details');
    }
}
