<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesQuotationsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'sales_quotations_details';  
        Schema::create($tableName, function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->bigIncrements('id')->comment('Id de detalle');
            $table->unsignedBigInteger('sales_quotations_id')->comment('Id de la tabla cotizacion ventas( sales_quotations ).');
            $table->integer('quantity');
            $table->integer('unity_id')->comment('Id de la tabla Unidad( unity ).');
            $table->unsignedBigInteger('products_id')->comment('Id de la tabla producto( products ).');
            $table->string('coment', 250)->comment('Comentario del Item');
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);            
            $table->integer('status')->default(1);
            $table->timestamps();            
            $table->foreign('sales_quotations_id')->references('id')->on('sales_quotations');
            //$table->foreign('unity_id')->references('id')->on('unity');
            $table->foreign('products_id')->references('id')->on('products');

        });

        DB::statement("ALTER TABLE `$tableName` comment 'TABLA: Cotizaciones Ventas - Detalle'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_quotations_details');
    }
}
