<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseRequestTableSeeder extends Seeder
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

        while( $count < 50 ) {
            $insert[] = [
                'sites_id' => rand( 1, 4 ),
                'user_reg' => rand( 1, 52 ),
                'code' => uniqid(),
                'date' => date( 'Y-m-d' ),
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $count++;
        }


        DB::table( 'purchase_request' )->insert( $insert );
    }
}
