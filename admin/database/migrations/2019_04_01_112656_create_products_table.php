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
