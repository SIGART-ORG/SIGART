<?php

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;
        $insert = [];

        while( $count <= 150  ) {
            for( $iter = 1; $iter <= 4; $iter++ ) {
                $price = rand( 40, 200 );
                $priceBuy = round( ( 1.05 * $price ), 2 );

                $insert[] = [
                    'sites_id' => $iter,
                    'presentation_id' => $count,
                    'stock' => rand( 1, 6 ),
                    'price' => $price,
                    'price_buy' => $priceBuy,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            $count++;
        }

        DB::table('stocks')->insert( $insert );
    }
}
