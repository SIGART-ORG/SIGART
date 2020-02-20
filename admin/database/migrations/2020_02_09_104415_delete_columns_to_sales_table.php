<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnsToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal( 'pay_mount', 10, 2 )->nullable( 0 );
            $table->string( 'pdf', 250 )->nullable();
            $table->string( 'attachment', 250 )->nullable();
            $table->text( 'observation' )->nullable();
            $table->dropColumn( 'first_min_pay' );
            $table->dropColumn( 'first_pay' );
            $table->dropColumn( 'first_pay_date' );
            $table->dropColumn( 'first_pay_pdf' );
            $table->dropColumn( 'second_pay' );
            $table->dropColumn( 'second_pay_date' );
            $table->dropColumn( 'second_pay_pdf' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
}
