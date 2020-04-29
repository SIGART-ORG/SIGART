<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsOutputOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('output_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_id')->nullable()->change();
            $table->dropColumn(['code']);
            $table->unsignedBigInteger('service_requirements_id')->after('services_id')->nullable();
            $table->string('serial_doc', 30 )->after('service_requirements_id');
            $table->integer('number_doc' )->after( 'serial_doc' );
            $table->tinyInteger( 'type' )->default( 0 );

            $table->foreign( 'service_requirements_id' )->references( 'id' )->on( 'service_requirements' );
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
