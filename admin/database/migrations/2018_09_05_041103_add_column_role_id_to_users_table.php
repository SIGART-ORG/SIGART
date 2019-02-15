<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
        });

        DB::table('users')->insert([
            'id'=>1,
            'name'=>'Julio Alcides',
            'last_name'=>'Salsavilca Huamanyauri',
            'document'=> '47140697',
            'address' => 'Santa Anita',
            'birthday' => '1991-07-08',
            'date_entry' => date('Y-m-d H:i:s'),
            'email' => 'j.salsavilca@gmail.com',
            'password' => bcrypt('47140697'),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'role_id' => 1
        ]);

        DB::table('users')->insert([
            'id'=>2,
            'name'=>'Jonathan Benjamín',
            'last_name'=>'Monsefu Gomez',
            'document'=> '47166996',
            'address' => 'Naranjal',
            'birthday' => '1992-07-08',
            'date_entry' => date('Y-m-d H:i:s'),
            'email' => 'benjamin.mg.20@gmail.com',
            'password' => bcrypt('47166996'),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'role_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('role_id');
        });
    }
}
