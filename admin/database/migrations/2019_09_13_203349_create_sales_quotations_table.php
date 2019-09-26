<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'sales_quotations';        
        Schema::create($tableName, function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de registro');
            $table->unsignedBigInteger('type_vouchers_id')->comment('Id de la tabla tipo de comprobantes( type_vouchers ).');
            $table->date('date_emission')->comment('Fecha de Emisión');
            $table->string('num_serie', 5)->comment('Numero de serie');
            $table->string('num_doc', 10)->comment('Numero del documento');
            $table->unsignedBigInteger('customers_id')->comment('Id de la tabla cliente( customers ).');
            $table->decimal('tot_sale', 10, 2)->default(0);
            $table->decimal('porc_dscto', 10, 2)->default(0);
            $table->decimal('tot_dscto', 10, 2)->default(0);
            $table->decimal('subtot_sale', 10, 2)->default(0);
            $table->decimal('porc_igv', 10, 2)->default(0);
            $table->decimal('tot_igv', 10, 2)->default(0);
            $table->decimal('tot_gral', 10, 2)->default(0);
            $table->string('total_letter', 250);
            $table->integer('status')->default(1)->comment("Registro de estado:\n0: Desactivado.\n1: Activo.\n2:Eliminado.\n3:En proceso.\n4: Terminado.\n5: Cerrado");   
            $table->timestamps();         
            $table->foreign('customers_id')->references('id')->on('customers');
            $table->foreign('type_vouchers_id')->references('id')->on('type_vouchers');

        });

        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Cotizaciones de Ventas'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_quotations');
    }
}
