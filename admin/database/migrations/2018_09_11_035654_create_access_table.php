<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('page_id')->unsigned();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('page_id')->references('id')->on('pages');
        });

        /*------------------ Accesos ------------------*/
        $count = DB::table( 'pages' )->count();
        for($page = 1; $page <= $count; $page++) {
            DB::table('access')->insert([
                'id' => $page,
                'role_id' => 1,
                'page_id' => $page,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access');
    }
}
