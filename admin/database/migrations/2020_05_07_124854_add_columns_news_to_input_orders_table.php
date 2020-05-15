<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsNewsToInputOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('input_orders', function (Blueprint $table) {
            $table->dropColumn(['code']);
            $table->unsignedBigInteger('purchases_id')->nullable()->change();
            $table->unsignedBigInteger('output_orders_id')->after('purchases_id')->nullable();
            $table->bigInteger( 'user_delivered' )->default(0)->index()->after('user_input');
            $table->string('serial_doc', 30 )->after('output_orders_id');
            $table->integer('number_doc' )->after( 'serial_doc' );
            /* Type: 1: materiales, 2:herramientas */
            $table->tinyInteger( 'type' )->default( 1 );
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
        Schema::table('input_orders', function (Blueprint $table) {
            //
        });
    }
}
