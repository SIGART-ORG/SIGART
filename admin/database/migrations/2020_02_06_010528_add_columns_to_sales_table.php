<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->date( 'date_emission' );
            $table->date('date_pay')->nullable();
            $table->string( 'company_name', 250 )->comment( 'Razón social de la empresa' );
            $table->string( 'business_name_customer', 250 )->comment( 'Razón social del cliente' );
            $table->string('company_document', 20);
            $table->string('customer_document', 20);
            $table->integer('customer_type_document')->default(1);
            $table->decimal( 'first_min_pay', 10, 2 )->default(0)->comment( 'Mínimo monto a pagar' );
            $table->decimal( 'first_pay', 10, 2 )->default(0)->comment( 'Primer monto a pagar' );
            $table->dateTime( 'first_pay_date' )->nullable()->comment( 'Fecha de Primer pago' );
            $table->string( 'first_pay_pdf', 250 )->nullable();
            $table->decimal( 'second_pay', 10, 2 )->default(0)->comment( 'Último monto a pagar' );
            $table->dateTime( 'second_pay_date' )->nullable()->comment( 'Fecha de último pago' );
            $table->string( 'second_pay_pdf', 250 )->nullable();
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
