<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPricePurchaseToKardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardexes', function (Blueprint $table) {
            $table->decimal('last_price_unit_purchase', 10, 2)->default(0)->after('price_total')->comment('Último precio unitario de compra');
            $table->decimal('price_unit_purchase', 10, 2)->default(0)->after('price_total')->comment('Precio unitario de compra');
            $table->decimal('price_total_purchase', 10, 2)->default(0)->after('price_total')->comment('Valor total de la compra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kardexes', function (Blueprint $table) {
            //
        });
    }
}
