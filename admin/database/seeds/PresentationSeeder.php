<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [];

        $faker = \Faker\Factory::create();
        $faker->addProvider (new \Bezhanov\Faker\Provider\Device( $faker ) );

        $count = DB::table( 'presentation' )->count() + 1;
        $countStart = $count;

        while( ( $count - $countStart ) < 150 ) {
            $name = $faker->deviceManufacturer . ' - ' . $faker->deviceModelName;

            $num_aleatorio = rand(1, 50);

            $insert[] = [
                'products_id' => $num_aleatorio,
                'unity_id' => rand( 1, 7),
                'sku' => 'PRO-PRUE-00' . ( $count +1 ),
                'slug' => Str::slug( uniqid( $name . '-' ) ),
                'description' => $name,
                'stock' => rand( 1, 100),
                'pricetag_purchase' => rand(1, 100),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $count ++;
        }

	    DB::table('presentation')->insert( $insert );
    }
}
