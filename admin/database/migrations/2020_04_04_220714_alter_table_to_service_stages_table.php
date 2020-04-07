<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableToServiceStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_stages', function (Blueprint $table) {
            $table->tinyInteger( 'count_observerds' )->default( 0 );
            $table->date( 'date_last_observed' )->nullable();
            $table->date( 'date_last_observed_reply' )->nullable();
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
