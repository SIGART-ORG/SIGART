<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('products_id')->unsigned()->comment('Id de la tabla productos( products ).');
            $table->string('image_original', 100)->comment('Imagen original');
            $table->string('image_galery', 100)->nullable();
            $table->string('image_admin', 100)->nullable();
            $table->string('image_facebook', 100)->nullable();
            $table->integer('image_default')->default(0);
            $table->integer('status')->default(1);
            $table->foreign('products_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_images');
    }
}
