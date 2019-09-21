<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Provider::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'business_name' => '',
        'type_person' => 1,
        'document' => rand(11111111, 99999999),
        'type_document' => '1',
        'email' => $faker->unique()->safeEmail,
        'address' => Str::random(20),
        'district_id' => '150101',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});
