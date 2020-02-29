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

        $faker = \Faker\Factory::create();
        $faker->addProvider (new \Bezhanov\Faker\Provider\Device( $faker ) );

        $insert = [];
        $count = 0;

        while ( $count < 50 ){

            $name = $faker->devicePlatform;

            $insert[] = [
                'category_id' => rand( 1, 9 ),
                'user_reg' => rand(1, 52),
                'name' => $name,
                'description' => Str::random(30),
                'slug' => Str::slug( uniqid( $name . '-' ) ),
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'cod_type_service' => rand(1, 2),
            ];

            $count++;
        }

        DB::table( 'products' )->insert( $insert );
    }
}
