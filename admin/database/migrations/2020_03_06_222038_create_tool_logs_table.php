<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tool_stocks_id');
            $table->bigInteger('output_orders_id')->default(0)->index();
            $table->decimal('input', 10,2 )->default( 0 );
            $table->decimal('output', 10,2 )->default( 0 );
            $table->decimal('total', 10,2 )->default( 0 );
            $table->text( 'comment' )->nullable();
            $table->foreign('tool_stocks_id')->references('id')->on('tool_stocks');
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
        Schema::dropIfExists('tool_logs');
    }
}
