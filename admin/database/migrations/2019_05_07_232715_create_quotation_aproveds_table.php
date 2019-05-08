<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationAprovedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'quotation_aproveds';
        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_request_id');
            $table->unsignedBigInteger('providers_id');
            $table->integer('user_reg')->default(0)->index();
            $table->integer('status')->default(1);
            $table->foreign('purchase_request_id')->references('id')->on('purchase_request');
            $table->foreign('providers_id')->references('id')->on('providers');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Cotizaciones de compras aprobadas'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_aproveds');
    }
}
