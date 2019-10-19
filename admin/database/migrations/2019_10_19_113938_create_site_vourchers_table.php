<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteVourchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_vourchers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->bigIncrements('id');
            $table->unsignedInteger('sites_id');
            $table->unsignedBigInteger('type_vouchers_id');
            $table->string('serie', 5)->nullable();
            $table->integer('number')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('sites_id')->references('id')->on('sites');
            $table->foreign('type_vouchers_id')->references('id')->on('type_vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_vourchers');
    }
}
