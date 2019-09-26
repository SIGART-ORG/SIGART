<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {            
            $table->bigIncrements('id')->comment('Id de registro.');            
            $table->string('group', 100);
            $table->string('description', 200);
            $table->string('val1',50);
            $table->string('val2',50);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('parametros')->insert([
            'id'=>'1',
            'group'=>'IGV',
            'description'=>'% IGV',
            'val1'=>'18',
            'val2'=>'0.18',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'2',
            'group'=>'DESCUENTO',
            'description'=>'5 %',
            'val1'=>'5',
            'val2'=>'0.05',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'3',
            'group'=>'DESCUENTO',
            'description'=>'10 %',
            'val1'=>'10',
            'val2'=>'0.10',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'4',
            'group'=>'DESCUENTO',
            'description'=>'15 %',
            'val1'=>'15',
            'val2'=>'0.15',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'5',
            'group'=>'DESCUENTO',
            'description'=>'20 %',
            'val1'=>'20',
            'val2'=>'0.20',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'6',
            'group'=>'DESCUENTO',
            'description'=>'30 %',
            'val1'=>'30',
            'val2'=>'0.30',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'7',
            'group'=>'DESCUENTO',
            'description'=>'50 %',
            'val1'=>'50',
            'val2'=>'0.50',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'8',
            'group'=>'SERIE',
            'description'=>'COTIZACIÓN',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);


        DB::table('parametros')->insert([
            'id'=>'9',
            'group'=>'SERIE',
            'description'=>'REQUERIMIENTO',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'10',
            'group'=>'SERIE',
            'description'=>'BOLETA',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'11',
            'group'=>'SERIE',
            'description'=>'FACTURA',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'12',
            'group'=>'SERIE',
            'description'=>'NOTA CRÉDITO',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'13',
            'group'=>'SERIE',
            'description'=>'NOTA DÉBITO',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'14',
            'group'=>'SERIE',
            'description'=>'GUÍA REMISIÓN',
            'val1'=>'00001',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);



        DB::table('parametros')->insert([
            'id'=>'15',
            'group'=>'EMPRESA',
            'description'=>'RUC',
            'val1'=>'10123456789',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'16',
            'group'=>'EMPRESA',
            'description'=>'NOMBRE EMPRESA',
            'val1'=>'MINTOS',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);


        DB::table('parametros')->insert([
            'id'=>'17',
            'group'=>'EMPRESA',
            'description'=>'NOMBRE COMERCIAL',
            'val1'=>'LOS CHARROS',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'18',
            'group'=>'EMPRESA',
            'description'=>'DIRECCIÓN',
            'val1'=>'AV. XYZ N° 123',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'19',
            'group'=>'EMPRESA',
            'description'=>'DEPARTAMENTO',
            'val1'=>'LIMA',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'20',
            'group'=>'EMPRESA',
            'description'=>'PROVINCIA',
            'val1'=>'LIMA',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'21',
            'group'=>'EMPRESA',
            'description'=>'DISTRITO',
            'val1'=>'SAN MARTÍN DE PORRES',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('parametros')->insert([
            'id'=>'22',
            'group'=>'EMPRESA',
            'description'=>'TELÉFONO',
            'val1'=>'01-4617501',
            'val2'=>'-',
            'status'=>'1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}
