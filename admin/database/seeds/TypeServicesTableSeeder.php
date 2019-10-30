<?php

use Illuminate\Database\Seeder;

class TypeServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [];

        $insert[] = [
            'id' => 1,
            'name' => 'Servicio de Pintura',
            'status' => 1,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ];

        $insert[] = [
            'id' => 2,
            'name' => 'Servicio de Carpintería',
            'status' => 1,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ];

        DB::table( 'type_services' )->insert( $insert );

    }
}
