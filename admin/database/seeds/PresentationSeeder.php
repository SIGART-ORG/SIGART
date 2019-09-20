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
        $count = 0;

        while( $count < 150 ) {
            $name = Str::random( 10 );
            $insert[] = [
                'products_id' => rand(1, 50),
                'unity_id' => rand( 1, 7),
                'sku' => 'PRO-PRUE-00' . ( $count +1 ),
                'slug' => Str::slug( $name ),
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
