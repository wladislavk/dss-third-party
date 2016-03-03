<?php

use Carbon\Carbon;

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

$factory->define(DentalSleepSolutions\Eloquent\Dental\SummSleeplab::class, function ($faker) {
    return [
        'date' => $faker->word,
        'sleeptesttype' => $faker->word,
        'place' => $faker->word,
        'apnea' => $faker->word,
        'hypopnea' => $faker->word,
        'ahi' => $faker->word,
        'ahisupine' => $faker->word,
        'rdi' => $faker->word,
        'rdisupine' => $faker->word,
        'o2nadir' => $faker->word,
        't9002' => $faker->word,
        'sleepefficiency' => $faker->word,
        'cpaplevel' => $faker->word,
        'dentaldevice' => $faker->word,
        'devicesetting' => $faker->word,
        'diagnosis' => $faker->word,
        'notes' => $faker->word,
        'patiendid' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Qualifier::class, function ($faker) {
    return [
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\PlaceService::class, function ($faker) {
    return [
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\ClaimElectronic::class, function ($faker) {
    return [

    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Insurance::class, function ($faker) {
    return [
        'card' => $faker->numberBetween(1000, 9999),
        'patient_phone' => $faker->phoneNumber,
        'insured_phone' => $faker->phoneNumber,
        'p_m_eligible_payer_name' => $faker->word,
        'other_insured_firstname' => $faker->firstName,
        'other_insured_lastname' => $faker->lastName,
        'insured_firstname' => $faker->firstName,
        'insured_lastname' => $faker->lastName,

        'patient_address' => $faker->streetAddress,
        'patient_city' => $faker->phoneNumber,
        'patient_state' => $faker->stateAbbr,
        'patient_zip' => $faker->phoneNumber,

        'p_m_eligible_payer_id' => 60054,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsurancePreauth::class, function ($faker) {
    return [
        'doc_id' => $faker->randomDigit,
        'patient_id' => $faker->randomDigit,
        'ins_rank' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory::class, function ($faker) {
    return [];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsDiagnosis::class, function ($faker) {
    return [
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Ledger::class, function ($faker) {
    return [
        'placeofservice' => $faker->randomDigit,
        'emg' => $faker->word,
        'diagnosispointer' => $faker->word,
        'daysorunits' => $faker->word,
        'epsdt' => $faker->word,
        'idqual' => $faker->word,
        'modcode' => $faker->word,
        'amount' => 1,
        'modcode' => 21,
        'modcode2' => 22,
        'modcode3' => 24,
        'modcode4' => 25,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Patient::class, function ($faker) {
    return [
        'member_no' => $faker->randomDigit,
        'group_no' => $faker->randomDigit,
        'plan_no' => $faker->randomDigit,
        'p_m_partymname' => $faker->word,
        'p_m_partylname' => $faker->lastName,
        'p_m_partyfname' => $faker->firstName,

        'p_m_ins_grp' => $faker->word,
        's_m_ins_grp' => $faker->word,
        'p_m_ins_plan' => $faker->word,
        's_m_ins_plan' => $faker->word,
        'p_m_dss_file' => $faker->word,
        's_m_dss_file' => $faker->word,
        'p_m_ins_type' => $faker->word,
        's_m_ins_type' => $faker->word,
        'p_m_ins_ass' => $faker->word,
        's_m_ins_ass' => $faker->word,
        'dob' => $faker->dateTime,
        'ins_dob' => $faker->dateTime,
        'ins2_dob' => $faker->dateTime,

        'premed' => $faker->word,
        'docsleep' => $faker->word,
        'docpcp' => $faker->word,
        'docdentist' => $faker->word,
        'docent' => $faker->word,
        'docmdother' => $faker->word,

        'docmdother2' => $faker->word,
        'docmdother3' => $faker->word,

        'gender' => "Male",
        'lastname' => $faker->lastName,
        'firstname' => $faker->firstName,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\TransactionCode::class, function ($faker) {
    return [
        'type' => $faker->word,
        'ip_address' => $faker->ipv4,
        'transaction_code' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\User::class, function ($faker) {
    return [
        'npi' => 1111111111,
        'city' => '435 Sugar Lane',
        'state' => 'CA',
        'zip' => '941233476',
        'fax' => $faker->word,
        'tax_id_or_ssn' => "111111111",
        'medicare_ptan' => $faker->randomNumber(),
        'address' => $faker->streetAddress,
        //'phone' => $faker->phoneNumber,
        'ein' => 1,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\UserCompany::class, function ($faker) {
    return [];
});


$factory->define(DentalSleepSolutions\Eloquent\Dental\AppointmentType::class, function ($faker) {
    return [
        'name'      => $faker->word,
        'color'     => $faker->hexcolor,
        'classname' => $faker->word,
        'docid'     => $faker->randomDigit()
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\AccessCode::class, function ($faker) {
    return [
        'access_code' => $faker->word,
        'notes'       => $faker->sentence($nbWords = 6),
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4,
        'plan_id'     => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment::class, function ($faker) {
    return [
        'note_id'    => $faker->randomDigit,
        'filename'   => $faker->sentence($nbWords = 6),
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Complaint::class, function ($faker) {
    return [
        'complaint'   => $faker->sentence($nbWords = 6),
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\CustomText::class, function ($faker) {
    return [
        'title'        => $faker->sentence($nbWords = 3),
        'description'  => $faker->sentence($nbWords = 6),
        'docid'        => $faker->randomDigit,
        'status'       => $faker->randomDigit,
        'adddate'      => $faker->dateTime(),
        'ip_address'   => $faker->ipv4,
        'default_text' => $faker->randomDigit,
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
        'ip_address'           => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Device::class, function ($faker) {
    return [
        'device'      => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4,
        'image_path'  => $faker->regexify('dental_device_[0-9]{2}\.(gif|jpg|jpeg|png)'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\ContactType::class, function ($faker) {
    return [
        'contacttype' => $faker->sentence($nbWords = 3),
        'ip_address'  => $faker->ipv4,
        'physician'   => $faker->randomDigit,
        'corporate'   => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Calendar::class, function ($faker) {
    return [
        'start_date'   => Carbon::now()->addDays(1),
        'end_date'     => Carbon::now()->addDays(2),
        'description'  => $faker->sentence($nbWords = 6),
        'event_id'     => $faker->regexify('[0-9]{13}'),
        'docid'        => $faker->randomDigit,
        'adddate'      => $faker->dateTime(),
        'ip_address'   => $faker->ipv4,
        'category'     => $faker->word,
        'producer_id'  => $faker->randomDigit,
        'patientid'    => $faker->randomDigit,
        'rec_type'     => $faker->word,
        'event_length' => $faker->regexify('[0-9]{4}'),
        'event_pid'    => $faker->regexify('[0-9]{4}'),
        'res_id'       => $faker->randomDigit,
        'rec_pattern'  => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Patient::class, function ($faker) {
    return [
        'lastname'                => $faker->lastName,
        'firstname'               => $faker->firstNameMale,
        'middlename'              => $faker->regexify('[A-Z]'),
        'salutation'              => $faker->title($gender = null|'male'|'female'),
        'member_no'               => $faker->word,
        'group_no'                => $faker->numerify('##'),
        'plan_no'                 => $faker->numerify('##'),
        'dob'                     => $dateTime()->format('m/d/Y'),
        'add1'                    => $faker->address,
        'add2'                    => $faker->address,
        'city'                    => $faker->city,
        'state'                   => $faker->stateAbbr,
        'zip'                     => $faker->numerify('#####'),
        'gender'                  => $faker->randomElement(['Male', 'Female']),
        'marital_status'          => $faker->randomElement(['Married', 'Un-Married', 'Single']),
        'ssn'                     => $faker->numerify('#########'),
        'internal_patient'        => $faker->word,
        'home_phone'              => $faker->numerify('##########'),
        'work_phone'              => $faker->numerify('##########'),
        'cell_phone'              => $faker->numerify('##########'),
        'email'                   => $faker->email,
        'patient_notes'           => $faker->sentence($nbWords = 5),
        'alert_text'              => $faker->sentence($nbWords = 4),
        'display_alert'           => $faker->randomDigit,
        'userid'                  => $faker->randomDigit,
        'docid'                   => $faker->randomDigit,
        'status'                  => $faker->randomDigit,
        'adddate'                 => $faker->dateTime(),
        'ip_address'              => $faker->ipv4,
        'p_d_party'               => $faker->word,
        'p_d_relation'            => $faker->word,
        'p_d_other'               => $faker->word,
        'p_d_employer'            => $faker->word,
        'p_d_ins_co'              => $faker->word,
        'p_d_ins_id'              => $faker->word,
        's_d_party'               => $faker->word,
        's_d_relation'            => $faker->word,
        's_d_other'               => $faker->word,
        's_d_employer'            => $faker->word,
        's_d_ins_co'              => $faker->word,
        's_d_ins_id'              => $faker->word,
        'p_m_partyfname'          => $faker->firstNameMale,
        'p_m_partymname'          => $faker->regexify('[A-Z]'),
        'p_m_partylname'          => $faker->lastName,
        'p_m_relation'            => $faker->word,
        'p_m_other'               => $faker->word,
        'p_m_employer'            => $faker->word,
        'p_m_ins_co'              => $faker->word,
        'p_m_ins_id'              => $faker->word,
        's_m_partyfname'          => $faker->firstNameMale,
        's_m_partymname'          => $faker->regexify('[A-Z]'),
        's_m_partylname'          => $faker->lastName,
        's_m_relation'            => $faker->word,
        's_m_other'               => $faker->word,
        's_m_employer'            => $faker->word,
        's_m_ins_co'              => $faker->word,
        's_m_ins_id'              => $faker->word,
        'p_m_ins_grp'             => $faker->word,
        's_m_ins_grp'             => $faker->word,
        'p_m_ins_plan'            => $faker->word,
        's_m_ins_plan'            => $faker->word,
        'p_m_dss_file'            => $faker->word,
        's_m_dss_file'            => $faker->word,
        'p_m_ins_type'            => $faker->word,
        's_m_ins_type'            => $faker->word,
        'p_m_ins_ass'             => $faker->word,
        's_m_ins_ass'             => $faker->word,
        'ins_dob'                 => $faker->dateTime(),
        'ins2_dob'                => $faker->dateTime(),
        'employer'                => $faker->word,
        'emp_add1'                => $faker->address,
        'emp_add2'                => $faker->address,
        'emp_city'                => $faker->city,
        'emp_state'               => $faker->stateAbbr,
        'emp_zip'                 => $faker->numerify('#####'),
        'emp_phone'               => $faker->numerify('##########'),
        'emp_fax'                 => $faker->numerify('##########'),
        'plan_name'               => $faker->word,
        'group_number'            => $faker->word,
        'ins_type'                => $faker->word,
        'accept_assignment'       => $faker->word,
        'print_signature'         => $faker->word,
        'medical_insurance'       => $faker->word,
        'mark_yes'                => $faker->word,
        'inactive'                => $faker->word,
        'partner_name'            => $faker->word,
        'emergency_name'          => $faker->word,
        'emergency_number'        => $faker->word,
        'referred_source'         => $faker->word,
        'referred_by'             => $faker->word,
        'premedcheck'             => $faker->randomDigit,
        'premed'                  => $faker->word,
        'docsleep'                => $faker->word,
        'docpcp'                  => $faker->word,
        'docdentist'              => $faker->word,
        'docent'                  => $faker->word,
        'docmdother'              => $faker->word,
        'preferredcontact'        => $faker->randomElement(['email', 'paper']),
        'copyreqdate'             => $dateTime()->format('m/d/Y'),
        'best_time'               => $faker->randomElement(['morning', 'midday', 'evening']),
        'best_number'             => $faker->randomElement(['home', 'work']),
        'emergency_relationship'  => $faker->word,
        'has_s_m_ins'             => $faker->randomElement(['No', 'Yes']),
        'referred_notes'          => $faker->sentence($nbWords = 5),
        'login'                   => 'string',
        'password'                => 'string',
        'salt'                    => 'string',
        'recover_hash'            => 'string',
        'recover_time'            => 'date',
        'registered'              => 'integer',
        'access_code'             => 'string',
        'parent_patientid'        => 'integer',
        'has_p_m_ins'             => 'string',
        'registration_status'     => 'integer',
        'text_date'               => 'date',
        'text_num'                => 'integer',
        'use_patient_portal'      => 'integer',
        'registration_senton'     => 'date',
        'preferred_name'          => 'string',
        'feet'                    => 'string',
        'inches'                  => 'string',
        'weight'                  => 'string',
        'bmi'                     => 'string',
        'symptoms_status'         => 'integer',
        'sleep_status'            => 'integer',
        'treatments_status'       => 'integer',
        'history_status'          => 'integer',
        'access_code_date'        => 'date',
        'email_bounce'            => 'integer',
        'docmdother2'             => 'string',
        'docmdother3'             => 'string',
        'last_reg_sect'           => 'integer',
        'access_type'             => 'integer',
        'p_m_eligible_id'         => 'string',
        'p_m_eligible_payer_id'   => 'string',
        'p_m_eligible_payer_name' => 'string',
        'p_m_gender'              => 'string',
        's_m_gender'              => 'string',
        'p_m_same_address'        => 'integer',
        'p_m_address'             => 'string',
        'p_m_state'               => 'string',
        'p_m_city'                => 'string',
        'p_m_zip'                 => 'regex:/[0-9]{5}/',
        's_m_same_address'        => 'string',
        's_m_address'             => 'string',
        's_m_city'                => 'string',
        's_m_state'               => 'string',
        's_m_zip'                 => 'regex:/[0-9]{5}/',
        'new_fee_date'            => 'date',
        'new_fee_amount'          => 'regex:/^[0-9]+\.[0-9]{2}$/',
        'new_fee_desc'            => 'string',
        'new_fee_invoice_id'      => 'integer',
        's_m_eligible_payer_id'   => 'string',
        's_m_eligible_payer_name' => 'string'
    ];
});
