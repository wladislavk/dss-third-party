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

$factory->define(DentalSleepSolutions\Eloquent\Dental\Symptom::class, function ($faker) {
    $complaintIds = [
        '1|5~10|6~11|2~12|19~13|4~14|18~15|17~16|1~0|1~',
        '1|1~11|4~17|2~20|5~22|6~26|3~0|1~',
        '1|1~11|1~12|1~13|1~15|1~19|1~22|1~0|1~'
    ];

    return [
        'formid'                 => $faker->randomDigit,
        'patientid'              => $faker->randomDigit,
        'member_no'              => $faker->word,
        'group_no'               => $faker->word,
        'plan_no'                => $faker->word,
        'primary_care_physician' => $faker->word,
        'feet'                   => $faker->numerify('##'),
        'inches'                 => $faker->numerify('##'),
        'weight'                 => $faker->numerify('##'),
        'bmi'                    => $faker->numerify('###.##'),
        'sleep_qual'             => $faker->numerify('##'),
        'complaintid'            => $faker->randomElement($complaintIds),
        'other_complaint'        => $faker->sentence($nbWords = 5),
        'additional_paragraph'   => $faker->sentence($nbWords = 5),
        'energy_level'           => $faker->numerify('##'),
        'snoring_sound'          => $faker->numerify('##'),
        'wake_night'             => $faker->numerify('##'),
        'breathing_night'        => $faker->sentence($nbWords = 5),
        'morning_headaches'      => $faker->sentence($nbWords = 5),
        'hours_sleep'            => $faker->numerify('##'),
        'userid'                 => $faker->randomDigit,
        'docid'                  => $faker->randomDigit,
        'status'                 => $faker->randomDigit,
        'adddate'                => $faker->dateTime(),
        'ip_address'             => $faker->ipv4,
        'quit_breathing'         => $faker->sentence($nbWords = 5),
        'bed_time_partner'       => $faker->randomElement(['Yes', 'Sometimes', 'No']),
        'sleep_same_room'        => $faker->randomElement(['Yes', 'Sometimes', 'No']),
        'told_you_snore'         => $faker->randomElement(['Yes', 'Sometimes', 'No']),
        'main_reason'            => $faker->sentence($nbWords = 5),
        'main_reason_other'      => $faker->sentence($nbWords = 5),
        'exam_date'              => $faker->dateTime(),
        'chief_complaint_text'   => $faker->sentence($nbWords = 5),
        'tss'                    => $faker->numerify('##'),
        'ess'                    => $faker->numerify('##'),
        'parent_patientid'       => $faker->randomDigit
    ];
});
