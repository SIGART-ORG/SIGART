<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
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
                'name' => Str::random(10),
                'last_name' => Str::random(10),
                'document' => rand(11111111, 99999999),
                'address' => Str::random(20),
                'birthday' => date( 'Y-m-d' ),
                'date_entry' => date( 'Y-m-d' ),
                'email' => Str::random(10).'@gmail.com',
                'password' => bcrypt('secret'),
                'phone' => rand(111111111, 999999999),
                'role_id' => rand(1, 6),
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $count ++;
        }

        DB::table( 'users' )->insert( $insert );
    }
}
