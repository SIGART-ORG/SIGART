<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $users = DB::table( 'users' )->select('id', 'role_id')->get();

        foreach( $users as $user ) {

            $numRoles = rand( 1, 6 );
            $count = 0;

            $insert[] = [
                'users_id' => $user->id,
                'roles_id' => $user->role_id,
                'sites_id' => 1,
                'default'  => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            while( $count < $numRoles ) {
                $insert[] = [
                    'users_id' => $user->id,
                    'roles_id' => rand( 1, 6 ),
                    'sites_id' => rand( 2, 4 ),
                    'default'  => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $count++;
            }

        }

        DB::table( 'user_sites' )->insert( $insert );
    }
}
