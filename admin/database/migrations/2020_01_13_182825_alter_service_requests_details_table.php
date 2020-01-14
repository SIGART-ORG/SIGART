<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServiceRequestsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_request_details', function (Blueprint $table) {
            $table->integer( 'assumed_customer' )->default( 0 )->change();
            $table->tinyInteger( 'type' )->default( 0 );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_request_details', function (Blueprint $table) {
            //
        });
    }
}
