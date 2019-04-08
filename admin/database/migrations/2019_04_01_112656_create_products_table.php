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
            $table->integer('unity_id')->unsigned();
            $table->integer('user_reg')->unsigned();
            $table->string('name', 50);
            $table->text('description');
            $table->decimal('pricetag', 10, 2);
            $table->string('slug')->unique();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->foreign('unity_id')->references('id')->on('unity');
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
