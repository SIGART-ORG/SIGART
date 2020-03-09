<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsToOutputOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('output_orders', function (Blueprint $table) {
            $table->dropForeign(['sales_id']);
            $table->unsignedBigInteger('services_id')->comment('Id de la tabla servicio( services ).');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('output_orders', function (Blueprint $table) {
            //
        });
    }
}
