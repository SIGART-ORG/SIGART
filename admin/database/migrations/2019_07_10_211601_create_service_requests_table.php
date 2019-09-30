<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'service_requests';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro.');
            $table->integer('sites_id')->unsigned()->comment('Id de la tabla sede( sites ) .');

            $table->unsignedBigInteger('type_vouchers_id')->comment('Id de la tabla tipo de comprobantes( type_vouchers ).');
            $table->date('date_emission')->comment('Fecha de Emisión');
            $table->string('num_request', 10)->comment('Numero de requerimiento');

            $table->unsignedBigInteger('customers_id')->comment('Id de tabla cliente( customers).');
            $table->integer('user_reg')->default(0)->index()->comment('Id de usuario que realizó el registro.');
            $table->integer('user_aproved')->default(0)->index()->comment('Id de usuario que aprobó la solicitud de servicio.');
            $table->date('date_reg')->comment('Fecha de ingreso de la solicitud.');
            $table->date('date_aproved')->comment('Fecha de aprovación de la solicitud');
            $table->text('description')->comment('Descripción general de la solicitud de servicio.');
            $table->text('observation')->nullable()->comment('Observación sobre la solicitud de servicio.');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente de aprobación\n 2: Eliminado,\n 3: Aprobado,\n 4: Cancelado.");
            $table->foreign('sites_id')->references('id')->on('sites');
            $table->foreign('customers_id')->references('id')->on('customers');
            $table->foreign('type_vouchers_id')->references('id')->on('type_vouchers');
            $table->timestamps();
        });

        $description = "Contiene las solicitudes de servicios ingresados.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Solicitudes de servicios - detalle: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
