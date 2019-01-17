<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('icon', 25)->after('name');
        });

        DB::table('modules')->insert([
            'id'=>1,
            'name'=>'Seguridad',
            'icon' => 'icon-key',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

        DB::table('modules')->insert([
            'id'=>2,
            'name'=>'Accessos',
            'icon' => 'icon-eye',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

        DB::table('modules')->insert([
            'id'=>3,
            'name'=>'Configuración',
            'icon' => 'icon-settings',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

        DB::table('modules')->insert([
            'id'=>4,
            'name'=>'Eventos',
            'icon' => 'icon-calendar',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}
