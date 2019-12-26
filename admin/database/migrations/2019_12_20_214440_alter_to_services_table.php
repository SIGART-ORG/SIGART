<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {

            $table->string( 'serial_doc', 5 )->nullable()->change();
            $table->date( 'date_aproved' )->nullable()->change();
            $table->date( 'date_aproved_customer' )->nullable()->change();
            $table->text( 'description' )->nullable()->change();
            $table->tinyInteger( 'status' )->default( 1 )->after( 'observation');
            DB::statement('ALTER TABLE `services` CHANGE `number_doc` `number_doc` INT(11) NULL DEFAULT NULL COMMENT \'Número del servicio.\'; ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string( 'serial_doc', 3 )->nullable()->change();
            $table->string( 'number_doc', 6 )->nullable()->change();
            $table->dropColumn( 'status' );
        });
    }
}
