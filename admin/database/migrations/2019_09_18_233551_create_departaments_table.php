<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departaments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->char('id', 6)->primary()->comment('Id de registro');
            $table->string('name', 50)->comment('Nombre del departamento');

        });

        $insert = [
            [
                'id' => '010000',
                'name' => 'Amazonas'
            ],
            [
                'id' => '020000',
                'name' => 'Áncash'
            ],
            [
                'id' => '030000',
                'name' => 'Apurímac'
            ],
            [
                'id' => '040000',
                'name' => 'Arequipa'
            ],
            [
                'id' => '050000',
                'name' => 'Ayacucho'
            ],
            [
                'id' => '060000',
                'name' => 'Cajamarca'
            ],
            [
                'id' => '070000',
                'name' => 'Callao'
            ],
            [
                'id' => '080000',
                'name' => 'Cusco'
            ],
            [
                'id' => '090000',
                'name' => 'Huancavelica'
            ],
            [
                'id' => '100000',
                'name' => 'Huánuco'
            ],
            [
                'id' => '110000',
                'name' => 'Ica'
            ],
            [
                'id' => '120000',
                'name' => 'Junín'
            ],
            [
                'id' => '130000',
                'name' => 'La Libertad'
            ],
            [
                'id' => '140000',
                'name' => 'Lambayeque'
            ],
            [
                'id' => '150000',
                'name' => 'Lima'
            ],
            [
                'id' => '160000',
                'name' => 'Loreto'
            ],[
                'id' => '170000',
                'name' => 'Madre de Dios'
            ],
            [
                'id' => '180000',
                'name' => 'Moquegua'
            ],
            [
                'id' => '190000',
                'name' => 'Pasco'
            ],
            [
                'id' => '200000',
                'name' => 'Piura'
            ],
            [
                'id' => '210000',
                'name' => 'Puno'
            ],
            [
                'id' => '220000',
                'name' => 'San Martín'
            ],
            [
                'id' => '230000',
                'name' => 'Tacna'
            ],
            [
                'id' => '240000',
                'name' => 'Tumbes'
            ],
            [
                'id' => '250000',
                'name' => 'Ucayali'
            ]
        ];

        DB::table('departaments')->insert( $insert );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departaments');
    }
}
