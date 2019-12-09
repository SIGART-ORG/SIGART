<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('customerFrom')->index()->default(0)->after('userTo');
            $table->tinyInteger('direction')->index()->default(0)->after('url')->comment('0: from admin to customer, 1: from customer to admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn( 'customerFrom' );
            $table->dropColumn( 'direction' );
        });
    }
}
