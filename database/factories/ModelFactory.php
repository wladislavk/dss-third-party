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

$factory->define(DentalSleepSolutions\Eloquent\Dental\ContactType::class, function ($faker) {
    return [
        'contacttype' => $faker->regexify('[A-Za-z]{200}'),
        'description' => $faker->regexify('[A-Za-z]'),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->regexify('[0-9]{1}'),
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4,
        'physician'   => $faker->regexify('[0-9]{1}'),
        'corporate'   => $faker->regexify('[0-9]{1}')
    ];
});
