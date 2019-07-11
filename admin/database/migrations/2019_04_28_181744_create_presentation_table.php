<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('products_id')->unsigned();
            $table->integer('unity_id')->unsigned();
            $table->string('sku', 20)->unique();
            $table->string('slug', 250)->unique();
            $table->string('description', 50);
            $table->integer('equivalence')->default(1);
            $table->integer('stock')->default(0);
            $table->decimal('pricetag_purchase', 10, 2)->default(0);
            $table->integer('status')->default(1);
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('unity_id')->references('id')->on('unity');
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
        Schema::dropIfExists('presentation');
    }
}
