<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'purchase_request';
        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->integer('sites_id')->unsigned()->comment('Id de la sede.');
            $table->integer('user_reg')->default(0)->index();
            $table->string('code', 50 );
            $table->date('date');
            $table->text( 'attachment' )->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreign('sites_id')->references('id')->on('sites');
            $table->timestamps();
        });

        $description = "Contendra las solicitudes de compras generadas.";
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Solicitud de compra\n {$description}'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_request');
    }
}
