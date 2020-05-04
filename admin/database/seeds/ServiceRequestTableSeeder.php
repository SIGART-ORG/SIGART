<?php

use Illuminate\Database\Seeder;

class ServiceRequestTableSeeder extends Seeder
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
            $site = rand( 1, 4 );
            $insert[] = [
                'sites_id' => $site,
                'type_vouchers_id' => rand( 1, 8 ),
                'date_emission' => date( 'Y-m-d' ),
                'num_request' => 'CS' . $site . '-' . rand( 500, 600 ),
                'customers_id' => rand( 1, 50 ),
                'user_reg' => rand( 1, 50 ),
                'date_reg' => date( 'Y-m-d H:i:s' ),
                'date_aproved' => date( 'Y-m-d H:i:s' ),
                'description' => 'description',
                'is_send' => 1,
                'date_send' => date( 'Y-m-d H:i:s' ),
                'derive_request' => rand( 0, 1 ),
                'description_corrected' => 'description',
                'address' => 'Av Prueba 123',
                'district_id' => '150105',
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $count++;
        }


        DB::table( 'service_requests' )->insert( $insert );
    }
}
