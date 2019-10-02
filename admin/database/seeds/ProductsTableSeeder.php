<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [];
        $count = 0;

        $name = Str::random(20);
        $insert[] = [
            'category_id' => 1,
            'user_reg' => rand(1, 52),
            'name' => 'Otros Servicios',
            'description' => 'Otros Servicios',
            'slug' => Str::slug( $name ),
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ];

        while ( $count < 50 ){
            $name = Str::random(20);
            $insert[] = [
                'category_id' => rand( 1, 9 ),
                'user_reg' => rand(1, 52),
                'name' => $name,
                'description' => Str::random(30),
                'slug' => Str::slug( $name ),
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];

            $count++;
        }

        DB::table( 'products' )->insert( $insert );
    }
}
