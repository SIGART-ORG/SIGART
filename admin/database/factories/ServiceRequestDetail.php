<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define( App\Models\ServiceRequestDetail::class, function (Faker $faker) {
    return [
        'service_requests_id' => rand(1, 50),
        'name' => $faker->text( 20 ),
        'quantity' => rand(1, 50),
        'description' => $faker->text(),
        'assumed_customer' => rand(0, 1),
        'created_at' => date( 'Y-m-d H:i:s' ),
        'updated_at' => date( 'Y-m-d H:i:s' )
    ];
});
