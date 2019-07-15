<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'tasks';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro');
            $table->unsignedBigInteger('service_stages_id')->comment('Id de la tabla etapas del servicio( service_stages ).');
            $table->dateTime('date_start_prog')->comment('Fecha de inicio programado de la tarea');
            $table->string('name', 20)->comment('Nombre de la tarea.');
            $table->text('description')->comment('Descrición de la tarea.');
            $table->dateTime('date_end_prog')->comment('Fecha de culminación programado de la tarea.');
            $table->dateTime('date_start')->comment('Fecha de inicio de la tarea');
            $table->dateTime('date_end')->comment('Fecha de culminación de la tarea.');
            $table->text('observation')->comment('Registro de observaciones generados al realizar la tarea.');
            $table->integer('status')->default(1)->comment("Registro de estado:\n0: Desactivado.\n1: Activo.\n2:Eliminado.\n3:En proceso.\n4: Terminado.\n5: Cerrado");
            $table->foreign('service_stages_id')->references('id')->on('service_stages');
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
        Schema::dropIfExists('tasks');
    }
}
