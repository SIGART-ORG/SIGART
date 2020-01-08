<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'services';
        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro');
            $table->unsignedBigInteger('service_requests_id')->comment('Id de solicitud de servicio( service_requests ).');
            $table->string('serial_doc', 3)->comment('Serie del servicio.');
            $table->string('number_doc', 6)->comment('Número del servicio.');
            $table->integer('user_reg')->default(0)->index()->comment('Id de usuario que realizó el registro.');
            $table->integer('user_aproved')->default(0)->index()->comment('Id de usuario que aprobó el servicio.');
            $table->integer('is_aproved_customer')->default(0)->index()->comment("Aprobación del servicio por parte del cliente:\n 1:Pendiente de aprobación.\n 2: Aprobado.\n 3: No aprobado.");
            $table->date('date_reg')->comment('Fecha de ingreso de la solicitud.');
            $table->date('date_aproved')->comment('Fecha de aprovación del servicio por la empresa.');
            $table->date('date_aproved_customer')->comment('Fecha de aprovación del servicio por parte del liente..');
            $table->text('description')->comment('Descripción general de la solicitud de servicio.');
            $table->text('observation')->nullable()->comment('Observación sobre la solicitud de servicio.');
            $table->foreign('service_requests_id')->references('id')->on('service_requests');
            $table->timestamps();
        });

        $description = "Contiene los registros de los servicios.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Servicios: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
