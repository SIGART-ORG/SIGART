<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->string('from', 100)->nullable()->comment('Correo remitente');
            $table->string('to', 100)->comment('Correo receptor');
            $table->string('subject', 150)->comment('Asunto del correo');
            $table->text('body')->comment('Contenido Html del correo enviado.');
            $table->dateTime('dateSend')->nullable()->comment('Fecha de envio de correo');
            $table->string( 'attach', 250 )->nullable()->comment('Archivo adjunto enviado en el correo.');
            $table->tinyInteger('status')->default(0)->comment('0: Pendiente; 1: Enviado; 2: Eliminado');
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
        Schema::dropIfExists('mails');
    }
}
