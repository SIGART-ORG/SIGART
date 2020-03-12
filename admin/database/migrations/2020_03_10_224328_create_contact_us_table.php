<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string( 'name' , 50 );
            $table->string( 'lastname', 100 );
            $table->string( 'business', 100 )->nullable();
            $table->string( 'telephone', 12 );
            $table->string( 'email', 100 );
            $table->text('description' )->nullable();
            $table->dateTime( 'date_read' )->nullable();
            $table->tinyInteger( 'is_read' )->default(0);
            $table->bigInteger( 'user' )->default(0);
            $table->string( 'recapcha', 250 )->nullable();
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
        Schema::dropIfExists('contact_us');
    }
}
