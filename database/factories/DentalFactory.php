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

$factory->define(DentalSleepSolutions\Eloquent\Dental\DocumentCategory::class, function ($faker) {
    return [
        'name'       => $faker->name,
        'status'     => $faker->randomDigit,
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
