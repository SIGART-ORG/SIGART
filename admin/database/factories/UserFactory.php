<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        //'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'document' => rand(11111111, 99999999),
        'address' => Str::random(20),
        'birthday' => date( 'Y-m-d' ),
        'date_entry' => date( 'Y-m-d' ),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'phone' => rand(900000000, 999999999),
        'role_id' => rand(1, 6),
        'created_at' => date( 'Y-m-d H:i:s' ),
        'updated_at' => date( 'Y-m-d H:i:s' )
    ];
});
