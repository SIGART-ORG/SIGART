<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [
            [
                'name' => 'Principal',
                'address' => 'Coop viña san francisco mz H lte 21 - Santa Anita - Lima',
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ],
            [
                'name' => 'Santa Clara',
                'address' => 'Asoc. Viv. Hijos de Apurimac mz H lte 13 - Santa Clara - Lima',
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ],
            [
                'name' => 'Comas',
                'address' => 'Av Tupac Amaru km 22 - Comas - Lima',
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ],
            [
                'name' => 'Arequipa',
                'address' => 'Carretera Panamericana Sur km 460 - Arequipa',
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ]
        ];

        DB::table( 'sites' )->insert( $insert );
    }
}
