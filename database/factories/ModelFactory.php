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

$factory->define(DentalSleepSolutions\Eloquent\Payer::class, function ($faker) {

    $created = $faker->dateTimeThisDecade;
    $endpoints = ['coverage', 'cost estimate', 'fetch and append', 'proffessional claims'];
    $supported = [];
    foreach ($endpoints as $endpoint) {
        if (rand(0,1)) {
            $supported[] = [
                'endpoint' => $endpoint,
                'pass_through_fee' => 0,
                'enrollment_required' => $faker->randomElement([true, false]),
                'average_enrollment_process_time' => null,
                'enrollment_mandatory_fields' => $faker->randomElements([
                    'provider_name',
                    'address',
                    'npi',
                    'city',
                    'state',
                    'zip',
                ], rand(0,6)),
                'signature_required' => $faker->randomElement(false, true),
                'blue_ink_required' => $faker->randomElement(false, true),
                'message' => null,
                'status' => $status = $faker->randomElement(['available', 'unavailable']),
                'status_details' => ($status == 'available') ? 'Payer is working fine.' : 'Payer is down for maintenance',
                'status_updated_at' => $faker->dateTimeBetween($created),
            ];
        }
    }

    return [
        'payer_id' => strtoupper($faker->lexify('?????')),
        'names' => $faker->sentences(2),
        'created_at' => $created,
        'updated_at' => $faker->dateTimeBetween($created),
        'supported_endpoints' => $supported,
    ];
});

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

