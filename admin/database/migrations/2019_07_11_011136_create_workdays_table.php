<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'workdays';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('assigned_workers_id')->comment('Id de la tabla trabajadores asigandos( assigned_workers ).');
            $table->dateTime('day')->comment( 'Día.');
            $table->text('description')->comment("Descripción.");
            $table->integer('status')->default(0)->comment("Registro de estado:\n0: Desactivado.\n1: Activo.\n2: Eliminado.");
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
        Schema::dropIfExists('workdays');
    }
}
