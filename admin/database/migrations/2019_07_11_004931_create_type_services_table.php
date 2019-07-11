<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'type_services';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Id registro.');
            $table->string('name', 60)->comment('Nombre del servicio');
            $table->integer('status')->default(0)->comment("Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado.");
            $table->timestamps();
        });

        $description = "Contiene los registros de todos los servicios que se ofrecen.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Tipos de servicios: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_services');
    }
}
