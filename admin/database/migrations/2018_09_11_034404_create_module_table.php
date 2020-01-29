<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id');
            $table->string('name', 50);
            $table->string('icon', 25);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('modules')->insert([
            'id'=>1,
            'name'=>'Seguridad',
            'icon' => 'fa-key',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

        DB::table('modules')->insert([
            'id'=>2,
            'name'=>'Accessos',
            'icon' => 'fa-eye',
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

        DB::table('modules')->insert([
            'id'=>5,
            'name'=>'Almacén',
            'icon' => 'fa-cubes',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        DB::table('modules')->insert([
            'id'=>6,
            'name'=>'Compras',
            'icon' => 'fa-shopping-bag',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        DB::table('modules')->insert([
            'id'=>7,
            'name'=>'Ventas',
            'icon' => 'fa-shopping-cart',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        DB::table('modules')->insert([
            'id'=>8,
            'name'=>'Solicitud',
            'icon' => 'fa-shopping-cart',
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
        Schema::dropIfExists('module');
    }
}
