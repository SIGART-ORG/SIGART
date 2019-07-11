<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'purchase_request_detail';

        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_request_id');
            $table->unsignedBigInteger('presentation_id');
            $table->integer('quantity');
            $table->integer('status')->default(1);
            $table->foreign('purchase_request_id')->references('id')->on('purchase_request');
            $table->foreign('presentation_id')->references('id')->on('presentation');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Detalle de solicitud de compra'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_request_detail');
    }
}
