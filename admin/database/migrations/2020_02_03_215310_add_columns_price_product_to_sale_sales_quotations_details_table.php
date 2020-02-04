<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPriceProductToSaleSalesQuotationsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_quotations_details', function (Blueprint $table) {
            $table->tinyInteger( 'includes_products' )->default( 0 );
            $table->decimal( 'total_products', 10, 2 )->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_quotations_details', function (Blueprint $table) {
            //
        });
    }
}
