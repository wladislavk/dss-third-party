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

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsuranceHistory::class, function ($faker) {
    return [
        'insuranceid'                       => $faker->randomDigit,
        'formid'                            => $faker->randomDigit,
        'patientid'                         => $faker->randomDigit,
        'pica1'                             => $faker->word,
        'pica2'                             => $faker->word,
        'pica3'                             => $faker->word,
        'insurance_type'                    => $faker->randomDigit,
        'insured_id_number'                 => $faker->word,
        'patient_firstname'                 => $faker->firstNameMale,
        'patient_lastname'                  => $faker->lastName,
        'patient_middle'                    => $faker->regexify('[A-Z]'),
        'patient_dob'                       => $faker->dateTime(),
        'patient_sex'                       => $faker->randomElement(['M', 'F']),
        'insured_firstname'                 => $faker->firstNameMale,
        'insured_lastname'                  => $faker->lastName,
        'insured_middle'                    => $faker->regexify('[A-Z]'),
        'patient_address'                   => $faker->address,
        'patient_relation_insured'          => $faker->randomElement(['Spouse', 'Self']),
        'insured_address'                   => $faker->address,
        'patient_city'                      => $faker->city,
        'patient_state'                     => $faker->stateAbbr,
        'patient_status'                    => $faker->regexify('~[A-Za-z]+~~'),
        'insured_city'                      => $faker->city,
        'insured_state'                     => $faker->stateAbbr,
        'patient_zip'                       => $faker->numerify('#####'),
        'patient_phone_code'                => $faker->numerify('###'),
        'patient_phone'                     => $faker->numerify('##########'),
        'insured_zip'                       => $faker->numerify('#####'),
        'insured_phone_code'                => $faker->numerify('###'),
        'insured_phone'                     => $faker->numerify('##########'),
        'other_insured_firstname'           => $faker->firstNameMale,
        'other_insured_lastname'            => $faker->lastName,
        'other_insured_middle'              => $faker->regexify('[A-Z]'),
        'employment'                        => $faker->randomElement(['NO', 'false', 'YES', 'true']),
        'auto_accident'                     => $faker->randomElement(['NO', 'false', 'YES', 'true']),
        'insured_policy_group_feca'         => $faker->word,
        'other_insured_policy_group_feca'   => $faker->word,
        'insured_dob'                       => $faker->dateTime(),
        'insured_sex'                       => $faker->randomElement(['M', 'F', 'Male', 'Female']),
        'other_insured_dob'                 => $faker->dateTime(),
        'other_insured_sex'                 => $faker->randomElement(['M', 'F', 'Male', 'Female']),
        'insured_employer_school_name'      => $faker->sentence($nbWords = 4),
        'insured_insurance_plan'            => $faker->sentence($nbWords = 4),
        'other_insured_insurance_plan'      => $faker->sentence($nbWords = 4),
        'another_plan'                      => $faker->randomElement(['NO', 'YES']),
        'patient_signature'                 => $faker->word,
        'patient_signed_date'               => $faker->dateTime(),
        'insured_signature'                 => $faker->word,
        'date_current'                      => $faker->dateTime(),
        'referring_provider'                => $faker->sentence($nbWords = 4),
        'field_17b'                         => $faker->word,
        'hospitalization_date_from'         => $faker->dateTime(),
        'hospitalization_date_to'           => $faker->dateTime(),
        'diagnosis_1'                       => $faker->word,
        'service_date1_from'                => $faker->dateTime(),
        'service_date1_to'                  => $faker->dateTime(),
        'place_of_service1'                 => $faker->word,
        'cpt_hcpcs1'                        => $faker->regexify('[A-Z][0-9]{4}'),
        's_charges1_1'                      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        's_charges1_2'                      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'service_date2_from'                => $faker->dateTime(),
        'service_date2_to'                  => $faker->dateTime(),
        'service_date3_from'                => $faker->dateTime(),
        'service_date3_to'                  => $faker->dateTime(),
        'service_date5_from'                => $faker->dateTime(),
        'service_date5_to'                  => $faker->dateTime(),
        'federal_tax_id_number'             => $faker->numerify('##########'),
        'ein'                               => $faker->numerify('#'),
        'accept_assignment'                 => $faker->randomElement(['Yes', 'No', 'A', 'C']),
        'total_charge'                      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'amount_paid'                       => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'balance_due'                       => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'signature_physician'               => $faker->word,
        'physician_signed_date'             => $faker->dateTime(),
        'service_facility_info_name'        => $faker->name,
        'service_facility_info_address'     => $faker->address,
        'service_facility_info_city'        => $faker->city,
        'service_info_a'                    => $faker->numerify('##########'),
        'billing_provider_phone_code'       => $faker->numerify('###'),
        'billing_provider_phone'            => $faker->numerify('##########'),
        'billing_provider_name'             => $faker->name,
        'billing_provider_address'          => $faker->address,
        'billing_provider_city'             => $faker->city,
        'billing_provider_a'                => $faker->numerify('##########'),
        'userid'                            => $faker->randomDigit,
        'docid'                             => $faker->randomDigit,
        'status'                            => $faker->randomDigit,
        'card'                              => $faker->randomDigit,
        'dispute_reason'                    => $faker->sentence($nbWords = 6),
        'primary_fdf'                       => $faker->regexify('fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf'),
        'secondary_fdf'                     => $faker->regexify('fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf'),
        'producer'                          => $faker->randomDigit,
        'mailed_date'                       => $faker->dateTime(),
        'p_m_eligible_payer_id'             => $faker->word,
        'p_m_eligible_payer_name'           => $faker->name,
        'other_insurance_type'              => $faker->word,
        'patient_relation_other_insured'    => $faker->randomElement(['Self', 'Spouse']),
        'p_m_billing_id'                    => $faker->word,
        'p_m_dss_file'                      => $faker->word,
        'other_insured_address'             => $faker->address,
        'other_insured_city'                => $faker->city,
        'other_insured_state'               => $faker->stateAbbr,
        'other_insured_zip'                 => $faker->numerify('#####'),
        'eligible_token'                    => $faker->regexify('[A-Za-z0-9]{20}'),
        'percase_date'                      => $faker->dateTime(),
        'percase_name'                      => $faker->name,
        'percase_amount'                    => $faker->regexify('[0-9]+\.[0-9]{2}'),
        'percase_status'                    => $faker->randomDigit,
        'percase_invoice'                   => $faker->randomDigit,
        'primary_claim_id'                  => $faker->randomDigit,
        'fo_paid_viewed'                    => $faker->randomDigit,
        'bo_paid_viewed'                    => $faker->randomDigit,
        'primary_claim_version'             => $faker->randomDigit,
        'secondary_claim_version'           => $faker->randomDigit,
        'icd_ind'                           => $faker->randomDigit,
        'name_referring_provider_qualifier' => $faker->regexify('[A-Z]{2}'),
        'diagnosis_a'                       => $faker->sentence($nbWords = 4),
        'updated_by_user'                   => $faker->randomDigit,
        'updated_by_admin'                  => $faker->randomDigit
    ];
});
