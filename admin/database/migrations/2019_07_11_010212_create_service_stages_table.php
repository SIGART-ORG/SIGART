<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'service_stages';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro');
            $table->unsignedBigInteger('services_id')->comment('Id de la tabla servicio( services ).');
            $table->string('name', 20)->comment('Nombre de la etapa del servicio.');
            $table->date('date_start')->comment('Fecha de inicio de la etapa.');
            $table->date('date_end')->comment('Fecha de culminación de la etapa.');
            $table->integer('type')->default(0)->comment("Registro para identificar si la etapa se planifico o no al iniciar el servicio.\n0: Planificado.\n1: Ajuste.");
            $table->integer('status')->default(1)->comment("Registro de estado:\n0: Desactivado.\n1: Activo.\n2:Eliminado.\n3:En proceso.\n4: Terminado.\n5: Cerrado");
            $table->foreign('services_id')->references('id')->on('services');
            $table->timestamps();
        });
        $description = "Contiene las etapas del servicio.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Etapas de servicio: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_stages');
    }
}
