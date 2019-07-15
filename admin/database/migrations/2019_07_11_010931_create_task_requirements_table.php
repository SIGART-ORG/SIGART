<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'task_requirements';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('tasks_id')->comment('Id de la tabla tareas( tasks ).');
            $table->unsignedBigInteger('presentation_id')->comment('Id de la tabla presentaciones ( Presentation ).');
            $table->integer('quantity')->comment('Cantidad de producto.');
            $table->integer('assumed_customer')->comment("Registro para identificar si el materiales necesarios los traera el cliente.\n0: El Cliente los traera.\n1: Se retirará del almacen.");
            $table->decimal('price', 10, 2)->comment("Costo del material utilizado.");
            $table->integer('status')->default(1)->comment("Registro de estado:\n0: Desactivado.\n1: Activo.\n2: Eliminado.");
            $table->foreign('tasks_id')->references('id')->on('tasks');
            $table->foreign('presentation_id')->references('id')->on('presentation');
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
        Schema::dropIfExists('task_requests');
    }
}
