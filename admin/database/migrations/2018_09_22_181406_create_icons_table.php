<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIconsTable extends Migration
{
    /**
     * Run the migrations.s
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id');
            $table->string('name', 50);
            $table->string('group', 50);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('icons')->insert(['name'=>'address-book', 'group'=>'fa', 'status'=>1, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icons');
    }
}
