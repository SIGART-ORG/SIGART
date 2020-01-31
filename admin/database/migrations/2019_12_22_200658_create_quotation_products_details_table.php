<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationProductsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_products_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_quotations_details_id');
            $table->unsignedBigInteger('presentation_id');
            $table->integer('quantity')->default(0);
            $table->integer('difference')->default(0);
            $table->decimal( 'price', 10, 2)->default(0);
            $table->integer('status')->default(1);
            $table->foreign('sales_quotations_details_id')->references('id')->on('sales_quotations_details');

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
        Schema::dropIfExists('quotation_products_details');
    }
}
