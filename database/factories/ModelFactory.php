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

$factory->define(DentalSleepSolutions\Eloquent\Company::class, function ($faker) {
    return [
        'name'       => $faker->name,
        'add1'       => $faker->address,
        'add2'       => $faker->address,
        'city'       => $faker->city,
        'state'      => $faker->state,
        'zip'        => $faker->regexify('[0-9]{5}'),
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4,
        'phone'      => $faker->regexify('1[0-9]{11}'),
        'email'      => $faker->email
    ];
});
