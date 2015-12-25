<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(DentalSleepSolutions\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Admin::class, function ($faker) {
    return [
        'name'         => 'PHPUnit admin',
        'username'     => $faker->userName,
        'password'     => bcrypt($faker->password),
        'status'       => $faker->randomDigit,
        'adddate'      => $faker->dateTime(),
        'ip_address'   => $faker->ipv4,
        'admin_access' => $faker->randomDigit,
        'email'        => $faker->email,
        'first_name'   => $faker->firstName,
        'last_name'    => $faker->lastName
    ];
});
