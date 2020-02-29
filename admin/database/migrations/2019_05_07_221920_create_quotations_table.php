<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'quotations';
        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_request_id');
            $table->unsignedBigInteger('providers_id');
            $table->integer('user_reg')->default(0)->index();
            $table->text('comment')->nullable();
            $table->string('attach', 100)->nullable();
            $table->string( 'pdf', 250 )->nullable();
            $table->string( 'excel', 250 )->nullable();
            $table->integer('status')->default(1);
            $table->foreign('purchase_request_id')->references('id')->on('purchase_request');
            $table->foreign('providers_id')->references('id')->on('providers');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Cotizaciones de compras'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
