<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('url', 100)->after('name');
            $table->integer('view_panel')->default(1)->after('url');
            $table->string('icon', 25)->after('name');
        });

        DB::table('pages')->insert([
            'id'=>1,
            'module_id'=>1,
            'name'=>'Módulos',
            'icon' => '',
            'url' => 'module',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>2,
            'module_id'=>2,
            'name'=>'Colaboradores',
            'icon' => '',
            'url' => 'user',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>3,
            'module_id'=>2,
            'name'=>'Rol de usuario',
            'icon' => '',
            'url' => 'role',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>4,
            'module_id'=>1,
            'name'=>'Páginas',
            'icon' => '',
            'url' => 'page',
            'view_panel' => '0',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>5,
            'module_id'=>2,
            'name'=>'Accesos',
            'icon' => '',
            'url' => 'access',
            'view_panel' => '0',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>6,
            'module_id'=>3,
            'name'=>'Iconos',
            'icon' => '',
            'url' => 'icons',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>7,
            'module_id'=>3,
            'name'=>'Sedes',
            'icon' => '',
            'url' => 'sites',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>8,
            'module_id'=>3,
            'name'=>'Categorias de productos',
            'icon' => '',
            'url' => 'categories',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>9,
            'module_id'=>3,
            'name'=>'Feriados',
            'icon' => '',
            'url' => 'holidays',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('pages')->insert([
            'id'=>10,
            'module_id'=>4,
            'name'=>'Google Calendar',
            'icon' => '',
            'url' => 'calendar',
            'view_panel' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /*------------------ Accesos ------------------*/
        for($page = 1; $page <= 10; $page++) {
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
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('view_panel');
            $table->dropColumn('icon');
        });
    }
}
