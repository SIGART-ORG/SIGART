<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPresentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presentation', function (Blueprint $table) {

            $query = 'ALTER TABLE `presentation` CHANGE `products_id` `products_id` BIGINT(20) UNSIGNED NULL';
            DB::statement($query);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presentation', function (Blueprint $table) {
            //
        });
    }
}
