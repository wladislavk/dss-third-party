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

$factory->define(DentalSleepSolutions\Eloquent\Models\Payer::class, function ($faker) {

    $created = $faker->dateTimeThisDecade;
    $endpoints = ['coverage', 'cost estimate', 'fetch and append', 'proffessional claims'];
    $supported = [];
    foreach ($endpoints as $endpoint) {
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
            ], rand(1, 6)),
            'signature_required' => $faker->randomElement(false, true),
            'blue_ink_required' => $faker->randomElement(false, true),
            'message' => null,
            'status' => $status = $faker->randomElement(['available', 'unavailable']),
            'status_details' => ($status == 'available') ? 'Payer is working fine.' : 'Payer is down for maintenance',
            'status_updated_at' => $faker->dateTimeBetween($created),
        ];
    }

    return [
        'payer_id' => strtoupper($faker->lexify('?????')),
        'names' => $faker->sentences(2),
        'created_at' => $created,
        'updated_at' => $faker->dateTimeBetween($created),
        'supported_endpoints' => $supported,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Admin::class, function ($faker) {
    return [
        'name'         => 'PHPUnit admin',
        'username'     => $faker->userName,
        'password'     => $faker->password,
        'status'       => $faker->randomDigit,
        'adddate'      => $faker->dateTime(),
        'ip_address'   => $faker->ipv4,
        'admin_access' => $faker->randomDigit,
        'email'        => $faker->email,
        'first_name'   => $faker->firstName,
        'last_name'    => $faker->lastName
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Company::class, function ($faker) {
    return [
        'name'       => $faker->word,
        'add1'       => $faker->address,
        'state'      => $faker->state,
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\MemoAdmin::class, function ($faker) {
    return [
        'memo' => 'PHPUnit updated memo',
        'last_update' => $faker->date('Y-m-d'),
        'off_date' => $faker->date('Y-m-d'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\AdminCompany::class, function ($faker) {
    return [
        'adminid'    => $faker->randomDigit,
        'companyid'  => $faker->randomDigit,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\EdxCertificate::class, function ($faker) {
    return [
        'url'               => $faker->url,
        'edx_id'            => $faker->randomDigit,
        'course_name'       => $faker->sentence($nbWords = 3),
        'course_section'    => $faker->sentence($nbWords = 3),
        'course_subsection' => $faker->sentence($nbWords = 3),
        'number_ce'         => $faker->randomDigit,
        'adddate'           => $faker->dateTime(),
        'ip_address'        => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Filemanager::class, function ($faker) {
    return [
        'docid'   => $faker->randomDigit,
        'name'    => $faker->regexify('[A-Za-z0-9_]{15}\.(gif|jpg|jpeg|bmp|png)'),
        'type'    => $faker->randomElement(['image/jpeg', 'image/gif', 'image/bmp']),
        'size'    => $faker->randomNumber(),
        'ext'     => $faker->regexify('(gif|jpg|jpeg|bmp|png)'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\FlowsheetSegment::class, function ($faker) {
    return [
        'section' => $faker->word,
        'content' => $faker->sentence($nbWords = 6),
        'sortby'  => $faker->randomDigit,
    ];
});
