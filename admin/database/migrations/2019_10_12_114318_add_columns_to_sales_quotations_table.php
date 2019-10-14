<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSalesQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_quotations', function (Blueprint $table) {

            $table->unsignedBigInteger('service_requests_id')->comment('Id de la tabla solicitud de servicio ( service_requests ).');
            $table->tinyInteger( 'is_approved_customer' )->default(0)->comment( '0: Pendiente de aprobación, 1: Aprobado' );
            $table->bigInteger( 'customer_login_id' )->default(0)->comment('Id de cliente loggeado que aprueba la cotización');
            $table->dateTime( 'date_approved_customer' )->nullable()->comment( 'Fecha de aprovación de la cotización por parte del cliente.' );
            $table->foreign('service_requests_id')->references('id')->on('service_requests');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_quotations', function (Blueprint $table) {
            //
        });
    }
}
