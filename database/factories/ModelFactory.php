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

$factory->define(DentalSleepSolutions\Eloquent\Dental\Contact::class, function ($faker) {
    return [
        'docid'                => $faker->randomDigit,
        'salutation'           => $faker->title($gender = 'male'|'female'),
        'lastname'             => $faker->lastName,
        'firstname'            => $faker->firstName($gender = 'male'|'female'),
        'middlename'           => $faker->word,
        'company'              => $faker->company,
        'add1'                 => $faker->address,
        'add2'                 => $faker->address,
        'city'                 => $faker->city,
        'state'                => $faker->state,
        'zip'                  => $faker->postcode,
        'phone1'               => $faker->regexify('^1[0-9]{9}$'),
        'phone2'               => $faker->regexify('^1[0-9]{9}$'),
        'fax'                  => $faker->regexify('^1[0-9]{9}$'),
        'email'                => $faker->email,
        'national_provider_id' => $faker->regexify('^[0-9]{9}$'),
        'qualifier'            => $faker->word,
        'qualifierid'          => $faker->word,
        'greeting'             => $faker->title($gender = 'male'|'female'),
        'sincerely'            => $faker->title($gender = 'male'|'female'),
        'contacttypeid'        => $faker->randomDigit,
        'notes'                => $faker->sentence($nbWords = 6),
        'preferredcontact'     => $faker->word,
        'status'               => $faker->randomDigit,
        'referredby_info'      => $faker->randomDigit,
        'referredby_notes'     => $faker->sentence($nbWords = 6),
        'merge_id'             => $faker->randomDigit,
        'merge_date'           => $faker->dateTime(),
        'corporate'            => $faker->randomDigit,
        'dea_number'           => $faker->word,
        'adddate'              => $faker->dateTime(),
        'ip_address'           => $faker->ipv4
    ];
});
