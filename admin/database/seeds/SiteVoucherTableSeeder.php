<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Str;

class SiteVoucherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [];

        $sites = DB::table( 'sites' )->select('id')->get();
        $typeVoucher = DB::table( 'type_vouchers' )->select('id', 'name')->get();

        foreach ( $sites as $site ) {
            foreach ( $typeVoucher as $tv ) {
                $insert[] = [
                    'sites_id' => $site->id,
                    'type_vouchers_id' => $tv->id,
                    'serie' => Str::upper( Str::limit( $tv->name, 3, '' ) ) . $tv->id,
                    'number' => 1,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        DB::table('site_vourchers')->insert( $insert );
    }
}
