<?php

use Illuminate\Database\Seeder;

class ServiceLogsTableSeeder extends Seeder
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
                'services_id' => $count + 1,
                'description' => 'Se registró el servicio',
                'binnacles_id' => 1,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $count++;
        }


        DB::table( 'service_logs' )->insert( $insert );
    }
}
