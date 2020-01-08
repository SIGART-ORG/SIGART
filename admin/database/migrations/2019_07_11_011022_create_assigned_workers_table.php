<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignedWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'assigned_workers';
        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id registro.');
            $table->unsignedBigInteger('tasks_id')->comment('Id de la tabla tareas( task ).');
            $table->unsignedBigInteger('users_id')->comment('Id de la tabla usuarios( users ).');
            $table->enum('user_in_charge', [0, 1])->comment('Registro para identificar si el usuario es responsable de la tarea asignada.');
            $table->integer('status')->default(1)->comment("Registro de estado:\n0: Desactivado.\n1: Activo.\n2: Eliminado.");
            $table->foreign('tasks_id')->references('id')->on('tasks');
            $table->foreign('users_id')->references('id')->on('users');
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
        Schema::dropIfExists('assigned_workers');
    }
}
