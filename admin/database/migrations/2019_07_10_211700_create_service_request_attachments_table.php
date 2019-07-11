<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'service_request_attachments';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('service_requests_id')->comment('Id de solicitud de servicio( service_requests ).');
            $table->string('file_name', 100)->comment('Nombre del archivo adjunto');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado");
            $table->foreign('service_requests_id')->references('id')->on('service_requests');
            $table->timestamps();
        });

        $description = "Contiene los archivos adjuntos en la solicitud de servicio.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Solicitudes de servicios - adjunto: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_request_attachments');
    }
}
