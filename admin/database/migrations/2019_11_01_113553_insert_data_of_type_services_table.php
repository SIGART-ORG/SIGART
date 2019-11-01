<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDataOfTypeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $insert = [
            [
                'id' => 1,
                'name' => 'Servicio de Pintura',
                'status' => 1,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ],
            [
                'id' => 2,
                'name' => 'Servicio de Carpintería',
                'status' => 1,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ]
        ];

        DB::table( 'type_services' )->insert( $insert );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_services', function (Blueprint $table) {
            //
        });
    }
}
