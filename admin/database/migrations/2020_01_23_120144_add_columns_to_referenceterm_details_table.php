<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToReferencetermDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referenceterm_details', function (Blueprint $table) {
            $table->decimal( 'price_unit', 10, 2 )->default(0);
            $table->decimal( 'total', 10, 2 )->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referenceterm_details', function (Blueprint $table) {
            //
        });
    }
}
