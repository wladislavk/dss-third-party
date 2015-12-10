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

$factory->define(DentalSleepSolutions\Models\Charge::class, function ($faker) {
    return [
        'amount'                  => $faker->regexify('[\d]{11},[\d]{2}'),
        'userid'                  => $faker->randomDigit,
        'adminid'                 => $faker->randomDigit,
        'charge_date'             => $faker->dateTime(),
        'stripe_customer'         => $faker->regexify('cus_[A-Z0-9a-z]{14}'),
        'stripe_charge'           => $faker->regexify('ch_[A-Z0-9a-z]{20}'),
        'stripe_card_fingerprint' => $faker->regexify('[A-Z0-9a-z]{30}'),
        'adddate'                 => $faker->dateTime(),
        'ip_address'              => $faker->ipv4,
        'invoice_id'              => $faker->randomDigit,
        'status'                  => $faker->randomDigit
    ];
});
