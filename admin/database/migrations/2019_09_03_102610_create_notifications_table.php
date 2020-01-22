<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'notifications';
        Schema::create( $tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->integer('userFrom')->default(0)->index()->comment( 'Id De Usuario que envia la notificación, si esta en 0 es automatico.');
            $table->integer('userTo')->default(0)->index()->comment( 'Id De Usuario que recibe la notificación.');
            $table->integer('customerTo')->default(0)->index()->after('userTo')->comment( 'Id De cliente.');
            $table->dateTime('dateDelivery')->nullable()->comment('Fecha de entrega de la notificación.');
            $table->dateTime('dateSeen')->nullable()->comment('Fecha de visto la notificación.');
            $table->text('message')->comment('Mensaje.');
            $table->string('url', 250)->comment('Link a donde apuntará la notificación');
            $table->integer('customerFrom')->index()->default(0)->after('userTo');
            $table->tinyInteger('direction')->index()->default(0)->after('url')->comment('0: from admin to customer, 1: from customer to admin');
            $table->tinyInteger('status')->default(1)->comment("Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado");
            $table->timestamps();
        });
        $description = "Contiene las notificaciones enviadas a los usuarios.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Notificaciones: \n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
