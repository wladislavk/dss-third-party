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
    $insuranceDiagnoses = [
        '039.3 ACTINOMYCOTIC INFECTION CERVICOFACIAL (3)',
        '053.12 POSTHERPETIC TRIGEMINAL NEURALGIA (5)',
        '053.13 POSTHERPETIC POLYNEUROPATHY (6)'
    ];

    return [
        'ins_diagnosis' => $faker->randomElement($insuranceDiagnoses),
        'description'   => $faker->sentence($nbWords = 6),
        'sortby'        => $faker->randomDigit,
        'status'        => $faker->randomDigit,
        'adddate'       => $faker->dateTime(),
        'ip_address'    => $faker->ipv4
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

$factory->define(DentalSleepSolutions\Eloquent\Dental\ChangeList::class, function ($faker) {
    return [
        'content'    => $faker->paragraph($nbSentences = 3),
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
$factory->define(DentalSleepSolutions\Eloquent\Dental\Allergen::class, function ($faker) {
    return [
        'allergens'   => $faker->word,

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

$factory->define(DentalSleepSolutions\Eloquent\Dental\Charge::class, function ($faker) {
    return [
        'amount'                  => $faker->regexify('^\d*(\.\d{2})?$'),
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

$factory->define(DentalSleepSolutions\Eloquent\Dental\GuideSettingOption::class, function ($faker) {
    return [
        'option_id'  => $faker->randomDigit,
        'setting_id' => $faker->randomDigit,
        'label'      => $faker->sentence($nbWords = 3),
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting::class, function ($faker) {
    return [
        'device_id'  => $faker->randomDigit,
        'setting_id' => $faker->randomDigit,
        'value'      => $faker->randomDigit,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Document::class, function ($faker) {
    return [
        'categoryid' => $faker->randomDigit,
        'name'       => $faker->word,
        'filename'   => $faker->regexify('[A-Za-z0-9]{15}\.(gif|jpg|jpeg|png)'),
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\GuideDevice::class, function ($faker) {
    return [
        'name'       => $faker->name,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LoginDetail::class, function ($faker) {
    return [
        'loginid'    => $faker->randomDigit,
        'userid'     => $faker->randomDigit,
        'cur_page'   => $faker->word,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\DocumentCategory::class, function ($faker) {
    return [
        'name'       => $faker->name,
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsurancePayer::class, function ($faker) {
    return [
        'name'       => $faker->sentence($nbWords = 5),
        'payer_id'   => $faker->numerify('#####'),
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\GuideSetting::class, function ($faker) {
    return [
        'name'              => $faker->name,
        'setting_type'      => $faker->randomDigit,
        'range_start'       => $faker->randomDigit,
        'range_end'         => $faker->randomDigit,
        'adddate'           => $faker->dateTime(),
        'ip_address'        => $faker->ipv4,
        'rank'              => $faker->randomDigit,
        'options'           => $faker->randomDigit,
        'range_start_label' => $faker->word,
        'range_end_label'   => $faker->word
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Diagnostic::class, function ($faker) {
    return [
        'diagnostic'  => $faker->sentence($nbWords = 6),
        'description' => $faker->paragraph,
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\FaxErrorCode::class, function ($faker) {
    return [
        'error_code'  => $faker->numerify('2####'),
        'description' => $faker->sentence($nbWords = 6),
        'resolution'  => $faker->sentence($nbWords = 8),
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale::class, function ($faker) {
    return [
        'epworth'     => $faker->sentence($nbWords = 4),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsuranceType::class, function ($faker) {
    return [
        'ins_type'    => $faker->sentence($nbWords = 5),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsuranceDocument::class, function ($faker) {
    return [
        'title'       => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'video_file'  => $faker->regexify('[A-Za-z0-9]{15}\.flv'),
        'doc_file'    => $faker->regexify('[A-Za-z0-9]{15}\.(gif|jpg|jpeg|png)'),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4,
        'docid'       => $faker->regexify('[0-9]{2}')
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Fax::class, function ($faker) {
    $sentDate = $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now');
    $partOfFilename = $sentDate->format('Y-m-d_H-i-s');

    return [
        'patientid'            => $faker->randomDigit,
        'userid'               => $faker->randomDigit,
        'docid'                => $faker->randomDigit,
        'sent_date'            => $sentDate,
        'pages'                => $faker->randomDigit,
        'contactid'            => $faker->randomDigit,
        'to_number'            => $faker->numerify('##########'),
        'to_name'              => $faker->name,
        'letterid'             => $faker->randomDigit,
        'filename'             => $faker->regexify('f[0-9]_p[0-9]{2}_u[0-9]_' . $partOfFilename . '\.pdf'),
        'status'               => $faker->randomDigit,
        'adddate'              => $sentDate,
        'ip_address'           => $faker->ipv4,
        'fax_invoice_id'       => $faker->randomDigit,
        'sfax_transmission_id' => $faker->numerify('###################'),
        'sfax_completed'       => $faker->boolean($chanceOfGettingTrue = 50),
        'sfax_status'          => $faker->randomDigit,
        'viewed'               => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam::class, function ($faker) {
    return [
        'formid'           => $faker->randomDigit,
        'patientid'        => $faker->randomDigit,
        'mallampati'       => $faker->regexify('^Class (I{1,3}|IV)$'),
        'tonsils'          => $faker->randomElement([
            '~Present~',
            '~Obstructive~'
        ]),
        'tonsils_grade'    => $faker->regexify('^Grade [0-3]$'),
        'userid'           => $faker->randomDigit,
        'docid'            => $faker->randomDigit,
        'status'           => $faker->randomDigit,
        'adddate'          => $faker->dateTime(),
        'ip_address'       => $faker->ipv4,
        'additional_notes' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam::class, function ($faker) {
    return [
        'formid'               => $faker->randomDigit,
        'patientid'            => $faker->randomDigit,
        'blood_pressure'       => $faker->regexify('[1-2][0-9]{2}\/([5-9][0-9]|1[0-9]{2})'),
        'pulse'                => $faker->randomDigit,
        'neck_measurement'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 60),
        'bmi'                  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 40),
        'additional_paragraph' => $faker->sentence($nbWords = 3),
        'tongue'               => $faker->regexify('~([0-9]~)+'),
        'userid'               => $faker->randomDigit,
        'docid'                => $faker->randomDigit,
        'status'               => $faker->randomDigit,
        'adddate'              => $faker->dateTime(),
        'ip_address'           => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation::class, function ($faker) {
    return [
        'formid'               => $faker->randomDigit,
        'patientid'            => $faker->randomDigit,
        'maxilla'              => $faker->regexify('~([0-9]~)+'),
        'other_maxilla'        => $faker->sentence($nbWords = 3),
        'mandible'             => $faker->regexify('~([0-9]~)+'),
        'other_mandible'       => $faker->sentence($nbWords = 3),
        'soft_palate'          => $faker->regexify('~([0-9]~)+'),
        'other_soft_palate'    => $faker->sentence($nbWords = 3),
        'uvula'                => $faker->regexify('~([0-9]~)+'),
        'other_uvula'          => $faker->sentence($nbWords = 3),
        'gag_reflex'           => $faker->regexify('~([0-9]~)+'),
        'other_gag_reflex'     => $faker->sentence($nbWords = 3),
        'nasal_passages'       => $faker->regexify('~([0-9]~)+'),
        'other_nasal_passages' => $faker->sentence($nbWords = 3),
        'userid'               => $faker->randomDigit,
        'docid'                => $faker->randomDigit,
        'status'               => $faker->randomDigit,
        'adddate'              => $faker->dateTime(),
        'ip_address'           => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam::class, function ($faker) {
    $teethNumbers = [
        'A, B, C, 01, 02, 03, 17, 18, 19',
        '04, 05, 20, 25',
        '01, 04, 07',
        '06, 07, 08, 09, 22, 23',
        '06, 07, 08, 09, 10, 11',
        'C, E, G, I, 10, 23, 24, 25',
        '18, 19, 26, 27',
        'B, C, 18, 19',
        '09, 22, 23, 26, 28, 30, 31'
    ];

    $dentalClasses = [
        'I (normal)',
        'II (Retrognathic)(Retruded Lower Jaw)',
        'III (Prognathic)(Protruded Lower Jaw)'
    ];

    $teethPairs = [
        '05/21', '22/07', '25/10', '02/18',
        '02/03', '09/25', '09/10', '04/20'
    ];

    return [
        'formid'                           => $faker->randomDigit,
        'patientid'                        => $faker->randomDigit,
        'exam_teeth'                       => $faker->regexify('~([0-9]~)+'),
        'other_exam_teeth'                 => $faker->sentence($nbWords = 4),
        'caries'                           => $faker->randomElement($teethNumbers),
        'where_facets'                     => $faker->randomElement($teethNumbers),
        'cracked_fractured'                => $faker->randomElement($teethNumbers),
        'old_worn_inadequate_restorations' => $faker->randomElement($teethNumbers),
        'dental_class_right'               => $faker->randomElement($dentalClasses),
        'dental_division_right'            => $faker->numerify('#'),
        'dental_class_left'                => $faker->randomElement($dentalClasses),
        'dental_division_left'             => $faker->numerify('#'),
        'additional_paragraph'             => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'initial_tooth'                    => $faker->randomElement($teethPairs),
        'open_proximal'                    => $faker->randomElement($teethPairs),
        'deistema'                         => $faker->randomElement($teethPairs),
        'userid'                           => $faker->randomDigit,
        'docid'                            => $faker->randomDigit,
        'status'                           => $faker->randomDigit,
        'adddate'                          => $faker->dateTime(),
        'ip_address'                       => $faker->ipv4,
        'missing'                          => $faker->randomElement($teethNumbers),
        'crossbite'                        => $faker->randomElement($teethPairs)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam::class, function ($faker) {
    $palpation = [
        '1|1~3|4~5|0~',
        '1|0~2|0~3|0~4|0~5|0~6|0~7|0~8|0~9|0~10|0~11|0~12|0~13|0~',
        '1|0~2|0~3|0~4|0~5|0~6|0~7|0~',
        '1|0~2|0~3|0~4|0~5|0~6|0~7|0~',
        '7|3~11|3~'
    ];

    $joints = [
        '1|L~2|L~3|R~4|B~5|B~',
        '1|WNL~2|WNL~3|WNL~4|WNL~5|WNL~',
        '1|B~2|R~3|R~4|R~5|R~'
    ];

    return [
        'formid'                   => $faker->randomDigit,
        'patientid'                => $faker->randomDigit,
        'palpationid'              => $faker->randomElement($palpation),
        'palpationRid'             => $faker->randomElement($palpation),
        'additional_paragraph_pal' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'joint_exam'               => $faker->regexify('~([1-9]~)+'),
        'jointid'                  => $faker->randomElement($joints),
        'i_opening_from'           => $faker->numerify('##'),
        'i_opening_to'             => $faker->numerify('##'),
        'i_opening_equal'          => $faker->numerify('##'),
        'protrusion_from'          => $faker->numerify('-#'),
        'protrusion_to'            => $faker->numerify('##'),
        'protrusion_equal'         => $faker->numerify('##'),
        'l_lateral_from'           => $faker->numerify('##'),
        'l_lateral_to'             => $faker->numerify('##'),
        'l_lateral_equal'          => $faker->numerify('##'),
        'r_lateral_from'           => $faker->numerify('##'),
        'r_lateral_to'             => $faker->numerify('##'),
        'r_lateral_equal'          => $faker->numerify('##'),
        'deviation_from'           => $faker->numerify('#'),
        'deviation_to'             => $faker->numerify('##'),
        'deviation_equal'          => $faker->numerify('##'),
        'deflection_from'          => $faker->numerify('##'),
        'deflection_to'            => $faker->numerify('##'),
        'deflection_equal'         => $faker->numerify('##'),
        'range_normal'             => $faker->numerify('#'),
        'normal'                   => $faker->numerify('#'),
        'other_range_motion'       => $faker->sentence($nbWords = 3),
        'additional_paragraph_rm'  => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'screening_aware'          => $faker->numerify('#'),
        'screening_normal'         => $faker->numerify('#'),
        'userid'                   => $faker->randomDigit,
        'docid'                    => $faker->randomDigit,
        'status'                   => $faker->randomDigit,
        'adddate'                  => $faker->dateTime(),
        'ip_address'               => $faker->ipv4,
        'deviation_r_l'            => $faker->randomElement(['Right', 'Left']),
        'deflection_r_l'           => $faker->randomElement(['Right', 'Left']),
        'dentaldevice'             => $faker->randomDigit,
        'dentaldevice_date'        => $faker->dateTime()
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\FaxInvoice::class, function ($faker) {
    return [
        'invoice_id'  => $faker->randomDigit,
        'description' => $faker->sentence($nbWords = 5),
        'start_date'  => Carbon::now()->addDays(1),
        'end_date'    => Carbon::now()->addDays(10),
        'amount'      => $faker->numerify('5.##'),
        'adddate'     => Carbon::now(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\GagReflex::class, function ($faker) {
    return [
        'gag_reflex'  => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Mandible::class, function ($faker) {
    return [
        'mandible'    => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Medicament::class, function ($faker) {
    return [
        'medications' => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\MedicalHistory::class, function ($faker) {
    return [
        'history'     => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Joint::class, function ($faker) {
    return [
        'joint'       => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 3),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Intolerance::class, function ($faker) {
    return [
        'intolerance' => $faker->sentence($nbWords = 4),
        'description' => $faker->word,
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\ImageType::class, function ($faker) {
    return [
        'imagetype'   => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\JointExam::class, function ($faker) {
    return [
        'joint_exam'  => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Maxilla::class, function ($faker) {
    return [
        'maxilla'     => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Insurance::class, function ($faker) {
    return [
        'formid'                            => $faker->randomDigit,
        'patientid'                         => $faker->randomDigit,
        'pica1'                             => $faker->word,
        'pica2'                             => $faker->word,
        'pica3'                             => $faker->word,
        'insurance_type'                    => $faker->numerify('#'),
        'insured_id_number'                 => $faker->numerify('######'),
        'patient_firstname'                 => $faker->firstNameMale,
        'patient_lastname'                  => $faker->lastName,
        'patient_middle'                    => $faker->regexify('[A-Z]'),
        'patient_dob'                       => Carbon::now()->toDateString(),
        'patient_sex'                       => $faker->randomElement(['F', 'M']),
        'insured_firstname'                 => $faker->firstNameMale,
        'insured_lastname'                  => $faker->lastName,
        'insured_middle'                    => $faker->regexify('[A-Z]'),
        'patient_address'                   => $faker->address,
        'patient_relation_insured'          => $faker->randomElement(['Self', 'Spouse', 'Other']),
        'insured_address'                   => $faker->address,
        'patient_city'                      => $faker->city,
        'patient_state'                     => $faker->stateAbbr,
        'patient_status'                    => $faker->regexify('~[A-Za-z]{7}~'),
        'insured_city'                      => $faker->city,
        'insured_state'                     => $faker->stateAbbr,
        'patient_zip'                       => $faker->numerify('#####'),
        'patient_phone_code'                => $faker->numerify('###'),
        'patient_phone'                     => $faker->numerify('##########'),
        'insured_zip'                       => $faker->numerify('#####'),
        'insured_phone_code'                => $faker->numerify('###'),
        'insured_phone'                     => $faker->numerify('##########'),
        'insured_policy_group_feca'         => $faker->numerify('######'),
        'insured_dob'                       => Carbon::now()->toDateString(),
        'insured_sex'                       => $faker->randomElement(['F', 'M']),
        'insured_employer_school_name'      => $faker->sentence($nbWords = 3),
        'insured_insurance_plan'            => $faker->sentence($nbWords = 3),
        'other_insured_insurance_plan'      => $faker->sentence($nbWords = 3),
        'another_plan'                      => $faker->randomElement(['NO', 'YES']),
        'patient_signature'                 => $faker->word,
        'patient_signed_date'               => Carbon::now()->toDateString(),
        'insured_signature'                 => $faker->word,
        'diagnosis_1'                       => $faker->word,
        'diagnosis_2'                       => $faker->word,
        'diagnosis_3'                       => $faker->word,
        'diagnosis_4'                       => $faker->word,
        'service_date1_from'                => Carbon::now()->toDateString(),
        'service_date1_to'                  => Carbon::now()->toDateString(),
        'place_of_service1'                 => $faker->word,
        'cpt_hcpcs1'                        => $faker->regexify('[A-Z][0-9]{4}'),
        's_charges1_1'                      => $faker->numerify('###.##'),
        's_charges1_2'                      => $faker->numerify('###.##'),
        'federal_tax_id_number'             => $faker->numerify('####'),
        'ein'                               => $faker->numerify('#'),
        'accept_assignment'                 => $faker->randomElement(['Yes', 'No', 'A', 'C']),
        'total_charge'                      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'amount_paid'                       => $faker->regexify('[0-9]+\.[0-9]{2}'),
        'balance_due'                       => $faker->regexify('[0-9]+\.[0-9]{2}'),
        'signature_physician'               => $faker->randomElement(['Signature on File', 'Y']),
        'physician_signed_date'             => Carbon::now()->toDateString(),
        'service_facility_info_name'        => $faker->name,
        'service_facility_info_address'     => $faker->address,
        'service_facility_info_city'        => $faker->city,
        'service_info_a'                    => $faker->sentence($nbWords = 5),
        'billing_provider_phone_code'       => $faker->numerify('###'),
        'billing_provider_phone'            => $faker->numerify('##########'),
        'billing_provider_name'             => $faker->name,
        'billing_provider_address'          => $faker->address,
        'billing_provider_city'             => $faker->city,
        'billing_provider_a'                => $faker->sentence($nbWords = 5),
        'userid'                            => $faker->randomDigit,
        'docid'                             => $faker->randomDigit,
        'status'                            => $faker->randomDigit,
        'card'                              => $faker->randomDigit,
        'ip_address'                        => $faker->ipv4,
        'dispute_reason'                    => $faker->sentence($nbWords = 5),
        'primary_fdf'                       => $faker->regexify('fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf'),
        'secondary_fdf'                     => $faker->regexify('fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf'),
        'producer'                          => $faker->randomDigit,
        'mailed_date'                       => $faker->dateTime(),
        'p_m_eligible_payer_id'             => $faker->numerify('####'),
        'p_m_eligible_payer_name'           => $faker->name,
        'eligible_token'                    => $faker->regexify('[0-9a-zA-Z]{15}'),
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
        'name_referring_provider_qualifier' => $faker->regexify('[A-Z]{2}')
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsuranceFile::class, function ($faker) {
    return [
        'claimid'     => $faker->randomDigit,
        'claimtype'   => $faker->randomElement(['primary', 'secondary']),
        'filename'    => $faker->regexify('DSS_Logo_[0-9]{6}_[0-9]{4}_[0-9]{6}_[0-9]{4}\.(gif|jpg|jpeg|png)'),
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4,
        'description' => $faker->sentence($nbWords = 5),
        'status'      => $faker->randomDigit
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
        'patient_dob'                       => $faker->date(),
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
        'insured_dob'                       => $faker->date(),
        'insured_sex'                       => $faker->randomElement(['M', 'F', 'Male', 'Female']),
        'other_insured_dob'                 => $faker->date(),
        'other_insured_sex'                 => $faker->randomElement(['M', 'F', 'Male', 'Female']),
        'insured_employer_school_name'      => $faker->sentence($nbWords = 4),
        'insured_insurance_plan'            => $faker->sentence($nbWords = 4),
        'other_insured_insurance_plan'      => $faker->sentence($nbWords = 4),
        'another_plan'                      => $faker->randomElement(['NO', 'YES']),
        'patient_signature'                 => $faker->word,
        'patient_signed_date'               => $faker->date(),
        'insured_signature'                 => $faker->word,
        'date_current'                      => $faker->date(),
        'referring_provider'                => $faker->sentence($nbWords = 4),
        'field_17b'                         => $faker->word,
        'hospitalization_date_from'         => $faker->date(),
        'hospitalization_date_to'           => $faker->date(),
        'diagnosis_1'                       => $faker->word,
        'service_date1_from'                => $faker->date(),
        'service_date1_to'                  => $faker->date(),
        'place_of_service1'                 => $faker->word,
        'cpt_hcpcs1'                        => $faker->regexify('[A-Z][0-9]{4}'),
        's_charges1_1'                      => $faker->numerify('##.##'),
        's_charges1_2'                      => $faker->numerify('##.##'),
        'service_date2_from'                => $faker->date(),
        'service_date2_to'                  => $faker->date(),
        'service_date3_from'                => $faker->date(),
        'service_date3_to'                  => $faker->date(),
        'service_date5_from'                => $faker->date(),
        'service_date5_to'                  => $faker->date(),
        'federal_tax_id_number'             => $faker->numerify('##########'),
        'ein'                               => $faker->numerify('#'),
        'accept_assignment'                 => $faker->randomElement(['Yes', 'No', 'A', 'C']),
        'total_charge'                      => $faker->numerify('##.##'),
        'amount_paid'                       => $faker->numerify('###.##'),
        'balance_due'                       => $faker->numerify('####.##'),
        'signature_physician'               => $faker->word,
        'physician_signed_date'             => $faker->date(),
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
        'adddate'                           => $faker->dateTime(),
        'ip_address'                        => $faker->ipv4,
        'dispute_reason'                    => $faker->sentence($nbWords = 6),
        'primary_fdf'                       => $faker->regexify('fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf'),
        'secondary_fdf'                     => $faker->regexify('fdf_[0-9]_[0-9]{2}_[0-9]{14}\.fdf'),
        'producer'                          => $faker->randomDigit,
        'mailed_date'                       => $faker->date(),
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
        'percase_date'                      => $faker->date(),
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

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory::class, function ($faker) {
    return [
        'insuranceid' => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'userid'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime(),
        'ip_address'  => $faker->ipv4,
        'adminid'     => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\InsurancePreauth::class, function ($faker) {
    return [
        'doc_id'                            => $faker->randomDigit,
        'patient_id'                        => $faker->randomDigit,
        'ins_co'                            => $faker->sentence($nbWords = 5),
        'ins_rank'                          => $faker->word,
        'ins_phone'                         => $faker->numerify('##########'),
        'patient_ins_group_id'              => $faker->numerify('####'),
        'patient_ins_id'                    => $faker->numerify('#####'),
        'patient_firstname'                 => $faker->firstNameMale,
        'patient_lastname'                  => $faker->lastname,
        'patient_add1'                      => $faker->address,
        'patient_add2'                      => $faker->address,
        'patient_city'                      => $faker->city,
        'patient_state'                     => $faker->stateAbbr,
        'patient_zip'                       => $faker->numerify('#####'),
        'patient_dob'                       => $faker->date(),
        'insured_first_name'                => $faker->firstNameMale,
        'insured_last_name'                 => $faker->lastname,
        'insured_dob'                       => $faker->date(),
        'doc_npi'                           => $faker->numerify('#########'),
        'referring_doc_npi'                 => $faker->numerify('#########'),
        'trxn_code_amount'                  => $faker->numerify('##.##'),
        'diagnosis_code'                    => $faker->numerify('##.##'),
        'date_of_call'                      => $faker->date(),
        'insurance_rep'                     => $faker->word,
        'call_reference_num'                => $faker->numerify('#####'),
        'doc_medicare_npi'                  => $faker->numerify('#########'),
        'doc_tax_id_or_ssn'                 => $faker->numerify('#####'),
        'ins_effective_date'                => $faker->date(),
        'ins_cal_year_start'                => $faker->date(),
        'ins_cal_year_end'                  => $faker->date(),
        'trxn_code_covered'                 => $faker->randomDigit,
        'code_covered_notes'                => $faker->sentence($nbWords = 5),
        'has_out_of_network_benefits'       => $faker->randomDigit,
        'out_of_network_percentage'         => $faker->randomDigit,
        'is_hmo'                            => $faker->randomDigit,
        'hmo_date_called'                   => $faker->date(),
        'hmo_date_received'                 => $faker->date(),
        'hmo_needs_auth'                    => $faker->randomDigit,
        'hmo_auth_date_requested'           => $faker->date(),
        'hmo_auth_date_received'            => $faker->date(),
        'hmo_auth_notes'                    => $faker->sentence($nbWords = 5),
        'in_network_percentage'             => $faker->randomDigit,
        'in_network_appeal_date_sent'       => $faker->date(),
        'in_network_appeal_date_received'   => $faker->date(),
        'is_pre_auth_required'              => $faker->randomDigit,
        'verbal_pre_auth_name'              => $faker->firstNameMale,
        'verbal_pre_auth_ref_num'           => $faker->numerify('#####'),
        'verbal_pre_auth_notes'             => $faker->sentence($nbWords = 5),
        'written_pre_auth_notes'            => $faker->sentence($nbWords = 5),
        'written_pre_auth_date_received'    => $faker->date(),
        'front_office_request_date'         => $faker->date(),
        'status'                            => $faker->randomDigit,
        'patient_deductible'                => $faker->numerify('##.##'),
        'patient_amount_met'                => $faker->numerify('##.##'),
        'family_deductible'                 => $faker->numerify('##.##'),
        'family_amount_met'                 => $faker->numerify('##.##'),
        'deductible_reset_date'             => $faker->date(),
        'out_of_pocket_met'                 => $faker->randomDigit,
        'patient_amount_left_to_meet'       => $faker->numerify('##.##'),
        'expected_insurance_payment'        => $faker->numerify('##.##'),
        'expected_patient_payment'          => $faker->numerify('##.##'),
        'network_benefits'                  => $faker->randomDigit,
        'viewed'                            => $faker->randomDigit,
        'date_completed'                    => $faker->date(),
        'userid'                            => $faker->randomDigit,
        'how_often'                         => $faker->numerify('#'),
        'patient_phone'                     => $faker->numerify('##########'),
        'pre_auth_num'                      => $faker->numerify('#########'),
        'family_amount_left_to_meet'        => $faker->numerify('##.##'),
        'deductible_from'                   => $faker->randomDigit,
        'reject_reason'                     => $faker->sentence($nbWords = 6),
        'invoice_date'                      => $faker->date(),
        'invoice_amount'                    => $faker->numerify('##.##'),
        'invoice_status'                    => $faker->randomDigit,
        'invoice_id'                        => $faker->randomDigit,
        'updated_by'                        => $faker->randomDigit,
        'doc_name'                          => $faker->name,
        'doc_practice'                      => $faker->word,
        'doc_address'                       => $faker->address,
        'doc_phone'                         => $faker->numerify('##########'),
        'in_deductible_from'                => $faker->randomDigit,
        'in_patient_deductible'             => $faker->numerify('##.##'),
        'in_patient_amount_met'             => $faker->numerify('##.##'),
        'in_patient_amount_left_to_meet'    => $faker->numerify('##.##'),
        'in_family_deductible'              => $faker->numerify('##.##'),
        'in_family_amount_met'              => $faker->numerify('##.##'),
        'in_family_amount_left_to_meet'     => $faker->numerify('##.##'),
        'in_deductible_reset_date'          => $faker->date(),
        'in_out_of_pocket_met'              => $faker->randomDigit,
        'in_expected_insurance_payment'     => $faker->numerify('##.##'),
        'in_expected_patient_payment'       => $faker->numerify('##.##'),
        'in_call_reference_num'             => $faker->numerify('###'),
        'has_in_network_benefits'           => $faker->randomDigit,
        'in_is_pre_auth_required'           => $faker->randomDigit,
        'in_verbal_pre_auth_name'           => $faker->name,
        'in_verbal_pre_auth_ref_num'        => $faker->name,
        'in_verbal_pre_auth_notes'          => $faker->sentence($nbWords = 5),
        'in_written_pre_auth_date_received' => $faker->date(),
        'in_pre_auth_num'                   => $faker->numerify('###'),
        'in_written_pre_auth_notes'         => $faker->sentence($nbWords = 5)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LedgerNote::class, function ($faker) {
    return [
        'producerid'       => $faker->randomDigit,
        'note'             => $faker->sentence($nbWords = 4),
        'private'          => $faker->randomDigit,
        'service_date'     => $faker->dateTime(),
        'entry_date'       => $faker->dateTime(),
        'patientid'        => $faker->randomDigit,
        'adddate'          => $faker->dateTime(),
        'ip_address'       => $faker->ipv4,
        'docid'            => $faker->randomDigit,
        'admin_producerid' => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Ledger::class, function ($faker) {
    return [
        'formid'                 => $faker->randomDigit,
        'patientid'              => $faker->randomDigit,
        'service_date'           => $faker->dateTime(),
        'entry_date'             => $faker->dateTime(),
        'description'            => $faker->sentence($nbWords = 5),
        'producer'               => $faker->word,
        'amount'                 => $faker->numerify('###.##'),
        'transaction_type'       => $faker->randomElement(['Charge', 'Credit', 'None']),
        'paid_amount'            => $faker->numerify('###.##'),
        'userid'                 => $faker->randomDigit,
        'docid'                  => $faker->randomDigit,
        'status'                 => $faker->randomDigit,
        'adddate'                => Carbon::now()->format('m/d/Y'),
        'ip_address'             => $faker->ipv4,
        'transaction_code'       => $faker->regexify('[A-Z][0-9]{4}'),
        'placeofservice'         => $faker->word,
        'emg'                    => $faker->numerify('#'),
        'diagnosispointer'       => $faker->numerify('#'),
        'daysorunits'            => $faker->numerify('#'),
        'epsdt'                  => $faker->numerify('#'),
        'idqual'                 => $faker->numerify('###'),
        'modcode'                => $faker->sentence($nbWords = 5),
        'producerid'             => $faker->randomDigit,
        'primary_claim_id'       => $faker->randomDigit,
        'primary_paper_claim_id' => $faker->numerify('#####'),
        'modcode2'               => $faker->word,
        'modcode3'               => $faker->word,
        'modcode4'               => $faker->word,
        'percase_date'           => $faker->dateTime(),
        'percase_name'           => $faker->name,
        'percase_amount'         => $faker->numerify('###.##'),
        'percase_status'         => $faker->randomDigit,
        'percase_invoice'        => $faker->randomDigit,
        'percase_free'           => $faker->randomDigit,
        'secondary_claim_id'     => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LedgerHistory::class, function ($faker) {
    return [
            'ledgerid'                 => $faker->randomDigit,
            'formid'                   => $faker->randomDigit,
            'patientid'                => $faker->randomDigit,
            'service_date'             => $faker->dateTime(),
            'entry_date'               => $faker->dateTime(),
            'description'              => $faker->sentence($nbWords = 6),
            'producer'                 => $faker->name,
            'amount'                   => $faker->regexify('[0-9]+\.[0-9]{2}'),
            'transaction_type'         => $faker->randomElement(['Charge', 'Credit', 'None']),
            'paid_amount'              => $faker->regexify('[0-9]+\.[0-9]{2}'),
            'userid'                   => $faker->randomDigit,
            'docid'                    => $faker->randomDigit,
            'status'                   => $faker->randomDigit,
            'adddate'                  => Carbon::now()->format('m/d/Y'),
            'ip_address'               => $faker->ipv4,
            'transaction_code'         => $faker->regexify('[A-Z][0-9]{4}'),
            'placeofservice'           => $faker->numerify('##'),
            'emg'                      => $faker->numerify('##'),
            'diagnosispointer'         => $faker->numerify('##'),
            'daysorunits'              => $faker->numerify('##'),
            'epsdt'                    => $faker->numerify('##'),
            'idqual'                   => $faker->numerify('##'),
            'modcode'                  => $faker->numerify('##'),
            'producerid'               => $faker->randomDigit,
            'primary_claim_id'         => $faker->randomDigit,
            'primary_paper_claim_id'   => $faker->numerify('##'),
            'modcode2'                 => $faker->word,
            'modcode3'                 => $faker->word,
            'modcode4'                 => $faker->word,
            'percase_date'             => $faker->dateTime(),
            'percase_name'             => $faker->name,
            'percase_amount'           => $faker->regexify('[0-9]+\.[0-9]{2}'),
            'percase_status'           => $faker->randomDigit,
            'percase_invoice'          => $faker->randomDigit,
            'percase_free'             => $faker->randomDigit,
            'updated_by_user'          => $faker->randomDigit,
            'updated_by_admin'         => $faker->randomDigit,
            'primary_claim_history_id' => $faker->randomDigit,
            'secondary_claim_id'       => $faker->randomDigit
        ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LedgerPayment::class, function ($faker) {
    return [
        'payer'          => $faker->randomDigit,
        'amount'         => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 3000),
        'payment_type'   => $faker->randomDigit,
        'payment_date'   => $faker->dateTime(),
        'entry_date'     => $faker->dateTime(),
        'ledgerid'       => $faker->randomDigit,
        'allowed'        => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'ins_paid'       => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 800),
        'deductible'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'copay'          => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 800),
        'coins'          => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'overpaid'       => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 800),
        'followup'       => $faker->dateTime(),
        'note'           => $faker->sentence($nbWords = 5),
        'amount_allowed' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory::class, function ($faker) {
    return [
        'paymentid'         => $faker->randomDigit,
        'payer'             => $faker->randomDigit,
        'amount'            => $faker->numerify('###.##'),
        'payment_type'      => $faker->randomDigit,
        'payment_date'      => $faker->dateTime(),
        'entry_date'        => $faker->dateTime(),
        'ledgerid'          => $faker->randomDigit,
        'allowed'           => $faker->numerify('###.##'),
        'ins_paid'          => $faker->numerify('###.##'),
        'deductible'        => $faker->numerify('###.##'),
        'copay'             => $faker->numerify('###.##'),
        'coins'             => $faker->numerify('###.##'),
        'overpaid'          => $faker->numerify('###.##'),
        'followup'          => $faker->dateTime(),
        'note'              => $faker->sentence($nbWords = 5),
        'amount_allowed'    => $faker->numerify('###.##'),
        'updated_by_user'   => $faker->boolean($chanceOfGettingTrue = 50),
        'updated_by_admin'  => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LedgerRecord::class, function ($faker) {
    return [
        'formid'           => $faker->randomDigit,
        'patientid'        => $faker->randomDigit,
        'service_date'     => Carbon::now()->format('m/d/Y'),
        'entry_date'       => Carbon::now()->addDays(2)->format('m/d/Y'),
        'description'      => $faker->sentence($nbWords = 5),
        'producer'         => $faker->word,
        'amount'           => $faker->numerify('###.##'),
        'transaction_type' => $faker->randomElement(['Charge', 'None', 'Credit']),
        'paid_amount'      => $faker->numerify('###.##'),
        'userid'           => $faker->randomDigit,
        'docid'            => $faker->randomDigit,
        'status'           => $faker->randomDigit,
        'adddate'          => Carbon::now()->format('m/d/Y'),
        'ip_address'       => $faker->ipv4,
        'transaction_code' => $faker->regexify('[A-Z][0-9]{4}')
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LedgerStatement::class, function ($faker) {
    return [
        'producerid'   => $faker->randomDigit,
        'filename'     => $faker->regexify('\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf'),
        'service_date' => $faker->dateTime(),
        'entry_date'   => $faker->dateTime(),
        'patientid'    => $faker->randomDigit,
        'adddate'      => $faker->dateTime(),
        'ip_address'   => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\LetterTemplate::class, function ($faker) {
    return [
        'name'           => $faker->sentence($nbWords = 4),
        'template'       => $faker->regexify('\/manage\/([a-z]+_)+[a-z]+\.php'),
        'body'           => $faker->sentence($nbWords = 6),
        'default_letter' => $faker->randomDigit,
        'companyid'      => $faker->randomDigit,
        'triggerid'      => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate::class, function ($faker) {
    return [
        'name'       => $faker->sentence($nbWords = 3),
        'body'       => $faker->sentence($nbWords = 6),
        'docid'      => $faker->randomDigit,
        'adddate'    => $faker->dateTime(),
        'ip_address' => $faker->ipv4,
        'status'     => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Letter::class, function ($faker) {
    return [
        'patientid'            => $faker->randomDigit,
        'stepid'               => $faker->randomDigit,
        'delivery_date'        => $faker->dateTime(),
        'send_method'          => $faker->word,
        'template'             => $faker->sentence($nbWords = 6),
        'pdf_path'             => $faker->word,
        'status'               => $faker->randomDigit,
        'delivered'            => $faker->randomDigit,
        'deleted'              => $faker->boolean($chanceOfGettingTrue = 50),
        'templateid'           => $faker->randomDigit,
        'parentid'             => $faker->randomDigit,
        'topatient'            => $faker->boolean($chanceOfGettingTrue = 50),
        'md_list'              => $faker->word,
        'md_referral_list'     => $faker->word,
        'docid'                => $faker->randomDigit,
        'userid'               => $faker->randomDigit,
        'date_sent'            => $faker->dateTime(),
        'info_id'              => $faker->randomDigit,
        'edit_userid'          => $faker->randomDigit,
        'mailed_date'          => $faker->dateTime(),
        'mailed_once'          => $faker->randomDigit,
        'template_type'        => $faker->randomDigit,
        'cc_topatient'         => $faker->randomDigit,
        'cc_md_list'           => $faker->word,
        'cc_md_referral_list'  => $faker->word,
        'font_family'          => $faker->word,
        'font_size'            => $faker->randomDigit,
        'pat_referral_list'    => $faker->word,
        'cc_pat_referral_list' => $faker->word,
        'deleted_by'           => $faker->randomDigit,
        'deleted_on'           => $faker->dateTime()
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Location::class, function ($faker) {
    return [
        'location'         => $faker->word,
        'docid'            => $faker->randomDigit,
        'ip_address'       => $faker->ipv4,
        'name'             => $faker->name,
        'address'          => $faker->address,
        'city'             => $faker->city,
        'state'            => $faker->stateAbbr,
        'zip'              => $faker->numerify('#####'),
        'phone'            => $faker->numerify('##########'),
        'fax'              => $faker->numerify('##########'),
        'default_location' => $faker->boolean($chanceOfGettingTrue = 50),
        'email'            => $faker->email
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Dental\Login::class, function ($faker) {
    return [
        'docid'       => $faker->randomDigit,
        'userid'      => $faker->randomDigit,
        'login_date'  => $faker->dateTime(),
        'logout_date' => $faker->dateTime(),
        'ip_address'  => $faker->ipv4
    ];
});