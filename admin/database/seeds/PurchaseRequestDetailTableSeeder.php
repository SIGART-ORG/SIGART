<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseRequestDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [];
        $count = 1;

        while( $count <= 50 ) {
            $numItems = rand( 1, 6 );

            for( $i = 1; $i <= $numItems; $i++ ) {
                $insert[] = [
                    'purchase_request_id' => $count,
                    'presentation_id' => rand( 1, 150 ),
                    'quantity' => rand( 1, 20 ),
                    'created_at' => date( 'Y-m-d H:i:s' ),
                    'updated_at' => date( 'Y-m-d H:i:s' )
                ];
            }
            $count++;
        }

        DB::table( 'purchase_request_detail' )->insert( $insert );
    }
}
