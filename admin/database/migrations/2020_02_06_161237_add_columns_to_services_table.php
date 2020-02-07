<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->date( 'start_date' )->nullable();
            $table->dateTime( 'start_date_real' )->nullable();
            $table->date( 'end_date' )->nullable();
            $table->dateTime( 'end_date_real' )->nullable();
            $table->decimal( 'sub_total', 10, 2 )->default( 0 );
            $table->decimal( 'igv', 10, 2 )->default( 0 );
            $table->decimal( 'total', 10, 2 )->default( 0 );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
}
