<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'user_sites';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->unsignedBigInteger('users_id')->comment('Id de la tabla usuarios( users ).');
            $table->integer('roles_id')->unsigned()->comment('Id de la tabla Tipos de usuario ( roles )');
            $table->integer('sites_id')->unsigned()->comment('Id de la tabla Sedes ( sites )');
            $table->enum('default', [0, 1])->comment('Indicador para tomar en cuenta a la hora que se inicie sesión el ususario.');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado");
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->foreign('sites_id')->references('id')->on('sites');
            $table->timestamps();
        });

        $description = "Contiene los role por sede de los usuarios.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Usuarios - Sede: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sites');
    }
}
