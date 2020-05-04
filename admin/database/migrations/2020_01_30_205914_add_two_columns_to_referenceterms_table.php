<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToReferencetermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referenceterms', function (Blueprint $table) {
            $table->string( 'sr_serie', 5 )->nullable();
            $table->string( 'sr_number', 10 )->nullable();
            $table->string( 'so_serie', 5 )->nullable();
            $table->string( 'so_number', 10 )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referenceterms', function (Blueprint $table) {
            //
        });
    }
}
