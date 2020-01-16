<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSalesQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_quotations', function (Blueprint $table) {
            $table->tinyInteger( 'type_reply' )->default( 0 );
            $table->bigInteger( 'user_reply' )->default( 0 )->index();
            $table->dateTime( 'date_reply' )->nullable();
            $table->tinyInteger( 'type_reply_second' )->default( 0 );
            $table->bigInteger( 'user_reply_second' )->default( 0 )->index();
            $table->dateTime( 'date_reply_second' )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_quotations', function (Blueprint $table) {
            //
        });
    }
}
