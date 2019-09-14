<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_reg')->unsigned();
            $table->string('name', 50);
            $table->text('description');
            $table->string('slug', 250)->unique();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->index('user_reg');
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
