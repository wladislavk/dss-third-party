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

$factory->define(DentalSleepSolutions\Models\ClaimElectronic::class, function ($faker) {
    return [
        'claimid'         => $faker->randomDigit,
        'response'        => $faker->randomDigit,
        'adddate'         => $faker->dateTime(),
        'ip_address'      => $faker->ipv4,
        'reference_id'    => $faker->regexify('[0-9]{8}'),
        'percase_date'    => $faker->dateTime(),
        'percase_name'    => $faker->regexify('[A-Za-z]'),
        'percase_amount'  => $faker->regexify('^\d*(\.\d{2})?$'),
        'percase_status'  => $faker->regexify('[0-9]{1}'),
        'percase_invoice' => $faker->randomDigit,
        'percase_free'    => $faker->regexify('[0-9]{1}')
    ];
});
