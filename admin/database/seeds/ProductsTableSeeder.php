<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
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

        
        

        while ( $count < 50 ){

            $name = Str::random(20);

            if($count==0){
                
                $insert[] = [
                    'category_id' => 1,
                    'user_reg' => rand(1, 52),
                    'name' => 'Otros Servicios',
                    'description' => 'Otros Servicios',
                    'slug' => Str::slug( $name ),
                    'created_at' => date( 'Y-m-d H:i:s' ),
                    'updated_at' => date( 'Y-m-d H:i:s' ),
                    'cod_type_service' => '1',
                ];

            }else if($count==1){

                $insert[] = [
                    'category_id' => 2,
                    'user_reg' => rand(1, 52),
                    'name' => 'Otros Servicios',
                    'description' => 'Otros Servicios',
                    'slug' => Str::slug( $name ),
                    'created_at' => date( 'Y-m-d H:i:s' ),
                    'updated_at' => date( 'Y-m-d H:i:s' ),
                    'cod_type_service' => '2',
                ];

            }else{

                if (($count % 2) == 1){
                    $tipo = '1';
                }else{
                    $tipo = '2';
                }

                $insert[] = [
                    'category_id' => rand( 1, 9 ),
                    'user_reg' => rand(1, 52),
                    'name' => $name,
                    'description' => Str::random(30),
                    'slug' => Str::slug( $name ),
                    'created_at' => date( 'Y-m-d H:i:s' ),
                    'updated_at' => date( 'Y-m-d H:i:s' ),
                    'cod_type_service' => $tipo,
                ];


            }

            $count++;
        }

        DB::table( 'products' )->insert( $insert );
    }
}
