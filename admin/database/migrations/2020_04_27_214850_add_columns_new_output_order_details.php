<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsNewOutputOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('output_order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('output_orders_id')->after('id')->nullable();
            $table->foreign( 'output_orders_id' )->references( 'id' )->on( 'output_orders' );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('output_order_details', function (Blueprint $table) {
            //
        });
    }
}
