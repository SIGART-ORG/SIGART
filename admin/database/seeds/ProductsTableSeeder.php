<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $insert = [
            [
                'id' => 1,
                'category_id' => 1,
                'user_reg' => 1,
                'name' => 'PUERTA DE MADERA NORMAL',                
                'description' => 'PUERTA DE MADERA 2M X 1M',
                'slug' => 'PUERTA-MADERA-2M-X-1M',  
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'user_reg' => 1,
                'name' => 'PUERTA DE MELAMINA NORMAL',                
                'description' => 'PUERTA DE MELAMINA 2M X 1M',
                'slug' => 'PUERTA-MELAMINA-2M-X-1M',  
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'user_reg' => 1,
                'name' => 'PUERTA DE TRIPLAY NORMAL',                
                'description' => 'PUERTA DE TRIPLAY 2M X 1M',
                'slug' => 'PUERTA-TRIPLAY-2M-X-1M',  
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('products')->insert( $insert );
        
    }
}
