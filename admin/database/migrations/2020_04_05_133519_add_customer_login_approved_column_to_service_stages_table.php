<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerLoginApprovedColumnToServiceStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_stages', function (Blueprint $table) {
            $table->dateTime( 'approved_date' )->nullable();
            $table->tinyInteger( 'approved_type' )->default( 0 );
            $table->bigInteger( 'approved_customer_login_id' )->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_stages', function (Blueprint $table) {
            //
        });
    }
}
