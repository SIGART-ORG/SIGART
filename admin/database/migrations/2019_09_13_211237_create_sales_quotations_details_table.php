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
            $table->integer('quantity')->default(0);
            $table->text('description')->nullable()->comment('Descripción del Item');
            $table->text('comment')->nullable()->comment('Comentario del Item');
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('igv', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('sales_quotations_id')->references('id')->on('sales_quotations');

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
