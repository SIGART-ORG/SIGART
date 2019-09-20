<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->char('id',6)->primary()->comment('Id de registro');
            $table->string('name', 50)->comment('Nombre de la provincia');
            $table->char('departament_id',6)->comment('Id del departamento');
            $table->foreign('departament_id')->references('id')->on('departaments');
        });

        $insert = [
            [
                'id' => '010100',
                'name' => 'Chachapoyas',
                'departament_id' => '010000'
            ],
            [
                'id' => '010200',
                'name' => 'Bagua',
                'departament_id' => '010000'
            ],
            [
                'id' => '010300',
                'name' => 'Bongará',
                'departament_id' => '010000'
            ],
            [
                'id' => '010400',
                'name' => 'Condorcanqui',
                'departament_id' => '010000'
            ],
            [
                'id' => '010500',
                'name' => 'Luya',
                'departament_id' => '010000'
            ],
            [
                'id' => '010600',
                'name' => 'Rodríguez de Mendoza',
                'departament_id' => '010000'
            ],
            [
                'id' => '010700',
                'name' => 'Utcubamba',
                'departament_id' => '010000'
            ],
            [
                'id' => '020100',
                'name' => 'Huaraz',
                'departament_id' => '020000'
            ],
            [
                'id' => '020200',
                'name' => 'Aija',
                'departament_id' => '020000'
            ],
            [
                'id' => '020300',
                'name' => 'Antonio Raymondi',
                'departament_id' => '020000'
            ],
            [
                'id' => '020400',
                'name' => 'Asunción',
                'departament_id' => '020000'
            ],
            [
                'id' => '020500',
                'name' => 'Bolognesi',
                'departament_id' => '020000'
            ],
            [
                'id' => '020600',
                'name' => 'Carhuaz',
                'departament_id' => '020000'
            ],
            [
                'id' => '020700',
                'name' => 'Carlos Fermín Fitzcarrald',
                'departament_id' => '020000'
            ],
            [
                'id' => '020800',
                'name' => 'Casma',
                'departament_id' => '020000'
            ],
            [
                'id' => '020900',
                'name' => 'Corongo',
                'departament_id' => '020000'
            ],
            [
                'id' => '021000',
                'name' => 'Huari',
                'departament_id' => '020000'
            ],
            [
                'id' => '021100',
                'name' => 'Huarmey',
                'departament_id' => '020000'
            ],
            [
                'id' => '021200',
                'name' => 'Huaylas',
                'departament_id' => '020000'
            ],
            [
                'id' => '021300',
                'name' => 'Mariscal Luzuriaga',
                'departament_id' => '020000'
            ],
            [
                'id' => '021400',
                'name' => 'Ocros',
                'departament_id' => '020000'
            ],
            [
                'id' => '021500',
                'name' => 'Pallasca',
                'departament_id' => '020000'
            ],
            [
                'id' => '021600',
                'name' => 'Pomabamba',
                'departament_id' => '020000'
            ],
            [
                'id' => '021700',
                'name' => 'Recuay',
                'departament_id' => '020000'
            ],
            [
                'id' => '021800',
                'name' => 'Santa',
                'departament_id' => '020000'
            ],
            [
                'id' => '021900',
                'name' => 'Sihuas',
                'departament_id' => '020000'
            ],
            [
                'id' => '022000',
                'name' => 'Yungay',
                'departament_id' => '020000'
            ],
            [
                'id' => '030100',
                'name' => 'Abancay',
                'departament_id' => '030000'
            ],
            [
                'id' => '030200',
                'name' => 'Andahuaylas',
                'departament_id' => '030000'
            ],
            [
                'id' => '030300',
                'name' => 'Antabamba',
                'departament_id' => '030000'
            ],
            [
                'id' => '030400',
                'name' => 'Aymaraes',
                'departament_id' => '030000'
            ],
            [
                'id' => '030500',
                'name' => 'Cotabambas',
                'departament_id' => '030000'
            ],
            [
                'id' => '030600',
                'name' => 'Chincheros',
                'departament_id' => '030000'
            ],
            [
                'id' => '030700',
                'name' => 'Grau',
                'departament_id' => '030000'
            ],
            [
                'id' => '040100',
                'name' => 'Arequipa',
                'departament_id' => '040000'
            ],
            [
                'id' => '040200',
                'name' => 'Camaná',
                'departament_id' => '040000'
            ],
            [
                'id' => '040300',
                'name' => 'Caravelí',
                'departament_id' => '040000'
            ],
            [
                'id' => '040400',
                'name' => 'Castilla',
                'departament_id' => '040000'
            ],
            [
                'id' => '040500',
                'name' => 'Caylloma',
                'departament_id' => '040000'
            ],
            [
                'id' => '040600',
                'name' => 'Condesuyos',
                'departament_id' => '040000'
            ],
            [
                'id' => '040700',
                'name' => 'Islay',
                'departament_id' => '040000'
            ],
            [
                'id' => '040800',
                'name' => 'La Unión',
                'departament_id' => '040000'
            ],
            [
                'id' => '050100',
                'name' => 'Huamanga',
                'departament_id' => '050000'
            ],
            [
                'id' => '050200',
                'name' => 'Cangallo',
                'departament_id' => '050000'
            ],
            [
                'id' => '050300',
                'name' => 'Huanca Sancos',
                'departament_id' => '050000'
            ],
            [
                'id' => '050400',
                'name' => 'Huanta',
                'departament_id' => '050000'
            ],
            [
                'id' => '050500',
                'name' => 'La Mar',
                'departament_id' => '050000'
            ],
            [
                'id' => '050600',
                'name' => 'Lucanas',
                'departament_id' => '050000'
            ],
            [
                'id' => '050700',
                'name' => 'Parinacochas',
                'departament_id' => '050000'
            ],
            [
                'id' => '050800',
                'name' => 'Páucar del Sara Sara',
                'departament_id' => '050000'
            ],
            [
                'id' => '050900',
                'name' => 'Sucre',
                'departament_id' => '050000'
            ],
            [
                'id' => '051000',
                'name' => 'Víctor Fajardo',
                'departament_id' => '050000'
            ],
            [
                'id' => '051100',
                'name' => 'Vilcas Huamán',
                'departament_id' => '050000'
            ],
            [
                'id' => '060100',
                'name' => 'Cajamarca',
                'departament_id' => '060000'
            ],
            [
                'id' => '060200',
                'name' => 'Cajabamba',
                'departament_id' => '060000'
            ],
            [
                'id' => '060300',
                'name' => 'Celendín',
                'departament_id' => '060000'
            ],
            [
                'id' => '060400',
                'name' => 'Chota',
                'departament_id' => '060000'
            ],
            [
                'id' => '060500',
                'name' => 'Contumazá',
                'departament_id' => '060000'
            ],
            [
                'id' => '060600',
                'name' => 'Cutervo',
                'departament_id' => '060000'
            ],
            [
                'id' => '060700',
                'name' => 'Hualgayoc',
                'departament_id' => '060000'
            ],
            [
                'id' => '060800',
                'name' => 'Jaén',
                'departament_id' => '060000'
            ],
            [
                'id' => '060900',
                'name' => 'San Ignacio',
                'departament_id' => '060000'
            ],
            [
                'id' => '061000',
                'name' => 'San Marcos',
                'departament_id' => '060000'
            ],
            [
                'id' => '061100',
                'name' => 'San Miguel',
                'departament_id' => '060000'
            ],
            [
                'id' => '061200',
                'name' => 'San Pablo',
                'departament_id' => '060000'
            ],
            [
                'id' => '061300',
                'name' => 'Santa Cruz',
                'departament_id' => '060000'
            ],
            [
                'id' => '070100',
                'name' => 'Prov. Const. del Callao',
                'departament_id' => '070000'
            ],
            [
                'id' => '080100',
                'name' => 'Cusco',
                'departament_id' => '080000'
            ],
            [
                'id' => '080200',
                'name' => 'Acomayo',
                'departament_id' => '080000'
            ],
            [
                'id' => '080300',
                'name' => 'Anta',
                'departament_id' => '080000'
            ],
            [
                'id' => '080400',
                'name' => 'Calca',
                'departament_id' => '080000'
            ],
            [
                'id' => '080500',
                'name' => 'Canas',
                'departament_id' => '080000'
            ],
            [
                'id' => '080600',
                'name' => 'Canchis',
                'departament_id' => '080000'
            ],
            [
                'id' => '080700',
                'name' => 'Chumbivilcas',
                'departament_id' => '080000'
            ],
            [
                'id' => '080800',
                'name' => 'Espinar',
                'departament_id' => '080000'
            ],
            [
                'id' => '080900',
                'name' => 'La Convención',
                'departament_id' => '080000'
            ],
            [
                'id' => '081000',
                'name' => 'Paruro',
                'departament_id' => '080000'
            ],
            [
                'id' => '081100',
                'name' => 'Paucartambo',
                'departament_id' => '080000'
            ],
            [
                'id' => '081200',
                'name' => 'Quispicanchi',
                'departament_id' => '080000'
            ],
            [
                'id' => '081300',
                'name' => 'Urubamba',
                'departament_id' => '080000'
            ],
            [
                'id' => '090100',
                'name' => 'Huancavelica',
                'departament_id' => '090000'
            ],
            [
                'id' => '090200',
                'name' => 'Acobamba',
                'departament_id' => '090000'
            ],
            [
                'id' => '090300',
                'name' => 'Angaraes',
                'departament_id' => '090000'
            ],
            [
                'id' => '090400',
                'name' => 'Castrovirreyna',
                'departament_id' => '090000'
            ],
            [
                'id' => '090500',
                'name' => 'Churcampa',
                'departament_id' => '090000'
            ],
            [
                'id' => '090600',
                'name' => 'Huaytará',
                'departament_id' => '090000'
            ],
            [
                'id' => '090700',
                'name' => 'Tayacaja',
                'departament_id' => '090000'
            ],
            [
                'id' => '100100',
                'name' => 'Huánuco',
                'departament_id' => '100000'
            ],
            [
                'id' => '100200',
                'name' => 'Ambo',
                'departament_id' => '100000'
            ],
            [
                'id' => '100300',
                'name' => 'Dos de Mayo',
                'departament_id' => '100000'
            ],
            [
                'id' => '100400',
                'name' => 'Huacaybamba',
                'departament_id' => '100000'
            ],
            [
                'id' => '100500',
                'name' => 'Huamalíes',
                'departament_id' => '100000'
            ],
            [
                'id' => '100600',
                'name' => 'Leoncio Prado',
                'departament_id' => '100000'
            ],
            [
                'id' => '100700',
                'name' => 'Marañón',
                'departament_id' => '100000'
            ],
            [
                'id' => '100800',
                'name' => 'Pachitea',
                'departament_id' => '100000'
            ],
            [
                'id' => '100900',
                'name' => 'Puerto Inca',
                'departament_id' => '100000'
            ],
            [
                'id' => '101000',
                'name' => 'Lauricocha',
                'departament_id' => '100000'
            ],
            [
                'id' => '101100',
                'name' => 'Yarowilca',
                'departament_id' => '100000'
            ],
            [
                'id' => '110100',
                'name' => 'Ica',
                'departament_id' => '110000'
            ],
            [
                'id' => '110200',
                'name' => 'Chincha',
                'departament_id' => '110000'
            ],
            [
                'id' => '110300',
                'name' => 'Nasca',
                'departament_id' => '110000'
            ],
            [
                'id' => '110400',
                'name' => 'Palpa',
                'departament_id' => '110000'
            ],
            [
                'id' => '110500',
                'name' => 'Pisco',
                'departament_id' => '110000'
            ],
            [
                'id' => '120100',
                'name' => 'Huancayo',
                'departament_id' => '120000'
            ],
            [
                'id' => '120200',
                'name' => 'Concepción',
                'departament_id' => '120000'
            ],
            [
                'id' => '120300',
                'name' => 'Chanchamayo',
                'departament_id' => '120000'
            ],
            [
                'id' => '120400',
                'name' => 'Jauja',
                'departament_id' => '120000'
            ],
            [
                'id' => '120500',
                'name' => 'Junín',
                'departament_id' => '120000'
            ],
            [
                'id' => '120600',
                'name' => 'Satipo',
                'departament_id' => '120000'
            ],
            [
                'id' => '120700',
                'name' => 'Tarma',
                'departament_id' => '120000'
            ],
            [
                'id' => '120800',
                'name' => 'Yauli',
                'departament_id' => '120000'
            ],
            [
                'id' => '120900',
                'name' => 'Chupaca',
                'departament_id' => '120000'
            ],
            [
                'id' => '130100',
                'name' => 'Trujillo',
                'departament_id' => '130000'
            ],
            [
                'id' => '130200',
                'name' => 'Ascope',
                'departament_id' => '130000'
            ],
            [
                'id' => '130300',
                'name' => 'Bolívar',
                'departament_id' => '130000'
            ],
            [
                'id' => '130400',
                'name' => 'Chepén',
                'departament_id' => '130000'
            ],
            [
                'id' => '130500',
                'name' => 'Julcán',
                'departament_id' => '130000'
            ],
            [
                'id' => '130600',
                'name' => 'Otuzco',
                'departament_id' => '130000'
            ],
            [
                'id' => '130700',
                'name' => 'Pacasmayo',
                'departament_id' => '130000'
            ],
            [
                'id' => '130800',
                'name' => 'Pataz',
                'departament_id' => '130000'
            ],
            [
                'id' => '130900',
                'name' => 'Sánchez Carrión',
                'departament_id' => '130000'
            ],
            [
                'id' => '131000',
                'name' => 'Santiago de Chuco',
                'departament_id' => '130000'
            ],
            [
                'id' => '131100',
                'name' => 'Gran Chimú',
                'departament_id' => '130000'
            ],
            [
                'id' => '131200',
                'name' => 'Virú',
                'departament_id' => '130000'
            ],
            [
                'id' => '140100',
                'name' => 'Chiclayo',
                'departament_id' => '140000'
            ],
            [
                'id' => '140200',
                'name' => 'Ferreñafe',
                'departament_id' => '140000'
            ],
            [
                'id' => '140300',
                'name' => 'Lambayeque',
                'departament_id' => '140000'
            ],
            [
                'id' => '150100',
                'name' => 'Lima',
                'departament_id' => '150000'
            ],
            [
                'id' => '150200',
                'name' => 'Barranca',
                'departament_id' => '150000'
            ],
            [
                'id' => '150300',
                'name' => 'Cajatambo',
                'departament_id' => '150000'
            ],
            [
                'id' => '150400',
                'name' => 'Canta',
                'departament_id' => '150000'
            ],
            [
                'id' => '150500',
                'name' => 'Cañete',
                'departament_id' => '150000'
            ],
            [
                'id' => '150600',
                'name' => 'Huaral',
                'departament_id' => '150000'
            ],
            [
                'id' => '150700',
                'name' => 'Huarochirí',
                'departament_id' => '150000'
            ],
            [
                'id' => '150800',
                'name' => 'Huaura',
                'departament_id' => '150000'
            ],
            [
                'id' => '150900',
                'name' => 'Oyón',
                'departament_id' => '150000'
            ],
            [
                'id' => '151000',
                'name' => 'Yauyos',
                'departament_id' => '150000'
            ],
            [
                'id' => '160100',
                'name' => 'Maynas',
                'departament_id' => '160000'
            ],
            [
                'id' => '160200',
                'name' => 'Alto Amazonas',
                'departament_id' => '160000'
            ],
            [
                'id' => '160300',
                'name' => 'Loreto',
                'departament_id' => '160000'
            ],
            [
                'id' => '160400',
                'name' => 'Mariscal Ramón Castilla',
                'departament_id' => '160000'
            ],
            [
                'id' => '160500',
                'name' => 'Requena',
                'departament_id' => '160000'
            ],
            [
                'id' => '160600',
                'name' => 'Ucayali',
                'departament_id' => '160000'
            ],
            [
                'id' => '160700',
                'name' => 'Datem del Marañón',
                'departament_id' => '160000'
            ],
            [
                'id' => '160800',
                'name' => 'Putumayo',
                'departament_id' => '160000'
            ],
            [
                'id' => '170100',
                'name' => 'Tambopata',
                'departament_id' => '170000'
            ],
            [
                'id' => '170200',
                'name' => 'Manu',
                'departament_id' => '170000'
            ],
            [
                'id' => '170300',
                'name' => 'Tahuamanu',
                'departament_id' => '170000'
            ],
            [
                'id' => '180100',
                'name' => 'Mariscal Nieto',
                'departament_id' => '180000'
            ],
            [
                'id' => '180200',
                'name' => 'General Sánchez Cerro',
                'departament_id' => '180000'
            ],
            [
                'id' => '180300',
                'name' => 'Ilo',
                'departament_id' => '180000'
            ],
            [
                'id' => '190100',
                'name' => 'Pasco',
                'departament_id' => '190000'
            ],
            [
                'id' => '190200',
                'name' => 'Daniel Alcides Carrión',
                'departament_id' => '190000'
            ],
            [
                'id' => '190300',
                'name' => 'Oxapampa',
                'departament_id' => '190000'
            ],
            [
                'id' => '200100',
                'name' => 'Piura',
                'departament_id' => '200000'
            ],
            [
                'id' => '200200',
                'name' => 'Ayabaca',
                'departament_id' => '200000'
            ],
            [
                'id' => '200300',
                'name' => 'Huancabamba',
                'departament_id' => '200000'
            ],
            [
                'id' => '200400',
                'name' => 'Morropón',
                'departament_id' => '200000'
            ],
            [
                'id' => '200500',
                'name' => 'Paita',
                'departament_id' => '200000'
            ],
            [
                'id' => '200600',
                'name' => 'Sullana',
                'departament_id' => '200000'
            ],
            [
                'id' => '200700',
                'name' => 'Talara',
                'departament_id' => '200000'
            ],
            [
                'id' => '200800',
                'name' => 'Sechura',
                'departament_id' => '200000'
            ],
            [
                'id' => '210100',
                'name' => 'Puno',
                'departament_id' => '210000'
            ],
            [
                'id' => '210200',
                'name' => 'Azángaro',
                'departament_id' => '210000'
            ],
            [
                'id' => '210300',
                'name' => 'Carabaya',
                'departament_id' => '210000'
            ],
            [
                'id' => '210400',
                'name' => 'Chucuito',
                'departament_id' => '210000'
            ],
            [
                'id' => '210500',
                'name' => 'El Collao',
                'departament_id' => '210000'
            ],
            [
                'id' => '210600',
                'name' => 'Huancané',
                'departament_id' => '210000'
            ],
            [
                'id' => '210700',
                'name' => 'Lampa',
                'departament_id' => '210000'
            ],
            [
                'id' => '210800',
                'name' => 'Melgar',
                'departament_id' => '210000'
            ],
            [
                'id' => '210900',
                'name' => 'Moho',
                'departament_id' => '210000'
            ],
            [
                'id' => '211000',
                'name' => 'San Antonio de Putina',
                'departament_id' => '210000'
            ],
            [
                'id' => '211100',
                'name' => 'San Román',
                'departament_id' => '210000'
            ],
            [
                'id' => '211200',
                'name' => 'Sandia',
                'departament_id' => '210000'
            ],
            [
                'id' => '211300',
                'name' => 'Yunguyo',
                'departament_id' => '210000'
            ],
            [
                'id' => '220100',
                'name' => 'Moyobamba',
                'departament_id' => '220000'
            ],
            [
                'id' => '220200',
                'name' => 'Bellavista',
                'departament_id' => '220000'
            ],
            [
                'id' => '220300',
                'name' => 'El Dorado',
                'departament_id' => '220000'
            ],
            [
                'id' => '220400',
                'name' => 'Huallaga',
                'departament_id' => '220000'
            ],
            [
                'id' => '220500',
                'name' => 'Lamas',
                'departament_id' => '220000'
            ],
            [
                'id' => '220600',
                'name' => 'Mariscal Cáceres',
                'departament_id' => '220000'
            ],
            [
                'id' => '220700',
                'name' => 'Picota',
                'departament_id' => '220000'
            ],
            [
                'id' => '220800',
                'name' => 'Rioja',
                'departament_id' => '220000'
            ],
            [
                'id' => '220900',
                'name' => 'San Martín',
                'departament_id' => '220000'
            ],
            [
                'id' => '221000',
                'name' => 'Tocache',
                'departament_id' => '220000'
            ],
            [
                'id' => '230100',
                'name' => 'Tacna',
                'departament_id' => '230000'
            ],
            [
                'id' => '230200',
                'name' => 'Candarave',
                'departament_id' => '230000'
            ],
            [
                'id' => '230300',
                'name' => 'Jorge Basadre',
                'departament_id' => '230000'
            ],
            [
                'id' => '230400',
                'name' => 'Tarata',
                'departament_id' => '230000'
            ],
            [
                'id' => '240100',
                'name' => 'Tumbes',
                'departament_id' => '240000'
            ],
            [
                'id' => '240200',
                'name' => 'Contralmirante Villar',
                'departament_id' => '240000'
            ],
            [
                'id' => '240300',
                'name' => 'Zarumilla',
                'departament_id' => '240000'
            ],
            [
                'id' => '250100',
                'name' => 'Coronel Portillo',
                'departament_id' => '250000'
            ],
            [
                'id' => '250200',
                'name' => 'Atalaya',
                'departament_id' => '250000'
            ],
            [
                'id' => '250300',
                'name' => 'Padre Abad',
                'departament_id' => '250000'
            ],
            [
                'id' => '250400',
                'name' => 'Purús',
                'departament_id' => '250000'
            ],
        ];

        DB::table( 'provinces' )->insert( $insert );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
