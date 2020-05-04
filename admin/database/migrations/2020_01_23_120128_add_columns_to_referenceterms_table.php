<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToReferencetermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referenceterms', function (Blueprint $table) {
            $table->string( 'pdf_rt' )->nullable();
            $table->string( 'pdf_os' )->nullable();

            $table->tinyInteger( 'rt_type_approved_adm' )->default(0)->index();
            $table->dateTime( 'rt_date_approved_adm' )->nullable();
            $table->bigInteger( 'rt_user_approved_adm' )->default(0)->index();
            $table->string( 'rt_attachment_adm', 250 )->nullable();

            $table->tinyInteger( 'rt_type_approved_gd' )->default(0)->index();
            $table->dateTime( 'rt_date_approved_gd' )->nullable();
            $table->bigInteger( 'rt_user_approved_gd' )->default(0)->index();
            $table->string( 'rt_attachment_gd', 250 )->nullable();

            $table->tinyInteger( 'os_type_approved_gd' )->default(0)->index();
            $table->dateTime( 'os_date_approved_gd' )->nullable();
            $table->bigInteger( 'os_user_approved_gd' )->default(0)->index();
            $table->string( 'os_attachment_gd', 250 )->nullable();

            $table->tinyInteger( 'os_type_approved_customer' )->default(0)->index();
            $table->dateTime( 'os_date_approved_customer' )->nullable();
            $table->bigInteger( 'os_user_approved_customer' )->default(0)->index();
            $table->bigInteger( 'os_user_login_approved_customer' )->default(0)->index();
            $table->string( 'rt_attachment_customer', 250 )->nullable();

            $table->decimal( 'sub_total', 10, 2 )->default(0);
            $table->decimal( 'igv', 10, 2 )->default(0);
            $table->decimal( 'total', 10, 2 )->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referenceterms', function (Blueprint $table) {
            //
        });
    }
}
