<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsToOutputOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('output_orders', function (Blueprint $table) {
            $table->dropForeign(['sales_id']);
            $table->string('code', 20)->nullable()->change();
            $table->date('date_input_reg')->nullable()->change();
            $table->date('date_output')->nullable()->change();
            $table->unsignedBigInteger('services_id')->after('id')->comment('Id de la tabla servicio( services ).');
            $table->tinyInteger( 'type_outorder' )->default( 1 )->comment( '1: Materiales; 2: Herramientas' );
            $table->text( 'comment' )->nullable();

            $table->foreign('services_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('output_orders', function (Blueprint $table) {
            //
        });
    }
}
