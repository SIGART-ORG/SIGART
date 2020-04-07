<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableToTaskObserveds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_observeds', function (Blueprint $table) {
            $table->unsignedBigInteger( 'stage_observeds_id' )->after( 'tasks_id' );
            $table->dropColumn(['name', 'description', 'reply', 'user_reply', 'date_reply']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_observeds', function (Blueprint $table) {
            //
        });
    }
}
