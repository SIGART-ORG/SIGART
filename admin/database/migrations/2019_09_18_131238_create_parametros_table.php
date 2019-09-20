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
            $table->integer('val1')->default(0);
            $table->decimal('val2', 10, 2)->default(0);
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
