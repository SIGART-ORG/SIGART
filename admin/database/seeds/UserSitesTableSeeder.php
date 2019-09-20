<?php

use Illuminate\Database\Seeder;

class UserSitesTableSeeder extends Seeder
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
        while( $count <= 52 ) {
            $inser[] = [
                'users_id' => $count,
                'roles_id' => rand( 1, 6 ),
                'sites_id' => rand( 1, 4 ),
                'default'  => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $count++;
        }

        DB::table( 'user_sites' )->insert( $insert );
    }
}
