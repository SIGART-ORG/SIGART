<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id');
            $table->string('name', 60);
            $table->string('lastname', 60);
            $table->string('business_name', 150)->nullable();
            $table->string('document', 20);
            $table->integer('type_document')->default(1);
            $table->string('legal_representative', 100)->nullable();
            $table->integer('type_document_lp')->default(1)->nullable();/*Legal representative*/
            $table->string('email', 50)->nullable();
            $table->string('address', 100)->nullable();
            $table->integer('status')->default(1);
            $table->integer('district_id')->default(0)->index();
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
        Schema::dropIfExists('customers');
    }
}
