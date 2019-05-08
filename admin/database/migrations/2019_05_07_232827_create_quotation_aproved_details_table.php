<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationAprovedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'quotation_aproved_details';
        Schema::create($tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('quotations_id');
            $table->unsignedBigInteger('presentation_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->integer('selected')->default(0);
            $table->integer('status')->default(1);
            $table->foreign('quotations_id')->references('id')->on('quotations');
            $table->foreign('presentation_id')->references('id')->on('presentation');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Cotizaciones de compras aprobadas - detalles'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_aproved_details');
    }
}
