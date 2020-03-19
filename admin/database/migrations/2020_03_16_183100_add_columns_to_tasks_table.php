<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dateTime( 'date_observed' )->nullable()->after( 'date_end');
            $table->dateTime( 'date_validate_customer' )->nullable()->after('date_observed');
            $table->bigInteger( 'customers_id' )->default( 0 )->index()->after('date_validate_customer');
            $table->bigInteger( 'customers_login_id' )->default( 0 )->index()->after('customers_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
