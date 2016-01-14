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

$factory->define(DentalSleepSolutions\Eloquent\Enrollments\Enrollment::class, function ($faker) {
    return [
        'reference_id' => 51,
        'status' => 0,
        'transaction_type_id' => 1,
    ];
});
