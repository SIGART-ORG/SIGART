<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lastname' => $faker->lastName,
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
