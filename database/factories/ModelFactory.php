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
    return [];
});

$factory->define(DentalSleepSolutions\Eloquent\MemoAdmin::class, function ($faker) {
    return [
        'memo' => 'PHPUnit updated memo',
        'last_update' => $faker->date('Y-m-d'),
        'off_date' => $faker->date('Y-m-d'),
    ];
});

