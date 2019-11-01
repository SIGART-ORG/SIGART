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

        $insert = [
            [
                'id'=>1,
                'module_id'=>1,
                'name'=>'Módulos',
                'icon' => '',
                'url' => 'module/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>2,
                'module_id'=>2,
                'name'=>'Colaboradores',
                'icon' => '',
                'url' => 'user/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>3,
                'module_id'=>2,
                'name'=>'Rol de usuario',
                'icon' => '',
                'url' => 'role/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>4,
                'module_id'=>1,
                'name'=>'Páginas',
                'icon' => '',
                'url' => 'page/dashboard',
                'view_panel' => '0',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>5,
                'module_id'=>2,
                'name'=>'Accesos',
                'icon' => '',
                'url' => 'access/dashboard',
                'view_panel' => '0',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>6,
                'module_id'=>3,
                'name'=>'Iconos',
                'icon' => '',
                'url' => 'icons/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>7,
                'module_id'=>3,
                'name'=>'Sedes',
                'icon' => '',
                'url' => 'sites/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>8,
                'module_id'=>3,
                'name'=>'Categorias de productos',
                'icon' => '',
                'url' => 'categories/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>9,
                'module_id'=>4,
                'name'=>'Feriados',
                'icon' => '',
                'url' => 'holidays/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>10,
                'module_id'=>4,
                'name'=>'Google Calendar',
                'icon' => '',
                'url' => 'calendar/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>11,
                'module_id'=>3,
                'name'=>'Unidad de medida',
                'icon' => '',
                'url' => 'unity/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>12,
                'module_id'=>1,
                'name'=>'Log',
                'icon' => '',
                'url' => 'logs/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>13,
                'module_id'=>1,
                'name'=>'Acceder como colaborador',
                'icon' => '',
                'url' => 'loginUser/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>14,
                'module_id'=>5,
                'name'=>'Productos',
                'icon' => '',
                'url' => 'products/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>15,
                'module_id'=>7,
                'name'=>'Clientes',
                'icon' => '',
                'url' => 'customers/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>16,
                'module_id'=>6,
                'name'=>'Proveedores',
                'icon' => '',
                'url' => 'providers/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>17,
                'module_id'=>5,
                'name'=>'Stock',
                'icon' => '',
                'url' => 'stock/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>18,
                'module_id'=>6,
                'name'=>'Solicitudes de compra',
                'icon' => '',
                'url' => 'purchase-request/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>19,
                'module_id'=>6,
                'name'=>'Cotizaciones',
                'icon' => '',
                'url' => 'quotations/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>20,
                'module_id'=>6,
                'name'=>'Ordenes de compra',
                'icon' => '',
                'url' => 'purchase-order/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>21,
                'module_id'=>6,
                'name'=>'Compras',
                'icon' => '',
                'url' => 'purchases/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>22,
                'module_id'=>7,
                'name'=>'Cotizar Ventas',
                'icon' => '',
                'url' => 'salesquote/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>23,
                'module_id'=>8,
                'name'=>'Solicitud Servicio',
                'icon' => '',
                'url' => 'servicerequest/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>24,
                'module_id'=>7,
                'name'=>'Solicitud Servicio Empresa',
                'icon' => '',
                'url' => 'servicerequestscompany/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'=>25,
                'module_id'=>5,
                'name'=>'Ordenes de entradas',
                'icon' => '',
                'url' => 'input-orders/dashboard',
                'view_panel' => '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('pages')->insert( $insert );

        /*------------------ Accesos ------------------*/
        for($page = 1; $page <= count( $insert ); $page++) {
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
