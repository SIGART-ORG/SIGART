<?php

use Illuminate\Database\Seeder;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
	    DB::table('presentation')->insert([
	        'id'=>'1',
	        'products_id'=>'1',
	        'unity_id'=>'2',
	        'sku'=>'sku 1',
	        'slug'=>'slug 1',
	        'description'=>'DESCRIPTION 1',
	        'equivalence'=>0,
	        'stock'=>'100',
	        'pricetag_purchase'=>'180.00', 
	        'status'=>'1',
	        'created_at'=>date('Y-m-d H:i:s'),
	        'updated_at'=>date('Y-m-d H:i:s')
	    ]);

	    DB::table('presentation')->insert([
	        'id'=>'2',
	        'products_id'=>'2',
	        'unity_id'=>'2',
	        'sku'=>'sku 2',
	        'slug'=>'slug 2',
	        'description'=>'DESCRIPTION 2',
	        'equivalence'=>0,
	        'stock'=>'100',
	        'pricetag_purchase'=>'150.00', 
	        'status'=>'1',
	        'created_at'=>date('Y-m-d H:i:s'),
	        'updated_at'=>date('Y-m-d H:i:s')
	    ]);

	    DB::table('presentation')->insert([
	        'id'=>'3',
	        'products_id'=>'3',
	        'unity_id'=>'2',
	        'sku'=>'sku 3',
	        'slug'=>'slug 3',
	        'description'=>'DESCRIPTION 3',
	        'equivalence'=>0,
	        'stock'=>'100',
	        'pricetag_purchase'=>'100.00', 
	        'status'=>'1',
	        'created_at'=>date('Y-m-d H:i:s'),
	        'updated_at'=>date('Y-m-d H:i:s')
	    ]);

    
    }
}
