<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskObservedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_observeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tasks_id');
            $table->string( 'name', 250 );
            $table->text( 'description' );
            $table->text( 'reply' )->nullable();
            $table->bigInteger( 'user_reply' )->default(0)->index();
            $table->dateTime( 'date_reply' )->nullable();
            $table->tinyInteger( 'status' )->default( 1 );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_observeds');
    }
}
