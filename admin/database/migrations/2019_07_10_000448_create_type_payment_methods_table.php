<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'type_payment_methods';
        Schema::create('type_payment_methods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id del registro del tipo de método de pago.');
            $table->string('name', 30)->comment('Nombre del tipo del método de pago.');
            $table->integer('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado");
            $table->timestamps();
        });

        $description = "Tabla que contendra los registros de tipos de métodos de pago.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Tipo de método de pago.\n {$description}'");

        $insert = [
            [
                'name' => 'Efectivo',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Depósito bancario',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table( $tableName )->insert( $insert );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_payment_methods');
    }
}
