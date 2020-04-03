<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMountColumnToServiceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_attachments', function (Blueprint $table) {
            $table->string('number_operation', 250 )->nullable();
            $table->decimal( 'mount', 10, 2 )->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_attachments', function (Blueprint $table) {
            //
        });
    }
}
