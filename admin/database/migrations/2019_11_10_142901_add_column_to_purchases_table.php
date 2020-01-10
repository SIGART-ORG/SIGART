<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->date( 'date_issue' )->nullable();
            $table->string( 'serial_doc', 5 )->nullable()->change();
            $table->string( 'number_doc', 11 )->nullable()->change();
            $table->string( 'pdf', 250 )->nullable()->comment('Pdf generado adjunto enviado en el correo.');
            $table->string( 'attach', 250 )->nullable()->comment('Imagen del comprobante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn( 'date_issue' );
            $table->string( 'serial_doc', 3 )->change();
            $table->string( 'number_doc', 6 )->change();
        });
    }
}
