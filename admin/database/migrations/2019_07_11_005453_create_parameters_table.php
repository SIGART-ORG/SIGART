<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'parameters';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('type_services_id')->comment('Id de tipo de servicio( type_services ).');
            $table->string('name', 50)->comment('Nombre del parametro.');
            $table->integer('status')->default(0)->comment("Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado.");
            $table->foreign('type_services_id')->references('id')->on('type_services');
            $table->timestamps();
        });

        $description = "Contiene los registros de los parametros por tipo de servicio.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Parametros: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}
