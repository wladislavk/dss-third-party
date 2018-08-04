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

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\AdvancedPainTmdExam::class, function ($faker) {
    $cervical = [
        'extension' => [
            'rom' => $faker->word,
            'pain' => $faker->randomDigit,
        ],
        'flexion' => [
            'rom' => $faker->word,
            'pain' => $faker->randomDigit,
        ],
        'rotation' => [
            'right' => [
                'rom' => $faker->word,
                'pain' => $faker->randomDigit,
            ],
            'left' => [
                'rom' => $faker->word,
                'pain' => $faker->randomDigit,
            ],
            'symmetry' => $faker->sentence(),
        ],
        'side_bend' => [
            'right' => [
                'rom' => $faker->word,
                'pain' => $faker->randomDigit,
            ],
            'left' => [
                'rom' => $faker->word,
                'pain' => $faker->randomDigit,
            ],
            'symmetry' => $faker->word,
        ]
    ];
    $morphology = [
        'midline' => [
            'general' => [
                'position' => $faker->word,
            ],
            'facial' => [
                'position' => $faker->word,
            ],
            'teeth' => [
                'maxilla' => [
                    'position' => $faker->word,
                ],
                'mandible' => [
                    'position' => $faker->word,
                ]
            ],
            'eyes' => [
                'right' => [
                    'position' => $faker->word,
                ],
                'left' => [
                    'position' => $faker->word,
                ]
            ]
        ],
        'posture' => [
            'head' => [
                'position' => $faker->word,
            ],
            'standing' => [
                'position' => $faker->word,
            ],
            'sitting' => [
                'position' => $faker->word,
            ]
        ],
        'shoulders' => [
            'position' => $faker->word,
        ],
        'hips' => [
            'position' => $faker->word,
        ],
        'spine' => [
            'position' => $faker->word,
        ],
        'pupillary_plane' => [
            'position' => $faker->word,
        ]
    ];
    $cranialNerve = [
        'olfactory' => $faker->boolean,
        'optic' => $faker->boolean,
        'occulomotor' => $faker->boolean,
        'trochlear' => $faker->boolean,
        'trigeminal' => $faker->boolean,
        'abducens' => $faker->boolean,
        'facial' => $faker->boolean,
        'acoustic' => $faker->boolean,
        'glossopharyngeal' => $faker->boolean,
        'vagus' => $faker->boolean,
        'accessory' => $faker->boolean,
        'hypoglossal' => $faker->boolean,
    ];
    $occlusal = [
        'contacts' => [
            'working' => [
                'right' => [],
                'left' => [],
            ],
            'non_working' => [
                'right' => [],
                'left' => [],
            ]
        ],
        'crossover_interferences' => []
    ];
    $other = [
        'guidance' => $faker->sentence(),
        'notes' => $faker->sentence(),
    ];

    return [
        'created_by_user' => $faker->randomDigit,
        'created_by_admin' => $faker->randomDigit,
        'updated_by_user' => $faker->randomDigit,
        'updated_by_admin' => $faker->randomDigit,
        'ip_address' => $faker->ipv4,
        'cervical' => $cervical,
        'morphology' => $morphology,
        'cranial_nerve' => $cranialNerve,
        'occlusal' => $occlusal,
        'other' => $other,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ApiLog::class, function ($faker) {
    return [
        'method' => $faker->randomElement(['GET', 'PUT', 'POST', 'DELETE']),
        'route' => $faker->slug,
        'payload' => json_encode([
            'test' => $faker->uuid,
            'sha256' => $faker->sha256,
        ]),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ApiPermission::class, function ($faker) {
    $resourceGroup = factory(DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup::class)->create();
    return [
        'group_id' => $resourceGroup->id,
        'doc_id' => null,
        'patient_id' => null,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResource::class, function ($faker) {
    $resourceGroup = factory(DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup::class)->create();
    return [
        'group_id' => $resourceGroup->id,
        'slug' => $faker->slug,
        'route' => $faker->slug,
        'created_by' => null,
        'updated_by' => null,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ApiPermissionResourceGroup::class, function ($faker) {
    return [
        'slug' => $faker->slug,
        'name' => $faker->company,
        'authorize_per_user' => $faker->randomElement([0, 1]),
        'authorize_per_patient' => $faker->randomElement([0, 1]),
        'created_by' => $faker->randomDigit,
        'updated_by' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\AssessmentPlanExam::class, function ($faker) {
    $assessmentCodes = [];
    $treatmentCodes = [];

    return [
        'created_by_user' => $faker->randomDigit,
        'created_by_admin' => $faker->randomDigit,
        'updated_by_user' => $faker->randomDigit,
        'updated_by_admin' => $faker->randomDigit,
        'ip_address' => $faker->ipv4,
        'assessment_codes' => $assessmentCodes,
        'assessment_description' => $faker->sentence(),
        'treatment_codes' => $treatmentCodes,
        'treatment_description' => $faker->sentence(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\DoctorPalpation::class, function ($faker) {
    return [
        'updated_by_user' => $faker->randomDigit,
        'updated_by_admin' => $faker->randomDigit,
        'ip_address' => $faker->ipv4,
        'palpationid' => $faker->randomDigit,
        'sortby' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\EvaluationManagementExam::class, function ($faker) {
    $history = [
        'chief_complaint' => [
            'value' => $faker->sentence(),
            'default' => $faker->sentence(),
        ],
        'present' => [
            'location' => $faker->sentence(),
            'quality' => $faker->sentence(),
            'severity' => $faker->sentence(),
            'duration' => $faker->sentence(),
            'timing' => $faker->sentence(),
            'context' => $faker->sentence(),
            'modifying_factor' => $faker->sentence(),
            'symptoms' => $faker->sentence(),
        ],
        'past' => [
            'family' => [
                'value' => $faker->sentence(),
                'default' => $faker->sentence(),
            ],
            'medical' => [
                'allergens' => [
                    'value' => $faker->sentence(),
                    'default' => $faker->sentence(),
                ],
                'medication' => [
                    'value' => $faker->sentence(),
                    'default' => $faker->sentence(),
                ],
                'general' => [
                    'value' => $faker->sentence(),
                    'default' => $faker->sentence(),
                ],
                'dental' => [
                    'value' => $faker->sentence(),
                    'default' => $faker->sentence(),
                ],
            ],
            'social' => [
                'value' => $faker->sentence(),
                'default' => $faker->sentence(),
            ],
        ],
    ];
    $systems = [
        'constitutional' => $faker->sentence(),
        'eyes' => $faker->sentence(),
        'ears_nose_mouth_throat' => $faker->sentence(),
        'cardiovascular' => $faker->sentence(),
        'respiratory' => $faker->sentence(),
        'gastrointestinal' => $faker->sentence(),
        'genitourinary' => $faker->sentence(),
        'musculoskeletal' => $faker->sentence(),
        'integumentary' => $faker->sentence(),
        'neurologic' => $faker->sentence(),
        'psychiatric' => $faker->sentence(),
        'endocrine' => $faker->sentence(),
        'hematologic_lymphatic' => $faker->sentence(),
        'allergic_immunologic' => $faker->sentence(),
    ];
    $vitalSigns = [
        'height' => [
            'feet' => $faker->randomNumber,
            'inches' => $faker->numberBetween(0, 11),
        ],
        'weight' => $faker->randomFloat,
        'bmi' => $faker->randomFloat,
        'blood_pressure' => $faker->randomNumber,
        'pulse' => $faker->randomNumber,
        'neck_measurement' => $faker->randomNumber,
        'respirations' => $faker->randomNumber,
        'appearance' => $faker->word,
        'orientation' => $faker->word,
        'mood_affect' => $faker->word,
        'gait_station' => $faker->word,
        'coordination_balance' => $faker->word,
        'sensation' => $faker->word,
    ];
    $bodyArea = [
        'first_description' => $faker->sentence(),
        'palpation' => $faker->sentence(),
        'rom' => $faker->word,
        'stability' => $faker->sentence(),
        'strength' => $faker->sentence(),
        'skin' => $faker->sentence(),
        'second_description' => $faker->sentence(),
        'lips_teeth_gums' => $faker->sentence(),
        'oropharynx' => $faker->sentence(),
        'nasal_septum_turbinates' => $faker->sentence(),
    ];

    return [
        'created_by_user' => $faker->randomDigit,
        'created_by_admin' => $faker->randomDigit,
        'updated_by_user' => $faker->randomDigit,
        'updated_by_admin' => $faker->randomDigit,
        'ip_address' => $faker->ipv4,
        'history' => $history,
        'systems' => $systems,
        'vital_signs' => $vitalSigns,
        'body_area' => $bodyArea,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SummarySleeplab::class, function ($faker) {
    return [
        'date'             => $faker->dateTime->format('m/d/Y'),
        'sleeptesttype'    => $faker->word,
        'place'            => $faker->word,
        'apnea'            => $faker->word,
        'hypopnea'         => $faker->word,
        'ahi'              => $faker->word,
        'ahisupine'        => $faker->word,
        'rdi'              => $faker->word,
        'rdisupine'        => $faker->word,
        'o2nadir'          => $faker->word,
        't9002'            => $faker->word,
        'sleepefficiency'  => $faker->word,
        'cpaplevel'        => $faker->word,
        'dentaldevice'     => $faker->numerify('#'),
        'devicesetting'    => $faker->word,
        'diagnosis'        => $faker->word,
        'notes'            => $faker->word,
        'patiendid'        => $faker->numerify('##'),
        'filename'         => $faker->regexify('[a-z0-9_]+\.(jpg|gif|png|bmp)'),
        'testnumber'       => $faker->numerify('#########'),
        'needed'           => $faker->randomElement(['No', 'Yes']),
        'scheddate'        => $faker->dateTime->format('m/d/Y'),
        'completed'        => $faker->randomElement(['No', 'Yes']),
        'interpolation'    => $faker->randomElement(['No', 'Yes']),
        'copyreqdate'      => $faker->dateTime->format('m/d/Y'),
        'sleeplab'         => $faker->numerify('##'),
        'diagnosising_doc' => $faker->sentence($nbWords = 3),
        'diagnosising_npi' => $faker->numerify('##########'),
        'image_id'         => $faker->numerify('##'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Qualifier::class, function (\Faker\Generator $faker) {
    return [
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PlaceService::class, function (\Faker\Generator $faker) {
    return [
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ClaimElectronic::class, function () {
    return [];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Insurance::class, function (\Faker\Generator $faker) {
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

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth::class, function (\Faker\Generator $faker) {
    return [
        'doc_id' => $faker->randomDigit,
        'patient_id' => $faker->randomDigit,
        'ins_rank' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceStatusHistory::class, function () {
    return [];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceDiagnosis::class, function (\Faker\Generator $faker) {
    $insuranceDiagnoses = [
        '039.3 ACTINOMYCOTIC INFECTION CERVICOFACIAL (3)',
        '053.12 POSTHERPETIC TRIGEMINAL NEURALGIA (5)',
        '053.13 POSTHERPETIC POLYNEUROPATHY (6)',
    ];
    return [
        'ins_diagnosis' => $faker->randomElement($insuranceDiagnoses),
        'description'   => $faker->sentence($nbWords = 6),
        'sortby'        => $faker->randomDigit,
        'status'        => $faker->randomDigit,
        'adddate'       => $faker->dateTime,
        'ip_address'    => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Ledger::class, function (\Faker\Generator $faker) {
    return [
        'placeofservice' => $faker->randomDigit,
        'emg' => $faker->word,
        'diagnosispointer' => $faker->word,
        'daysorunits' => $faker->word,
        'epsdt' => $faker->word,
        'idqual' => $faker->word,
        'modcode' => $faker->word,
        'amount' => 1,
        'modcode2' => 22,
        'modcode3' => 24,
        'modcode4' => 25,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Patient::class, function (\Faker\Generator $faker) {
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

        'gender' => 'Male',
        'lastname' => $faker->lastName,
        'firstname' => $faker->firstName,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PainTmdExam::class, function ($faker) {
    $description = [
        'chief_complaint' => $faker->sentence(),
        'extra_info' => $faker->sentence(),
        'pain' => [
            'ease' => $faker->sentence(),
            'worse' => $faker->sentence(),
        ],
        'treatment_goals' => $faker->sentence(),
    ];
    $pain = [
        'back' => [
            'general' => [
                'level' => $faker->randomDigit,
            ],
            'upper' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'middle' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'lower' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
        'jaw' => [
            'general' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'joint' => [
                'general' => [
                    'level' => $faker->randomDigit,
                ],
                'opening' => [
                    'position' => $faker->word,
                    'level' => $faker->randomDigit,
                ],
                'chewing' => [
                    'position' => $faker->word,
                    'level' => $faker->randomDigit,
                ],
                'at_rest' => [
                    'position' => $faker->word,
                    'level' => $faker->randomDigit,
                ],
            ],
        ],
        'eyes' => [
            'behind' => [
                'checked' => $faker->boolean,
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'watery' => [
                'checked' => $faker->boolean,
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'visual_disturbance' => [
                'checked' => $faker->boolean,
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
        'ears' => [
            'general' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'behind' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'front' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
            'ringing' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
        'throat' => [
            'general' => [
                'level' => $faker->randomDigit,
            ],
            'swallowing' => [
                'level' => $faker->randomDigit,
            ],
        ],
        'face' => [
            'general' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
        'neck' => [
            'general' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
        'shoulder' => [
            'general' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
        'teeth' => [
            'general' => [
                'position' => $faker->word,
                'level' => $faker->randomDigit,
            ],
        ],
    ];
    $symptomReview = [
        'onset_of_event' => $faker->sentence(),
        'provocation' => $faker->sentence(),
        'quality_of_pain' => $faker->sentence(),
        'region_and_radiation' => $faker->sentence(),
        'severity' => $faker->sentence(),
        'time' => $faker->sentence(),
    ];
    $symptoms = [
        'jaw' => [
            'locks' => [
                'open' => $faker->boolean,
                'closed' => $faker->boolean,
            ],
            'opening' => [
                'clicks_pops' => $faker->boolean,
                'position' => $faker->word,
            ],
            'closing' => [
                'clicks_pops' => $faker->boolean,
                'position' => $faker->word,
            ],
        ],
        'clenching' => [
            'daytime' => $faker->boolean,
            'nighttime' => $faker->boolean,
        ],
        'mouth' => [
            'limited_opening' => $faker->boolean,
        ],
        'grinding' => [
            'daytime' => $faker->boolean,
            'nighttime' => $faker->boolean,
        ],
        'muscle_twitching' => $faker->boolean,
        'numbness' => [
            'lip' => $faker->boolean,
            'jawbone' => $faker->boolean,
        ],
        'other' => [
            'dry_mouth' => $faker->boolean,
            'cheek_biting' => $faker->boolean,
            'burning_tongue' => $faker->boolean,
            'dizziness' => $faker->boolean,
            'buzzing' => $faker->boolean,
            'swallowing' => $faker->boolean,
            'neck_stiffness' => $faker->boolean,
            'vision_changes' => $faker->boolean,
            'sciatica' => $faker->boolean,
            'ear_infections' => $faker->boolean,
            'foreign_feeling' => $faker->boolean,
            'shoulder_stiffness' => $faker->boolean,
            'blurred_vision' => $faker->sentence(),
            'fingers_tingling' => $faker->boolean,
            'ear_congestion' => $faker->boolean,
            'neck_swelling' => $faker->boolean,
            'scoliosis' => $faker->boolean,
            'visual_disturbances' => $faker->boolean,
            'finger_hand_numbness' => $faker->boolean,
            'hearing_loss' => $faker->boolean,
            'gland_swelling' => $faker->boolean,
            'chronic_sinusitis' => $faker->boolean,
            'thyroid_swelling' => $faker->boolean,
            'difficult_breathing' => $faker->boolean,
            'description' => $faker->sentence(),
        ],
    ];
    $headaches = [
        'checked' => $faker->boolean,
        'front' => [
            'frequency' => $faker->word,
            'duration' => $faker->word,
            'level' => $faker->randomDigit,
        ],
        'top' => [
            'frequency' => $faker->word,
            'duration' => $faker->word,
            'level' => $faker->randomDigit,
        ],
        'back' => [
            'frequency' => $faker->word,
            'duration' => $faker->word,
            'level' => $faker->randomDigit,
        ],
        'temple' => [
            'frequency' => $faker->word,
            'duration' => $faker->word,
            'level' => $faker->randomDigit,
        ],
        'eyes' => [
            'frequency' => $faker->word,
            'duration' => $faker->word,
            'level' => $faker->randomDigit,
        ],
        'symptoms' => [
            'dizziness' => $faker->boolean,
            'noise_sensitivity' => $faker->boolean,
            'throbbling' => $faker->boolean,
            'double_vision' => $faker->boolean,
            'light_sensitivity' => $faker->boolean,
            'vomiting' => $faker->boolean,
            'fatigue' => $faker->boolean,
            'nausea' => $faker->boolean,
            'eye_nose_running' => $faker->boolean,
            'sinus_congestion' => $faker->boolean,
            'burning' => $faker->boolean,
            'other' => [
                'checked' => $faker->boolean,
                'details' => $faker->sentence(),
            ],
            'dull_aching' => $faker->boolean,
        ],
        'migraines' => [
            'checked' => $faker->boolean,
            'specialist' => $faker->name,
            'occurrence' => $faker->word,
        ],
    ];

    return [
        'ip_address' => $faker->ipv4,
        'description' => $description,
        'pain' => $pain,
        'symptom_review' => $symptomReview,
        'symptoms' => $symptoms,
        'headaches' => $headaches,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TransactionCode::class, function ($faker) {
    return [
        'type' => $faker->word,
        'ip_address' => $faker->ipv4,
        'transaction_code' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Admin::class, function (\Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'password' => $faker->regexify('[a-z0-9]{65}'),
        'status' => $faker->randomDigit,
        'ip_address' => $faker->ipv4,
        'salt' => $faker->regexify('[a-z0-9]{12}'),
        'recover_time' => $faker->dateTime,
        'admin_access' => $faker->randomDigit,
        'last_accessed_date' => $faker->dateTime,
        'claim_margin_top' => $faker->randomDigit,
        'claim_margin_left' => $faker->randomDigit,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\User::class, function (\Faker\Generator $faker) {
    return [
        'user_access'             => $faker->randomDigit,
        'docid'                   => $faker->randomDigit,
        'username'                => $faker->userName,
        'npi'                     => $faker->numerify('##########'),
        'password'                => $faker->regexify('[a-z0-9]{65}'),
        'name'                    => $faker->name,
        'email'                   => $faker->email,
        'address'                 => $faker->address,
        'city'                    => $faker->city,
        'state'                   => $faker->stateAbbr,
        'zip'                     => $faker->numerify('#####'),
        'phone'                   => $faker->numerify('##########'),
        'status'                  => $faker->randomDigit,
        'adddate'                 => $faker->dateTime,
        'ip_address'              => $faker->ipv4,
        'medicare_npi'            => $faker->numerify('##########'),
        'tax_id_or_ssn'           => $faker->word,
        'producer'                => $faker->randomDigit,
        'practice'                => $faker->sentence($nbWords = 4),
        'email_header'            => $faker->regexify('dss_email_header_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)'),
        'email_footer'            => $faker->regexify('dss_email_footer_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)'),
        'fax_header'              => $faker->regexify('dss_print_header_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)'),
        'fax_footer'              => $faker->regexify('dss_print_footer_[0-9]{6}_[0-9]{4}\.(gif|png|bmp|jpg|jpeg)'),
        'salt'                    => $faker->regexify('[a-z0-9]{12}'),
        'recover_hash'            => $faker->regexify('[a-z0-9]{65}'),
        'recover_time'            => $faker->dateTime,
        'ssn'                     => $faker->boolean,
        'ein'                     => $faker->boolean,
        'use_patient_portal'      => $faker->boolean,
        'mailing_practice'        => $faker->word,
        'mailing_name'            => $faker->name,
        'mailing_address'         => $faker->address,
        'mailing_city'            => $faker->city,
        'mailing_state'           => $faker->stateAbbr,
        'mailing_zip'             => $faker->numerify('#####'),
        'mailing_phone'           => $faker->numerify('##########'),
        'last_accessed_date'      => $faker->dateTime,
        'use_digital_fax'         => $faker->boolean,
        'fax'                     => $faker->numerify('##########'),
        'use_letters'             => $faker->boolean,
        'sign_notes'              => $faker->randomDigit,
        'use_eligible_api'        => $faker->boolean,
        'access_code'             => $faker->regexify('[A-Z][0-9]{4}'),
        'text_date'               => $faker->dateTime,
        'text_num'                => $faker->randomDigit,
        'access_code_date'        => $faker->dateTime,
        'registration_email_date' => $faker->dateTime,
        'producer_files'          => $faker->boolean,
        'medicare_ptan'           => $faker->word,
        'use_course'              => $faker->boolean,
        'use_course_staff'        => $faker->boolean,
        'manage_staff'            => $faker->boolean,
        'cc_id'                   => $faker->regexify('cus_[A-Za-z0-9_]+'),
        'user_type'               => $faker->randomDigit,
        'letter_margin_header'    => $faker->randomDigit,
        'letter_margin_footer'    => $faker->randomDigit,
        'letter_margin_top'       => $faker->randomDigit,
        'letter_margin_bottom'    => $faker->randomDigit,
        'letter_margin_left'      => $faker->randomDigit,
        'letter_margin_right'     => $faker->randomDigit,
        'claim_margin_top'        => $faker->randomDigit,
        'claim_margin_left'       => $faker->randomDigit,
        'logo'                    => $faker->regexify('user_logo_[0-9]+\.(gif|png|bmp|jpg|jpeg)'),
        'use_letter_header'       => $faker->boolean,
        'access_code_id'          => $faker->randomDigit,
        'first_name'              => $faker->firstNameMale,
        'last_name'               => $faker->lastName,
        'indent_address'          => $faker->boolean,
        'registration_date'       => $faker->dateTime,
        'header_space'            => $faker->randomDigit,
        'billing_company_id'      => $faker->randomDigit,
        'edx_id'                  => $faker->randomDigit,
        'help_id'                 => $faker->randomDigit,
        'tracker_letters'         => $faker->randomDigit,
        'intro_letters'           => $faker->randomDigit,
        'plan_id'                 => $faker->randomDigit,
        'suspended_reason'        => $faker->word,
        'suspended_date'          => $faker->dateTime,
        'updated_at'              => $faker->dateTime,
        'signature_file'          => $faker->word,
        'signature_json'          => $faker->word,
        'use_service_npi'         => $faker->randomDigit,
        'service_name'            => $faker->name,
        'service_address'         => $faker->address,
        'service_city'            => $faker->city,
        'service_state'           => $faker->stateAbbr,
        'service_zip'             => $faker->numerify('#####'),
        'service_phone'           => $faker->numerify('##########'),
        'service_fax'             => $faker->numerify('##########'),
        'service_npi'             => $faker->numerify('#'),
        'service_medicare_npi'    => $faker->numerify('#'),
        'service_medicare_ptan'   => $faker->word,
        'service_tax_id_or_ssn'   => $faker->word,
        'service_ssn'             => $faker->randomDigit,
        'service_ein'             => $faker->randomDigit,
        'eligible_test'           => $faker->randomDigit,
        'billing_plan_id'         => $faker->randomDigit,
        'post_ledger_adjustments' => $faker->randomDigit,
        'edit_ledger_entries'     => $faker->randomDigit,
        'use_payment_reports'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\UserCompany::class, function () {
    return [];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ClaimNote::class, function (\Faker\Generator $faker) {
    return [
        'claim_id'    => $faker->randomDigit,
        'create_type' => $faker->randomDigit,
        'creator_id'  => $faker->randomDigit,
        'note'        => $faker->sentence($nbWords = 5),
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ClaimElectronic::class, function (\Faker\Generator $faker) {
    return [
        'claimid'         => $faker->randomDigit,
        'response'        => $faker->sentence($nbWords = 6),
        'adddate'         => $faker->dateTime,
        'ip_address'      => $faker->ipv4,
        'reference_id'    => $faker->word,
        'percase_date'    => $faker->dateTime,
        'percase_name'    => $faker->sentence($nbWords = 3),
        'percase_amount'  => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
        'percase_status'  => $faker->randomDigit,
        'percase_invoice' => $faker->randomDigit,
        'percase_free'    => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ClaimText::class, function (\Faker\Generator $faker) {
    return [
        'title'        => $faker->word,
        'description'  => $faker->sentence($nbWords = 6),
        'adddate'      => $faker->dateTime,
        'ip_address'   => $faker->ipv4,
        'default_text' => $faker->randomDigit,
        'companyid'    => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\AppointmentType::class, function (\Faker\Generator $faker) {
    return [
        'name'      => $faker->word,
        'color'     => $faker->hexcolor,
        'classname' => $faker->word,
        'docid'     => $faker->randomDigit,
    ];
});

$factory->define(\DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary::class, function (\Faker\Generator $faker) {
    return [
        'patientid' => $faker->randomDigit,
        'segmentid' => $faker->randomDigit,
        'date_scheduled' => $faker->dateTime,
        'date_completed' => $faker->dateTime,
        'delay_reason' => $faker->word,
        'study_type' => $faker->word,
        'letterid' => $faker->word,
        'description' => $faker->word,
        'noncomp_reason' => $faker->word,
        'device_date' => $faker->dateTime,
        'appointment_type' => $faker->randomDigit,
        'device_id' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\AccessCode::class, function (\Faker\Generator $faker) {
    return [
        'access_code' => $faker->word,
        'notes'       => $faker->sentence($nbWords = 6),
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
        'plan_id'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ClaimNoteAttachment::class, function (\Faker\Generator $faker) {
    return [
        'note_id'    => $faker->randomDigit,
        'filename'   => $faker->sentence($nbWords = 6),
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ChangeList::class, function (\Faker\Generator $faker) {
    return [
        'content'    => $faker->paragraph($nbSentences = 3),
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Complaint::class, function (\Faker\Generator $faker) {
    return [
        'complaint'   => $faker->sentence($nbWords = 6),
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Allergen::class, function (\Faker\Generator $faker) {
    return [
        'allergens'   => $faker->word,
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\CustomText::class, function (\Faker\Generator $faker) {
    return [
        'title'        => $faker->sentence($nbWords = 3),
        'description'  => $faker->sentence($nbWords = 6),
        'docid'        => $faker->randomDigit,
        'status'       => $faker->randomDigit,
        'adddate'      => $faker->dateTime,
        'ip_address'   => $faker->ipv4,
        'default_text' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Contact::class, function (\Faker\Generator $faker) {
    return [
        'docid'                => $faker->randomDigit,
        'salutation'           => $faker->title,
        'lastname'             => $faker->lastName,
        'firstname'            => $faker->firstName,
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
        'greeting'             => $faker->title,
        'sincerely'            => $faker->title,
        'contacttypeid'        => $faker->randomDigit,
        'notes'                => $faker->sentence($nbWords = 6),
        'preferredcontact'     => $faker->word,
        'status'               => $faker->randomDigit,
        'referredby_info'      => $faker->randomDigit,
        'referredby_notes'     => $faker->sentence($nbWords = 6),
        'merge_id'             => $faker->randomDigit,
        'merge_date'           => $faker->dateTime,
        'corporate'            => $faker->randomDigit,
        'dea_number'           => $faker->word,
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\CorporateContact::class, function (\Faker\Generator $faker) {
    return [
        'docid'                => $faker->randomDigit,
        'salutation'           => $faker->title,
        'lastname'             => $faker->lastName,
        'firstname'            => $faker->firstName,
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
        'greeting'             => $faker->title,
        'sincerely'            => $faker->title,
        'contacttypeid'        => $faker->randomDigit,
        'notes'                => $faker->sentence($nbWords = 6),
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Device::class, function (\Faker\Generator $faker) {
    return [
        'device'      => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
        'image_path'  => $faker->regexify('dental_device_[0-9]{2}\.(gif|jpg|jpeg|png)'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ContactType::class, function (\Faker\Generator $faker) {
    return [
        'contacttype' => $faker->sentence($nbWords = 3),
        'ip_address'  => $faker->ipv4,
        'physician'   => $faker->randomDigit,
        'corporate'   => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Calendar::class, function (\Faker\Generator $faker) {
    return [
        'start_date'   => Carbon::now()->addDays(1),
        'end_date'     => Carbon::now()->addDays(2),
        'description'  => $faker->sentence($nbWords = 6),
        'event_id'     => $faker->regexify('[0-9]{13}'),
        'docid'        => $faker->randomDigit,
        'adddate'      => $faker->dateTime,
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

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Charge::class, function (\Faker\Generator $faker) {
    return [
        'amount'                  => $faker->regexify('^\d*(\.\d{2})?$'),
        'userid'                  => $faker->randomDigit,
        'adminid'                 => $faker->randomDigit,
        'charge_date'             => $faker->dateTime,
        'stripe_customer'         => $faker->regexify('cus_[A-Z0-9a-z]{14}'),
        'stripe_charge'           => $faker->regexify('ch_[A-Z0-9a-z]{20}'),
        'stripe_card_fingerprint' => $faker->regexify('[A-Z0-9a-z]{30}'),
        'adddate'                 => $faker->dateTime,
        'ip_address'              => $faker->ipv4,
        'invoice_id'              => $faker->randomDigit,
        'status'                  => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption::class, function (\Faker\Generator $faker) {
    return [
        'option_id'  => $faker->randomDigit,
        'setting_id' => $faker->randomDigit,
        'label'      => $faker->sentence($nbWords = 3),
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\GuideDeviceSetting::class, function (\Faker\Generator $faker) {
    return [
        'device_id'  => $faker->randomDigit,
        'setting_id' => $faker->randomDigit,
        'value'      => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Document::class, function (\Faker\Generator $faker) {
    return [
        'categoryid' => $faker->randomDigit,
        'name'       => $faker->word,
        'filename'   => $faker->regexify('[A-Za-z0-9]{15}\.(gif|jpg|jpeg|png)'),
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\GuideDevice::class, function (\Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LoginDetail::class, function (\Faker\Generator $faker) {
    return [
        'loginid'    => $faker->randomDigit,
        'userid'     => $faker->randomDigit,
        'cur_page'   => $faker->word,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory::class, function (\Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Sleeplab::class, function (\Faker\Generator $faker) {
    return [
        'docid'      => $faker->randomDigit,
        'salutation' => $faker->word,
        'lastname'   => $faker->lastName,
        'firstname'  => $faker->firstNameMale,
        'middlename' => $faker->regexify('[A-Z]'),
        'company'    => $faker->company,
        'add1'       => $faker->address,
        'add2'       => $faker->address,
        'city'       => $faker->city,
        'state'      => $faker->stateAbbr,
        'zip'        => $faker->numerify('#####'),
        'phone1'     => $faker->numerify('##########'),
        'phone2'     => $faker->numerify('##########'),
        'fax'        => $faker->numerify('##########'),
        'email'      => $faker->email,
        'greeting'   => $faker->word,
        'sincerely'  => $faker->word,
        'notes'      => $faker->sentence($nbWords = 5),
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsurancePayer::class, function (\Faker\Generator $faker) {
    return [
        'name'       => $faker->sentence($nbWords = 5),
        'payer_id'   => $faker->numerify('#####'),
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting::class, function (\Faker\Generator $faker) {
    return [
        'name'              => $faker->name,
        'setting_type'      => $faker->randomDigit,
        'range_start'       => $faker->randomDigit,
        'range_end'         => $faker->randomDigit,
        'adddate'           => $faker->dateTime,
        'ip_address'        => $faker->ipv4,
        'rank'              => $faker->randomDigit,
        'options'           => $faker->randomDigit,
        'range_start_label' => $faker->word,
        'range_end_label'   => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Diagnostic::class, function (\Faker\Generator $faker) {
    return [
        'diagnostic'  => $faker->sentence($nbWords = 6),
        'description' => $faker->paragraph,
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\FaxErrorCode::class, function (\Faker\Generator $faker) {
    return [
        'error_code'  => $faker->numerify('2####'),
        'description' => $faker->sentence($nbWords = 6),
        'resolution'  => $faker->sentence($nbWords = 8),
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\EpworthSleepinessScale::class, function (\Faker\Generator $faker) {
    return [
        'epworth'     => $faker->sentence($nbWords = 4),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany::class, function (\Faker\Generator $faker) {
    return [
        'software' => $faker->username,
        'api_key' => $faker->md5,
        'valid_from' => $faker->date() . ' ' . $faker->time(),
        'valid_to' => $faker->date() . ' ' . $faker->time(),
        'name' => $faker->company,
        'short_name' => $faker->slug,
        'url' => $faker->url,
        'description' => $faker->catchPhrase,
        'status' => $faker->randomElement([1, 2, 3]),
        'reason' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient::class, function (\Faker\Generator $faker) {
    return [
        'software' => $faker->username,
        'external_id' => $faker->regexify('[a-zA-Z]{2}-\d{1,2}'),
        'patient_id' => $faker->randomDigit,
        'dirty' => 0,
        'payer_name' => $faker->company,
        'payer_address1' => $faker->address,
        'payer_address2' => $faker->address,
        'payer_city' => $faker->city,
        'payer_state' => $faker->stateAbbr,
        'payer_zip' => $faker->numerify('#####'),
        'payer_phone' => $faker->numerify('#######'),
        'payer_fax' => $faker->numerify('#######'),
        'subscriber_phone' => $faker->numerify('#######'),
        'dependent_phone' => $faker->numerify('#######'),
        'lastname' => $faker->lastName,
        'firstname' => $faker->firstName,
        'middlename' => $faker->suffix,
        'salutation' => $faker->title,
        'dob' => $faker->dateTime->format('m/d/Y'),
        'ssn' => $faker->numerify('#########'),
        'gender' => $faker->randomElement(['F', 'M']),
        'marital_status' => $faker->randomElement([1, 2, 3, 4]),
        'feet' => $faker->numberBetween(1, 8),
        'inches' => $faker->numberBetween(0, 11),
        'weight' => $faker->numberBetween(1, 250),
        'add1' => $faker->address,
        'add2' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'zip' => $faker->numerify('#####'),
        'home_phone' => $faker->numerify('#######'),
        'work_phone' => $faker->numerify('#######'),
        'cell_phone' => $faker->numerify('#######'),
        'email' => $faker->email,
        'p_m_relation' => $faker->randomElement(['self', 'spouse', 'child', 'other']),
        'p_m_ins_id' => $faker->word,
        'p_m_partyfname' => $faker->firstName,
        'p_m_partylname' => $faker->lastName,
        'p_m_partymname' => $faker->suffix,
        'p_m_address' => $faker->address,
        'p_m_city' => $faker->city,
        'p_m_state' => $faker->stateAbbr,
        'p_m_zip' => $faker->numerify('#####'),
        'ins_dob' => $faker->dateTime->format('m/d/Y'),
        'p_m_gender' => $faker->randomElement(['F', 'M']),
        'p_m_ins_grp' => $faker->word,
        'p_m_ins_plan' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser::class, function (\Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'api_key' => $faker->md5,
        'valid_from' => $faker->date() . ' ' . $faker->time(),
        'valid_to' => $faker->date() . ' ' . $faker->time(),
        'enabled' => $faker->boolean,
        'created_by' => $faker->randomDigit,
        'updated_by' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Qualifier::class, function (\Faker\Generator $faker) {
    return [
        'qualifier'   => $faker->sentence($nbWords = 5),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceType::class, function (\Faker\Generator $faker) {
    return [
        'ins_type'    => $faker->sentence($nbWords = 5),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SoftPalate::class, function (\Faker\Generator $faker) {
    return [
        'soft_palate' => $faker->sentence($nbWords = 4),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceDocument::class, function (\Faker\Generator $faker) {
    return [
        'title'       => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'video_file'  => $faker->regexify('[A-Za-z0-9]{15}\.flv'),
        'doc_file'    => $faker->regexify('[A-Za-z0-9]{15}\.(gif|jpg|jpeg|png)'),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
        'docid'       => $faker->regexify('[0-9]{2}'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Fax::class, function (\Faker\Generator $faker) {
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
        'viewed'               => $faker->boolean($chanceOfGettingTrue = 50),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TonsilsClinicalExam::class, function (\Faker\Generator $faker) {
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
        'adddate'          => $faker->dateTime,
        'ip_address'       => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SleepTest::class, function (\Faker\Generator $faker) {
    $epworthIds = [
        '1|1~2|2~5|3~7|3~8|2~',
        '1|3~2|2~3|2~4|3~5|3~6|3~7|3~8|2~',
        '1|1~2|3~3|2~4|2~5|3~6|3~7|2~8|1~'
    ];

    return [
        'formid'           => $faker->randomDigit,
        'patientid'        => $faker->randomDigit,
        'epworthid'        => $faker->randomElement($epworthIds),
        'analysis'         => $faker->sentence($nbWords = 5),
        'userid'           => $faker->randomDigit,
        'docid'            => $faker->randomDigit,
        'status'           => $faker->randomDigit,
        'adddate'          => $faker->dateTime,
        'ip_address'       => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TongueClinicalExam::class, function (\Faker\Generator $faker) {
    return [
        'formid'               => $faker->randomDigit,
        'blood_pressure'       => $faker->regexify('[1-2][0-9]{2}\/([5-9][0-9]|1[0-9]{2})'),
        'pulse'                => $faker->randomDigit,
        'neck_measurement'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 60),
        'bmi'                  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 40),
        'additional_paragraph' => $faker->sentence($nbWords = 3),
        'tongue'               => $faker->regexify('~([0-9]~)+'),
        'status'               => $faker->randomDigit,
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SocialHistory::class, function (\Faker\Generator $faker) {
    return [
        'formid'               => $faker->randomDigit,
        'patientid'            => $faker->randomDigit,
        'family_had'           => $faker->sentence($nbWords = 4),
        'family_diagnosed'     => $faker->randomElement(['Yes', 'No']),
        'additional_paragraph' => $faker->sentence($nbWords = 7),
        'alcohol'              => $faker->word,
        'sedative'             => $faker->word,
        'caffeine'             => $faker->word,
        'smoke'                => $faker->randomElement(['Yes', 'No']),
        'smoke_packs'          => $faker->numerify('#'),
        'tobacco'              => $faker->randomElement(['Yes', 'No']),
        'userid'               => $faker->randomDigit,
        'docid'                => $faker->randomDigit,
        'status'               => $faker->randomDigit,
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
        'parent_patientid'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\AirwayEvaluation::class, function (\Faker\Generator $faker) {
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
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\DentalClinicalExam::class, function (\Faker\Generator $faker) {
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
        'adddate'                          => $faker->dateTime,
        'ip_address'                       => $faker->ipv4,
        'missing'                          => $faker->randomElement($teethNumbers),
        'crossbite'                        => $faker->randomElement($teethPairs),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam::class, function (\Faker\Generator $faker) {
    $palpation = [
        '1|1~3|4~5|0~',
        '1|0~2|0~3|0~4|0~5|0~6|0~7|0~8|0~9|0~10|0~11|0~12|0~13|0~',
        '1|0~2|0~3|0~4|0~5|0~6|0~7|0~',
        '1|0~2|0~3|0~4|0~5|0~6|0~7|0~',
        '7|3~11|3~',
    ];

    $joints = [
        '1|L~2|L~3|R~4|B~5|B~',
        '1|WNL~2|WNL~3|WNL~4|WNL~5|WNL~',
        '1|B~2|R~3|R~4|R~5|R~',
    ];

    return [
        'formid'                   => $faker->randomDigit,
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
        'status'                   => $faker->randomDigit,
        'adddate'                  => $faker->dateTime,
        'ip_address'               => $faker->ipv4,
        'deviation_r_l'            => $faker->randomElement(['Right', 'Left']),
        'deflection_r_l'           => $faker->randomElement(['Right', 'Left']),
        'dentaldevice'             => $faker->randomDigit,
        'dentaldevice_date'        => $faker->dateTime,
        'initial_device_titration_1'       => $faker->randomElement(['-', '+']) . $faker->randomDigit,
        'initial_device_titration_equal_h' => $faker->randomElement(['-', '+']) . $faker->randomDigit,
        'initial_device_titration_equal_v' => $faker->randomElement(['-', '+']) . $faker->randomDigit,
        'optimum_echovision_ver'           => $faker->randomElement(['-', '+']) . $faker->randomDigit,
        'optimum_echovision_hor'           => $faker->randomElement(['-', '+']) . $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\FaxInvoice::class, function (\Faker\Generator $faker) {
    return [
        'invoice_id'  => $faker->randomDigit,
        'description' => $faker->sentence($nbWords = 5),
        'start_date'  => Carbon::now()->addDays(1),
        'end_date'    => Carbon::now()->addDays(10),
        'amount'      => $faker->numerify('5.##'),
        'adddate'     => Carbon::now(),
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\GagReflex::class, function (\Faker\Generator $faker) {
    return [
        'gag_reflex'  => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Mandible::class, function (\Faker\Generator $faker) {
    return [
        'mandible'    => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Medicament::class, function (\Faker\Generator $faker) {
    return [
        'medications' => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\MedicalHistory::class, function (\Faker\Generator $faker) {
    return [
        'history'     => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Joint::class, function (\Faker\Generator $faker) {
    return [
        'joint'       => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 3),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Intolerance::class, function (\Faker\Generator $faker) {
    return [
        'intolerance' => $faker->sentence($nbWords = 4),
        'description' => $faker->word,
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ImageType::class, function (\Faker\Generator $faker) {
    return [
        'imagetype'   => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\JointExam::class, function (\Faker\Generator $faker) {
    return [
        'joint_exam'  => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Maxilla::class, function (\Faker\Generator $faker) {
    return [
        'maxilla'     => $faker->word,
        'description' => $faker->sentence($nbWords = 5),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PatientContact::class, function (\Faker\Generator $faker) {
    return [
        'contacttype' => $faker->randomDigit,
        'patientid'   => $faker->randomDigit,
        'firstname'   => $faker->firstNameMale,
        'lastname'    => $faker->lastName,
        'address1'    => $faker->address,
        'address2'    => $faker->address,
        'city'        => $faker->city,
        'state'       => $faker->stateAbbr,
        'zip'         => $faker->numerify('#####'),
        'phone'       => $faker->numerify('##########'),
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Insurance::class, function (\Faker\Generator $faker) {
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
        'mailed_date'                       => $faker->dateTime,
        'p_m_eligible_payer_id'             => $faker->numerify('####'),
        'p_m_eligible_payer_name'           => $faker->name,
        'eligible_token'                    => $faker->regexify('[0-9a-zA-Z]{15}'),
        'percase_date'                      => $faker->dateTime,
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
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceFile::class, function (\Faker\Generator $faker) {
    return [
        'claimid'     => $faker->randomDigit,
        'claimtype'   => $faker->randomElement(['primary', 'secondary']),
        'filename'    => $faker->regexify('DSS_Logo_[0-9]{6}_[0-9]{4}_[0-9]{6}_[0-9]{4}\.(gif|jpg|jpeg|png)'),
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
        'description' => $faker->sentence($nbWords = 5),
        'status'      => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceHistory::class, function (\Faker\Generator $faker) {
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
        'adddate'                           => $faker->dateTime,
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
        'primary_claim_version'             => $faker->randomDigit,
        'secondary_claim_version'           => $faker->randomDigit,
        'icd_ind'                           => $faker->randomDigit,
        'name_referring_provider_qualifier' => $faker->regexify('[A-Z]{2}'),
        'diagnosis_a'                       => $faker->sentence($nbWords = 4),
        'updated_by_user'                   => $faker->randomDigit,
        'updated_by_admin'                  => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsuranceStatusHistory::class, function (\Faker\Generator $faker) {
    return [
        'insuranceid' => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'userid'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
        'adminid'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth::class, function (\Faker\Generator $faker) {
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
        'in_written_pre_auth_notes'         => $faker->sentence($nbWords = 5),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LedgerNote::class, function (\Faker\Generator $faker) {
    return [
        'producerid'       => $faker->randomDigit,
        'note'             => $faker->sentence($nbWords = 4),
        'private'          => $faker->randomDigit,
        'service_date'     => $faker->dateTime,
        'entry_date'       => $faker->dateTime,
        'patientid'        => $faker->randomDigit,
        'adddate'          => $faker->dateTime,
        'ip_address'       => $faker->ipv4,
        'docid'            => $faker->randomDigit,
        'admin_producerid' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Ledger::class, function (\Faker\Generator $faker) {
    return [
        'formid'                 => $faker->randomDigit,
        'patientid'              => $faker->randomDigit,
        'service_date'           => $faker->dateTime,
        'entry_date'             => $faker->dateTime,
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
        'percase_date'           => $faker->dateTime,
        'percase_name'           => $faker->name,
        'percase_amount'         => $faker->numerify('###.##'),
        'percase_status'         => $faker->randomDigit,
        'percase_invoice'        => $faker->randomDigit,
        'percase_free'           => $faker->randomDigit,
        'secondary_claim_id'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LedgerHistory::class, function (\Faker\Generator $faker) {
    return [
            'ledgerid'                 => $faker->randomDigit,
            'formid'                   => $faker->randomDigit,
            'patientid'                => $faker->randomDigit,
            'service_date'             => $faker->dateTime,
            'entry_date'               => $faker->dateTime,
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
            'percase_date'             => $faker->dateTime,
            'percase_name'             => $faker->name,
            'percase_amount'           => $faker->regexify('[0-9]+\.[0-9]{2}'),
            'percase_status'           => $faker->randomDigit,
            'percase_invoice'          => $faker->randomDigit,
            'percase_free'             => $faker->randomDigit,
            'updated_by_user'          => $faker->randomDigit,
            'updated_by_admin'         => $faker->randomDigit,
            'primary_claim_history_id' => $faker->randomDigit,
            'secondary_claim_id'       => $faker->randomDigit,
        ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LedgerPayment::class, function (\Faker\Generator $faker) {
    return [
        'payer'          => $faker->randomDigit,
        'amount'         => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 3000),
        'payment_type'   => $faker->randomDigit,
        'payment_date'   => $faker->dateTime,
        'entry_date'     => $faker->dateTime,
        'ledgerid'       => $faker->randomDigit,
        'allowed'        => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'ins_paid'       => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 800),
        'deductible'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'copay'          => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 800),
        'coins'          => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'overpaid'       => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 800),
        'followup'       => $faker->dateTime,
        'note'           => $faker->sentence($nbWords = 5),
        'amount_allowed' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LedgerPaymentHistory::class, function (\Faker\Generator $faker) {
    return [
        'paymentid'         => $faker->randomDigit,
        'payer'             => $faker->randomDigit,
        'amount'            => $faker->numerify('###.##'),
        'payment_type'      => $faker->randomDigit,
        'payment_date'      => $faker->dateTime,
        'entry_date'        => $faker->dateTime,
        'ledgerid'          => $faker->randomDigit,
        'allowed'           => $faker->numerify('###.##'),
        'ins_paid'          => $faker->numerify('###.##'),
        'deductible'        => $faker->numerify('###.##'),
        'copay'             => $faker->numerify('###.##'),
        'coins'             => $faker->numerify('###.##'),
        'overpaid'          => $faker->numerify('###.##'),
        'followup'          => $faker->dateTime,
        'note'              => $faker->sentence($nbWords = 5),
        'amount_allowed'    => $faker->numerify('###.##'),
        'updated_by_user'   => $faker->boolean($chanceOfGettingTrue = 50),
        'updated_by_admin'  => $faker->boolean($chanceOfGettingTrue = 50),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LedgerRecord::class, function (\Faker\Generator $faker) {
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
        'transaction_code' => $faker->regexify('[A-Z][0-9]{4}'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement::class, function (\Faker\Generator $faker) {
    return [
        'producerid'   => $faker->randomDigit,
        'filename'     => $faker->regexify('\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf'),
        'service_date' => $faker->dateTime,
        'entry_date'   => $faker->dateTime,
        'patientid'    => $faker->randomDigit,
        'adddate'      => $faker->dateTime,
        'ip_address'   => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\LetterTemplate::class, function (\Faker\Generator $faker) {
    return [
        'name'           => $faker->sentence($nbWords = 4),
        'template'       => $faker->regexify('\/manage\/([a-z]+_)+[a-z]+\.php'),
        'body'           => $faker->sentence($nbWords = 6),
        'default_letter' => $faker->randomDigit,
        'companyid'      => $faker->randomDigit,
        'triggerid'      => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\CustomLetterTemplate::class, function (\Faker\Generator $faker) {
    return [
        'name'       => $faker->sentence($nbWords = 3),
        'body'       => $faker->sentence($nbWords = 6),
        'docid'      => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
        'status'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Letter::class, function (\Faker\Generator $faker) {
    return [
        'patientid'            => $faker->randomDigit,
        'stepid'               => $faker->randomDigit,
        'delivery_date'        => $faker->dateTime,
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
        'date_sent'            => $faker->dateTime,
        'info_id'              => $faker->randomDigit,
        'edit_userid'          => $faker->randomDigit,
        'mailed_date'          => $faker->dateTime,
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
        'deleted_on'           => $faker->dateTime,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Location::class, function (\Faker\Generator $faker) {
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
        'email'            => $faker->email,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Login::class, function (\Faker\Generator $faker) {
    return [
        'docid'       => $faker->randomDigit,
        'userid'      => $faker->randomDigit,
        'login_date'  => $faker->dateTime,
        'logout_date' => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Note::class, function (\Faker\Generator $faker) {
    return [
        'patientid'       => 0,
        'notes'           => $faker->sentence($nbWords = 5),
        'edited'          => $faker->boolean,
        'editor_initials' => $faker->word,
        'userid'          => 0,
        'docid'           => 0,
        'status'          => 0,
        'adddate'         => null,
        'procedure_date'  => '',
        'ip_address'      => $faker->ipv4,
        'signed_id'       => 0,
        'signed_on'       => null,
        'parentid'        => 0,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Palpation::class, function (\Faker\Generator $faker) {
    return [
        'palpation'   => $faker->sentence($nbWords = 4),
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Refund::class, function (\Faker\Generator $faker) {
    return [
        'amount'      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'userid'      => $faker->randomDigit,
        'adminid'     => $faker->randomDigit,
        'refund_date' => $faker->dateTime,
        'charge_id'   => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ScreenerEpworth::class, function (\Faker\Generator $faker) {
    return [
        'screener_id' => $faker->randomDigit,
        'epworth_id'  => $faker->randomDigit,
        'response'    => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PatientInsurance::class, function (\Faker\Generator $faker) {
    return [
        'patientid'     => $faker->randomDigit,
        'insurancetype' => $faker->randomDigit,
        'company'       => $faker->sentence($nbWords = 4),
        'address1'      => $faker->address,
        'address2'      => $faker->address,
        'city'          => $faker->city,
        'state'         => $faker->stateAbbr,
        'zip'           => $faker->numerify('#####'),
        'phone'         => $faker->numerify('##########'),
        'fax'           => $faker->numerify('(###) ###-####'),
        'email'         => $faker->email,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary::class, function (\Faker\Generator $faker) {
    return [
        // cannot use random because of PK
        'pid'              => 998,
        'fspage1_complete' => $faker->boolean,
        'next_visit'       => $faker->dateTime,
        'last_visit'       => $faker->dateTime,
        'last_treatment'   => $faker->sentence($nbWords = 3),
        'appliance'        => $faker->randomDigit,
        'delivery_date'    => $faker->dateTime,
        'vob'              => $faker->numerify('#'),
        'ledger'           => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'patient_info'     => $faker->boolean,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Patient::class, function (\Faker\Generator $faker) {
    return [
        'lastname'                => $faker->lastName,
        'firstname'               => $faker->firstNameMale,
        'middlename'              => $faker->regexify('[A-Z]'),
        'salutation'              => $faker->title,
        'member_no'               => $faker->word,
        'group_no'                => $faker->numerify('##'),
        'plan_no'                 => $faker->numerify('##'),
        'dob'                     => $faker->dateTime->format('m/d/Y'),
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
        'adddate'                 => $faker->dateTime,
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
        'ins_dob'                 => $faker->dateTime,
        'ins2_dob'                => $faker->dateTime,
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
        'referred_source'         => $faker->randomDigit,
        'referred_by'             => $faker->randomDigit,
        'premedcheck'             => $faker->randomDigit,
        'premed'                  => $faker->word,
        'docsleep'                => $faker->word,
        'docpcp'                  => $faker->word,
        'docdentist'              => $faker->word,
        'docent'                  => $faker->word,
        'docmdother'              => $faker->word,
        'preferredcontact'        => $faker->randomElement(['email', 'paper']),
        'copyreqdate'             => $faker->dateTime->format('m/d/Y'),
        'best_time'               => $faker->randomElement(['morning', 'midday', 'evening']),
        'best_number'             => $faker->randomElement(['home', 'work']),
        'emergency_relationship'  => $faker->word,
        'has_s_m_ins'             => $faker->randomElement(['No', 'Yes']),
        'referred_notes'          => $faker->sentence($nbWords = 5),
        'login'                   => $faker->word,
        'recover_hash'            => $faker->regexify('[A-Za-z0-9]{20}'),
        'recover_time'            => $faker->dateTime,
        'registered'              => $faker->randomDigit,
        'access_code'             => $faker->numerify('######'),
        'parent_patientid'        => $faker->randomDigit,
        'has_p_m_ins'             => $faker->word,
        'registration_status'     => $faker->randomDigit,
        'text_date'               => $faker->dateTime,
        'text_num'                => $faker->randomDigit,
        'use_patient_portal'      => $faker->randomDigit,
        'registration_senton'     => $faker->dateTime,
        'preferred_name'          => $faker->firstNameMale,
        'feet'                    => $faker->numerify('##'),
        'inches'                  => $faker->numerify('##'),
        'weight'                  => $faker->numerify('##'),
        'bmi'                     => $faker->numerify('##.#'),
        'symptoms_status'         => $faker->randomDigit,
        'sleep_status'            => $faker->randomDigit,
        'treatments_status'       => $faker->randomDigit,
        'history_status'          => $faker->randomDigit,
        'access_code_date'        => $faker->dateTime,
        'email_bounce'            => $faker->randomDigit,
        'docmdother2'             => $faker->numerify('##'),
        'docmdother3'             => $faker->numerify('##'),
        'last_reg_sect'           => $faker->randomDigit,
        'access_type'             => $faker->randomDigit,
        'p_m_eligible_id'         => $faker->numerify('####'),
        'p_m_eligible_payer_id'   => $faker->regexify('[A-Z][0-9]{4}'),
        'p_m_eligible_payer_name' => $faker->regexify('[A-Z]{4}'),
        'p_m_gender'              => $faker->randomElement(['Male', 'Female']),
        's_m_gender'              => $faker->randomElement(['Male', 'Female']),
        'p_m_same_address'        => $faker->randomDigit,
        'p_m_address'             => $faker->address,
        'p_m_state'               => $faker->stateAbbr,
        'p_m_city'                => $faker->city,
        'p_m_zip'                 => $faker->numerify('#####'),
        's_m_same_address'        => $faker->numerify('#'),
        's_m_address'             => $faker->address,
        's_m_city'                => $faker->city,
        's_m_state'               => $faker->stateAbbr,
        's_m_zip'                 => $faker->numerify('#####'),
        'new_fee_date'            => $faker->dateTime,
        'new_fee_amount'          => $faker->numerify('###.##'),
        'new_fee_desc'            => $faker->sentence($nbWords = 4),
        'new_fee_invoice_id'      => $faker->randomDigit,
        's_m_eligible_payer_id'   => $faker->word,
        's_m_eligible_payer_name' => $faker->word,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PaymentReport::class, function (\Faker\Generator $faker) {
    $json = [
        'reference_id' => '137073682155420112914',
        'details' => [
            'created_at' => '2013-06-17T04:24:49Z',
            'messages' => [],
        ],
        'event' => 'payment_report',
    ];

    return [
        'claimid'      => $faker->randomDigit,
        'reference_id' => $faker->regexify('[A-Z0-9]{15}'),
        'response'     => json_encode($json),
        'adddate'      => $faker->dateTime,
        'ip_address'   => $faker->ipv4,
        'viewed'       => $faker->boolean,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PlaceService::class, function (\Faker\Generator $faker) {
    return [
        'place_service' => $faker->numerify('##'),
        'description'   => $faker->sentence($nbWords = 5),
        'sortby'        => $faker->randomDigit,
        'status'        => $faker->randomDigit,
        'adddate'       => $faker->dateTime,
        'ip_address'    => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Plan::class, function (\Faker\Generator $faker) {
    return [
        'name'             => $faker->word,
        'monthly_fee'      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'trial_period'     => $faker->randomDigit,
        'fax_fee'          => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'free_fax'         => $faker->randomDigit,
        'status'           => $faker->randomDigit,
        'adddate'          => $faker->dateTime,
        'ip_address'       => $faker->ipv4,
        'eligibility_fee'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'free_eligibility' => $faker->randomDigit,
        'enrollment_fee'   => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'free_enrollment'  => $faker->randomDigit,
        'claim_fee'        => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'free_claim'       => $faker->randomDigit,
        'vob_fee'          => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'free_vob'         => $faker->randomDigit,
        'office_type'      => $faker->randomDigit,
        'efile_fee'        => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'free_efile'       => $faker->randomDigit,
        'duration'         => $faker->randomDigit,
        'producer_fee'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'user_fee'         => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'patient_fee'      => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'e0486_bill'       => $faker->randomDigit,
        'e0486_fee'        => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Procedure::class, function (\Faker\Generator $faker) {
    return [
        'patientid'          => $faker->randomDigit,
        'insuranceid'        => $faker->randomDigit,
        'service_date_from'  => $faker->date($format = 'm/d/Y', $max = 'now'),
        'service_date_to'    => $faker->date($format = 'm/d/Y', $max = 'now'),
        'place_service'      => $faker->numerify('#'),
        'type_service'       => $faker->numerify('#'),
        'cpt_code'           => $faker->numerify('#'),
        'units'              => $faker->numerify('#.#'),
        'charge'             => $faker->numerify('###.##'),
        'total_charge'       => $faker->numerify('###.##'),
        'applies_icd'        => $faker->numerify('#,#'),
        'npi'                => $faker->word,
        'other_id'           => $faker->numerify('###'),
        'other_id_qualifier' => $faker->numerify('#'),
        'modifier_code_1'    => $faker->numerify('#'),
        'modifier_code_2'    => $faker->numerify('#'),
        'modifier_code_3'    => $faker->numerify('#'),
        'modifier_code_4'    => $faker->numerify('#'),
        'epsdt'              => $faker->numerify('#'),
        'emg'                => $faker->word,
        'supplemental_info'  => $faker->word,
        'docid'              => $faker->randomDigit,
        'status'             => $faker->randomDigit,
        'adddate'            => $faker->dateTime,
        'ip_address'         => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage::class, function (\Faker\Generator $faker) {
    return [
        'formid'      => $faker->randomDigit,
        'patientid'   => $faker->randomDigit,
        'title'       => $faker->word,
        'image_file'  => $faker->regexify('[A-Za-z0-9]{15}\.(jpg|gif|png)'),
        'imagetypeid' => $faker->randomDigit,
        'userid'      => $faker->randomDigit,
        'docid'       => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
        'adminid'     => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Symptom::class, function (\Faker\Generator $faker) {
    $complaintIds = [
        '1|5~10|6~11|2~12|19~13|4~14|18~15|17~16|1~0|1~',
        '1|1~11|4~17|2~20|5~22|6~26|3~0|1~',
        '1|1~11|1~12|1~13|1~15|1~19|1~22|1~0|1~',
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
        'adddate'                => $faker->dateTime,
        'ip_address'             => $faker->ipv4,
        'quit_breathing'         => $faker->sentence($nbWords = 5),
        'bed_time_partner'       => $faker->randomElement(['Yes', 'Sometimes', 'No']),
        'sleep_same_room'        => $faker->randomElement(['Yes', 'Sometimes', 'No']),
        'told_you_snore'         => $faker->randomElement(['Yes', 'Sometimes', 'No']),
        'main_reason'            => $faker->sentence($nbWords = 5),
        'main_reason_other'      => $faker->sentence($nbWords = 5),
        'exam_date'              => $faker->dateTime,
        'chief_complaint_text'   => $faker->sentence($nbWords = 5),
        'tss'                    => $faker->numerify('##'),
        'ess'                    => $faker->numerify('##'),
        'parent_patientid'       => $faker->randomDigit
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PreviousTreatment::class, function (\Faker\Generator $faker) {
    return [
        'formid'                 => $faker->randomDigit,
        'patientid'              => $faker->randomDigit,
        'polysomnographic'       => $faker->randomDigit,
        'sleep_center_name'      => $faker->numerify('##'),
        'sleep_study_on'         => $faker->dateTime->format('m/d/Y'),
        'confirmed_diagnosis'    => $faker->numerify('###.##'),
        'rdi'                    => $faker->numerify('##'),
        'ahi'                    => $faker->numerify('##'),
        'cpap'                   => $faker->randomElement(['Yes', 'No']),
        'intolerance'            => $faker->regexify('~([0-9]+~)+'),
        'other_intolerance'      => $faker->sentence($nbWords = 5),
        'other_therapy'          => $faker->sentence($nbWords = 5),
        'other'                  => $faker->sentence($nbWords = 5),
        'affidavit'              => $faker->word,
        'type_study'             => $faker->word,
        'nights_wear_cpap'       => $faker->numerify('##'),
        'percent_night_cpap'     => $faker->numerify('##'),
        'custom_diagnosis'       => $faker->word,
        'sleep_study_by'         => $faker->word,
        'triedquittried'         => $faker->word,
        'timesovertime'          => $faker->word,
        'cur_cpap'               => $faker->randomElement(['Yes', 'No']),
        'sleep_center_name_text' => $faker->sentence($nbWords = 4),
        'dd_wearing'             => $faker->randomElement(['Yes', 'No']),
        'dd_prev'                => $faker->randomElement(['Yes', 'No']),
        'dd_otc'                 => $faker->randomElement(['Yes', 'No']),
        'dd_fab'                 => $faker->randomElement(['Yes', 'No']),
        'dd_who'                 => $faker->word,
        'dd_experience'          => $faker->sentence($nbWords = 3),
        'surgery'                => $faker->randomElement(['Yes', 'No']),
        'parent_patientid'       => $faker->randomDigit,
        'userid'                 => $faker->randomDigit,
        'docid'                  => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\HealthHistory::class, function (\Faker\Generator $faker) {
    return [
        'formid'                 => $faker->randomDigit,
        'patientid'              => $faker->randomDigit,
        'allergens'              => $faker->regexify('~([0-9]{1,2}~)+'),
        'other_allergens'        => $faker->sentence($nbWords = 4),
        'medications'            => $faker->regexify('~([0-9]{1,2}~)+'),
        'other_medications'      => $faker->sentence($nbWords = 4),
        'history'                => $faker->regexify('~([0-9]{1,2}~)+'),
        'other_history'          => $faker->sentence($nbWords = 4),
        'userid'                 => $faker->randomDigit,
        'docid'                  => $faker->randomDigit,
        'status'                 => $faker->randomDigit,
        'adddate'                => $faker->dateTime,
        'ip_address'             => $faker->ipv4,
        'dental_health'          => $faker->randomElement(['Good', 'Excellent', 'Fair', 'Poor']),
        'removable'              => $faker->randomElement(['Yes', 'No']),
        'year_completed'         => $faker->year,
        'tmj'                    => $faker->sentence($nbWords = 4),
        'gum_problems'           => $faker->word,
        'dental_pain'            => $faker->word,
        'dental_pain_describe'   => $faker->word,
        'completed_future'       => $faker->randomElement(['Yes', 'No']),
        'clinch_grind'           => $faker->randomElement(['Yes', 'No']),
        'wisdom_extraction'      => $faker->randomElement(['Yes', 'No']),
        'injurytohead'           => $faker->randomElement(['Yes', 'No']),
        'injurytoneck'           => $faker->randomElement(['Yes', 'No']),
        'injurytoface'           => $faker->randomElement(['Yes', 'No']),
        'injurytoteeth'          => $faker->randomElement(['Yes', 'No']),
        'injurytomouth'          => $faker->randomElement(['Yes', 'No']),
        'drymouth'               => $faker->randomElement(['Yes', 'No']),
        'jawjointsurgery'        => $faker->randomElement(['Yes', 'No']),
        'no_allergens'           => $faker->numerify('#'),
        'no_medications'         => $faker->numerify('#'),
        'no_history'             => $faker->numerify('#'),
        'orthodontics'           => $faker->randomElement(['Yes', 'No']),
        'wisdom_extraction_text' => $faker->word,
        'removable_text'         => $faker->sentence($nbWords = 6),
        'dentures'               => $faker->randomElement(['Yes', 'No']),
        'dentures_text'          => $faker->sentence($nbWords = 6),
        'tmj_cp'                 => $faker->randomElement(['Yes', 'No']),
        'tmj_cp_text'            => $faker->sentence($nbWords = 6),
        'tmj_pain'               => $faker->randomElement(['Yes', 'No']),
        'tmj_pain_text'          => $faker->sentence($nbWords = 6),
        'tmj_surgery'            => $faker->randomElement(['Yes', 'No']),
        'tmj_surgery_text'       => $faker->sentence($nbWords = 6),
        'injury'                 => $faker->randomElement(['Yes', 'No']),
        'injury_text'            => $faker->sentence($nbWords = 6),
        'gum_prob'               => $faker->randomElement(['Yes', 'No']),
        'gum_prob_text'          => $faker->sentence($nbWords = 6),
        'gum_surgery'            => $faker->randomElement(['Yes', 'No']),
        'gum_surgery_text'       => $faker->sentence($nbWords = 6),
        'clinch_grind_text'      => $faker->sentence($nbWords = 6),
        'future_dental_det'      => $faker->sentence($nbWords = 6),
        'drymouth_text'          => $faker->sentence($nbWords = 6),
        'family_hd'              => $faker->randomElement(['Yes', 'No']),
        'family_bp'              => $faker->randomElement(['Yes', 'No']),
        'family_dia'             => $faker->randomElement(['Yes', 'No']),
        'family_sd'              => $faker->randomElement(['Yes', 'No']),
        'alcohol'                => $faker->word,
        'sedative'               => $faker->word,
        'caffeine'               => $faker->word,
        'smoke'                  => $faker->randomElement(['Yes', 'No']),
        'smoke_packs'            => $faker->numerify('#'),
        'tobacco'                => $faker->randomElement(['Yes', 'No']),
        'additional_paragraph'   => $faker->sentence($nbWords = 7),
        'allergenscheck'         => $faker->boolean,
        'medicationscheck'       => $faker->boolean,
        'historycheck'           => $faker->boolean,
        'parent_patientid'       => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Recipient::class, function (\Faker\Generator $faker) {
    return [
        'formid'              => $faker->randomDigit,
        'patientid'           => $faker->randomDigit,
        'referring_physician' => $faker->sentence($nbWords = 6),
        'dentist'             => $faker->sentence($nbWords = 6),
        'physicians_other'    => $faker->sentence($nbWords = 6),
        'patient_info'        => $faker->sentence($nbWords = 6),
        'q_file1'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file2'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file3'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file4'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file5'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'userid'              => $faker->randomDigit,
        'docid'               => $faker->randomDigit,
        'status'              => $faker->randomDigit,
        'adddate'             => $faker->dateTime,
        'ip_address'          => $faker->ipv4,
        'q_file6'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file7'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file8'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file9'             => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
        'q_file10'            => $faker->regexify('[a-z0-9]{12}\.(gif|png|jpg)'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ReferredByContact::class, function (\Faker\Generator $faker) {
    return [
        'docid'                => $faker->randomDigit,
        'salutation'           => $faker->title,
        'lastname'             => $faker->lastName,
        'firstname'            => $faker->firstName,
        'middlename'           => $faker->word,
        'company'              => $faker->company,
        'add1'                 => $faker->address,
        'add2'                 => $faker->address,
        'city'                 => $faker->city,
        'state'                => $faker->state,
        'zip'                  => $faker->regexify('^[0-9]{5}$'),
        'phone1'               => $faker->regexify('^1[0-9]{9}$'),
        'phone2'               => $faker->regexify('^1[0-9]{9}$'),
        'fax'                  => $faker->regexify('^1[0-9]{9}$'),
        'email'                => $faker->email,
        'national_provider_id' => $faker->regexify('^[0-9]{9}$'),
        'qualifier'            => $faker->randomDigit,
        'qualifierid'          => $faker->word,
        'greeting'             => $faker->title,
        'sincerely'            => $faker->title,
        'contacttypeid'        => $faker->randomDigit,
        'notes'                => $faker->sentence($nbWords = 6),
        'preferredcontact'     => $faker->word,
        'status'               => $faker->randomDigit,
        'referredby_info'      => $faker->randomDigit,
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Chair::class, function (\Faker\Generator $faker) {
    return [
        'name'  => $faker->word,
        'rank'  => $faker->randomDigit,
        'docid' => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Screener::class, function (\Faker\Generator $faker) {
    return [
        'docid'                 => $faker->randomDigit,
        'userid'                => $faker->randomDigit,
        'first_name'            => $faker->firstNameMale,
        'last_name'             => $faker->lastName,
        'email'                 => $faker->email,
        'epworth_reading'       => $faker->randomDigit,
        'epworth_public'        => $faker->randomDigit,
        'epworth_passenger'     => $faker->randomDigit,
        'epworth_lying'         => $faker->randomDigit,
        'epworth_talking'       => $faker->randomDigit,
        'epworth_lunch'         => $faker->randomDigit,
        'epworth_traffic'       => $faker->randomDigit,
        'snore_1'               => $faker->randomDigit,
        'snore_2'               => $faker->randomDigit,
        'snore_3'               => $faker->randomDigit,
        'snore_4'               => $faker->randomDigit,
        'snore_5'               => $faker->randomDigit,
        'breathing'             => $faker->randomDigit,
        'driving'               => $faker->randomDigit,
        'gasping'               => $faker->randomDigit,
        'sleepy'                => $faker->randomDigit,
        'snore'                 => $faker->randomDigit,
        'weight_gain'           => $faker->randomDigit,
        'blood_pressure'        => $faker->randomDigit,
        'jerk'                  => $faker->randomDigit,
        'burning'               => $faker->randomDigit,
        'headaches'             => $faker->randomDigit,
        'falling_asleep'        => $faker->randomDigit,
        'staying_asleep'        => $faker->randomDigit,
        'rx_blood_pressure'     => $faker->randomDigit,
        'rx_hypertension'       => $faker->randomDigit,
        'rx_heart_disease'      => $faker->randomDigit,
        'rx_stroke'             => $faker->randomDigit,
        'rx_apnea'              => $faker->randomDigit,
        'rx_diabetes'           => $faker->randomDigit,
        'rx_lung_disease'       => $faker->randomDigit,
        'rx_insomnia'           => $faker->randomDigit,
        'rx_depression'         => $faker->randomDigit,
        'rx_narcolepsy'         => $faker->randomDigit,
        'rx_medication'         => $faker->randomDigit,
        'rx_restless_leg'       => $faker->randomDigit,
        'rx_headaches'          => $faker->randomDigit,
        'rx_heartburn'          => $faker->randomDigit,
        'adddate'               => $faker->dateTime,
        'ip_address'            => $faker->ipv4,
        'rx_cpap'               => $faker->randomDigit,
        'phone'                 => $faker->numerify('(###) ###-####'),
        'contacted'             => $faker->randomDigit,
        'patient_id'            => $faker->randomDigit,
        'rx_metabolic_syndrome' => $faker->randomDigit,
        'rx_obesity'            => $faker->randomDigit,
        'rx_afib'               => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SleepStudy::class, function (\Faker\Generator $faker) {
    return [
        'testnumber'         => $faker->numerify('#########'),
        'docid'              => $faker->numerify('##'),
        'patientid'          => $faker->numerify('##'),
        'needed'             => $faker->randomElement(['Yes', 'No']),
        'scheddate'          => $faker->dateTime,
        'sleeplabwheresched' => $faker->numerify('##'),
        'completed'          => $faker->randomElement(['Yes', 'No']),
        'interpolation'      => $faker->randomElement(['Yes', 'No']),
        'labtype'            => $faker->randomElement(['PSG', 'HST']),
        'copyreqdate'        => $faker->dateTime,
        'sleeplab'           => $faker->numerify('##'),
        'scanext'            => $faker->randomElement(['jpg', 'docx', 'rtf', 'pdf']),
        'date'               => $faker->numerify('########'),
        'filename'           => $faker->regexify('[a-z0-9_]{15}'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SupportCategory::class, function (\Faker\Generator $faker) {
    return [
        'title'      => $faker->word,
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Form::class, function (\Faker\Generator $faker) {
    return [
        'docid'      => $faker->randomDigit,
        'patientid'  => $faker->randomDigit,
        'formtype'   => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TypeService::class, function (\Faker\Generator $faker) {
    return [
        'type_service' => $faker->numerify('##'),
        'description' => $faker->sentence($nbWords = 6),
        'sortby' => $faker->randomDigit,
        'status' => $faker->randomDigit,
        'adddate' => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SupportResponse::class, function (\Faker\Generator $faker) {
    return [
        'ticket_id'     => $faker->randomDigit,
        'responder_id'  => $faker->randomDigit,
        'body'          => $faker->sentence($nbWords = 5),
        'response_type' => $faker->randomDigit,
        'adddate'       => $faker->dateTime,
        'ip_address'    => $faker->ipv4,
        'viewed'        => $faker->boolean,
        'attachment'    => $faker->regexify('[a-z0-9_\-]{15}\.(jpg|jpeg|png|bmp|gif)'),
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Tongue::class, function (\Faker\Generator $faker) {
    return [
        'tongue'      => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 7),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Uvula::class, function (\Faker\Generator $faker) {
    return [
        'uvula'       => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TeethExam::class, function (\Faker\Generator $faker) {
    return [
        'exam_teeth'  => $faker->word,
        'description' => $faker->sentence($nbWords = 6),
        'sortby'      => $faker->randomDigit,
        'status'      => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\TransactionCode::class, function (\Faker\Generator $faker) {
    return [
        'transaction_code' => $faker->regexify('[A-Z][0-9]{4}'),
        'description'      => $faker->sentence($nbWords = 7),
        'type'             => $faker->numerify('#'),
        'sortby'           => $faker->randomDigit,
        'status'           => $faker->randomDigit,
        'adddate'          => $faker->dateTime,
        'ip_address'       => $faker->ipv4,
        'default_code'     => $faker->randomDigit,
        'docid'            => $faker->randomDigit,
        'amount'           => $faker->numerify('###.##'),
        'place'            => $faker->randomDigit,
        'modifier_code_1'  => $faker->word,
        'modifier_code_2'  => $faker->word,
        'days_units'       => $faker->numerify('#'),
        'amount_adjust'    => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\UserCompany::class, function (\Faker\Generator $faker) {
    return [
        'userid'     => $faker->randomDigit,
        'companyid'  => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetStep::class, function (\Faker\Generator $faker) {
    return [
        'name'       => $faker->word,
        'sort_by'    => $faker->randomDigit,
        'section'    => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\UserHstCompany::class, function (\Faker\Generator $faker) {
    return [
        'userid'     => $faker->randomDigit,
        'companyid'  => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PlanText::class, function (\Faker\Generator $faker) {
    return [
        'plan_text'  => $faker->sentence($nbWords = 4),
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\UserSignature::class, function (\Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'signature_json' => '{"lx":18,"ly":18,"mx":18,"my":17}',
        'adddate' => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\EpworthHomeSleepTest::class, function (\Faker\Generator $faker) {
    return [
        'hst_id'     => $faker->randomDigit,
        'epworth_id' => $faker->randomDigit,
        'response'   => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage::class, function (\Faker\Generator $faker) {
    return [
        'nasal_passages' => $faker->sentence($nbWords = 2),
        'description'    => $faker->sentence($nbWords = 6),
        'sortby'         => $faker->randomDigit,
        'status'         => $faker->randomDigit,
        'adddate'        => $faker->dateTime,
        'ip_address'     => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Flowsheet::class, function (\Faker\Generator $faker) {
    return [
        'formid'                => $faker->randomDigit,
        'patientid'             => $faker->randomDigit,
        'inquiry_call_apt'      => $faker->dateTime->format('m/d/Y'),
        'inquiry_call_comp'     => $faker->dateTime->format('m/d/Y'),
        'send_np'               => $faker->word,
        'send_np_comp'          => $faker->dateTime->format('m/d/Y'),
        'acquire_ss_apt'        => $faker->dateTime->format('m/d/Y'),
        'acquire_ss_comp'       => $faker->dateTime->format('m/d/Y'),
        'referral_dss_apt'      => $faker->dateTime->format('m/d/Y'),
        'referral_dss_comp'     => $faker->dateTime->format('m/d/Y'),
        'ss_requested_apt'      => $faker->word,
        'ss_requested_comp'     => $faker->word,
        'ss_received_apt'       => $faker->word,
        'ss_received_comp'      => $faker->word,
        'consultation_apt'      => $faker->dateTime->format('m/d/Y'),
        'consultation_comp'     => $faker->word,
        'm_insurance_apt'       => $faker->dateTime->format('m/d/Y'),
        'm_insurance_comp'      => $faker->dateTime->format('m/d/Y'),
        'select_type'           => $faker->sentence($nbWords = 3),
        'exam_impressions_apt'  => $faker->dateTime->format('m/d/Y'),
        'exam_impressions_comp' => $faker->word,
        'ltr_physicians_apt'    => $faker->word,
        'ltr_physicians_comp'   => $faker->word,
        'ltr_marketing_apt'     => $faker->word,
        'ltr_marketing_comp'    => $faker->word,
        'delivery_device_apt'   => $faker->word,
        'delivery_device_comp'  => $faker->word,
        'ltr_marketing_pt_apt'  => $faker->word,
        'ltr_marketing_pt_comp' => $faker->word,
        'ltr_corr_phy_apt'      => $faker->word,
        'ltr_corr_phy_comp'     => $faker->word,
        'first_check_apt'       => $faker->word,
        'first_check_comp'      => $faker->word,
        'add_check_apt'         => $faker->word,
        'add_check_comp'        => $faker->word,
        'home_sleep_apt'        => $faker->word,
        'home_sleep_comp'       => $faker->word,
        'further_checks_apt'    => $faker->word,
        'further_checks_comp'   => $faker->word,
        'comp_treatment_apt'    => $faker->word,
        'comp_treatment_comp'   => $faker->word,
        'ltr_copy_ss_apt'       => $faker->word,
        'ltr_copy_ss_comp'      => $faker->word,
        'annual_exam_apt'       => $faker->word,
        'annual_exam_comp'      => $faker->word,
        'pos_home_sleep_apt'    => $faker->word,
        'pos_home_sleep_comp'   => $faker->word,
        'ltr_corr_phy1_apt'     => $faker->word,
        'ltr_corr_phy1_comp'    => $faker->word,
        'ambulatory_ss_apt'     => $faker->dateTime->format('m/d/Y'),
        'ambulatory_ss_comp'    => $faker->dateTime->format('m/d/Y'),
        'diag_s_md_apt'         => $faker->word,
        'diag_s_md_comp'        => $faker->word,
        'psg_apt'               => $faker->word,
        'psg_comp'              => $faker->word,
        'pt_not_ds_apt'         => $faker->word,
        'pt_not_ds_comp'        => $faker->word,
        'not_candidate_apt'     => $faker->word,
        'not_candidate_comp'    => $faker->word,
        'fin_restraints_apt'    => $faker->word,
        'fin_restraints_comp'   => $faker->word,
        'pt_needing_apt'        => $faker->word,
        'pt_needing_comp'       => $faker->word,
        'inadequate_apt'        => $faker->word,
        'inadequate_comp'       => $faker->word,
        'userid'                => $faker->randomDigit,
        'docid'                 => $faker->randomDigit,
        'status'                => $faker->randomDigit,
        'step'                  => $faker->randomDigit,
        'adddate'               => $faker->dateTime,
        'ip_address'            => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ModifierCode::class, function (\Faker\Generator $faker) {
    return [
        'modifier_code' => $faker->numerify('##'),
        'description'   => $faker->sentence($nbWords = 6),
        'sortby'        => $faker->randomDigit,
        'status'        => $faker->randomDigit,
        'adddate'       => $faker->dateTime,
        'ip_address'    => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\MissingTooth::class, function (\Faker\Generator $faker) {
    return [
        'formid'     => $faker->randomDigit,
        'patientid'  => $faker->randomDigit,
        'pck'        => $faker->regexify('(~[0-9]*)+'),
        'rec'        => $faker->regexify('(~[0-9]*)+'),
        'mob'        => $faker->regexify('(~[0-9]*)+'),
        'rec1'       => $faker->regexify('(~[0-9]*)+'),
        'pck1'       => $faker->regexify('(~[0-9]*)+'),
        's1'         => $faker->numerify('#'),
        's2'         => $faker->numerify('#'),
        's3'         => $faker->numerify('#'),
        's4'         => $faker->numerify('#'),
        's5'         => $faker->numerify('#'),
        's6'         => $faker->numerify('#'),
        'userid'     => $faker->randomDigit,
        'docid'      => $faker->randomDigit,
        'status'     => $faker->randomDigit,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\PercaseInvoice::class, function (\Faker\Generator $faker) {
    return [
        'adminid'             => $faker->randomDigit,
        'docid'               => $faker->randomDigit,
        'adddate'             => $faker->dateTime,
        'ip_address'          => $faker->ipv4,
        'monthly_fee_date'    => $faker->dateTime,
        'monthly_fee_amount'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'status'              => $faker->randomDigit,
        'due_date'            => $faker->dateTime,
        'companyid'           => $faker->randomDigit,
        'user_fee_date'       => $faker->dateTime,
        'user_fee_amount'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'producer_fee_date'   => $faker->dateTime,
        'producer_fee_amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'user_fee_desc'       => $faker->word,
        'producer_fee_desc'   => $faker->word,
        'invoice_type'        => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\ExtraPercaseInvoice::class, function (\Faker\Generator $faker) {
    return [
        'percase_date'    => $faker->dateTime,
        'percase_name'    => $faker->name,
        'percase_amount'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'percase_status'  => $faker->randomDigit,
        'percase_invoice' => $faker->randomDigit,
        'adddate'         => $faker->dateTime,
        'ip_address'      => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\QPage2Surgery::class, function (\Faker\Generator $faker) {
    return [
        'patientid'    => $faker->randomDigit,
        'surgery_date' => $faker->dateTime,
        'surgery'      => $faker->sentence($nbWords = 6),
        'surgeon'      => $faker->name,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Thorton::class, function (\Faker\Generator $faker) {
    return [
        'formid'     => $faker->randomDigit,
        'patientid'  => $faker->randomDigit,
        'snore_1'    => $faker->randomDigit,
        'snore_2'    => $faker->randomDigit,
        'snore_3'    => $faker->randomDigit,
        'snore_4'    => $faker->randomDigit,
        'snore_5'    => $faker->randomDigit,
        'tot_score'  => $faker->randomDigit,
        'userid'     => $faker->randomDigit,
        'docid'      => $faker->randomDigit,
        'status'     => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetNextStep::class, function (\Faker\Generator $faker) {
    return [
        'parent_id'  => $faker->randomDigit,
        'child_id'   => $faker->randomDigit,
        'sort_by'    => $faker->randomDigit,
        'adddate'    => $faker->dateTime,
        'ip_address' => $faker->ipv4,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\NewFlowsheet::class, function (\Faker\Generator $faker) {
    return [
        'formid'                   => $faker->randomDigit,
        'patientid'                => $faker->randomDigit,
        'inquiry_call_comp'        => $faker->dateTime->format('m/d/Y'),
        'send_np'                  => $faker->word,
        'send_np_comp'             => $faker->word,
        'acquire_ss_apt'           => $faker->word,
        'acquire_ss_comp'          => $faker->dateTime->format('m/d/Y'),
        'pt_not_ss'                => $faker->word,
        'ss_date_requested'        => $faker->word,
        'ss_date_received'         => $faker->word,
        'date_referred'            => $faker->dateTime->format('m/d/Y'),
        'dss_dentists'             => $faker->word,
        'ss_requested_apt'         => $faker->dateTime->format('m/d/Y'),
        'ss_requested_comp'        => $faker->dateTime->format('m/d/Y'),
        'ss_received_apt'          => $faker->dateTime->format('m/d/Y'),
        'ss_received_comp'         => $faker->dateTime->format('m/d/Y'),
        'consultation_apt'         => $faker->dateTime->format('m/d/Y'),
        'consultation_comp'        => $faker->word,
        'm_insurance_date'         => $faker->dateTime->format('m/d/Y'),
        'select_type'              => $faker->word,
        'exam_impressions_apt'     => $faker->word,
        'exam_impressions_comp'    => $faker->word,
        'dsr_prepared'             => $faker->word,
        'dsr_sent'                 => $faker->word,
        'delivery_device_apt'      => $faker->word,
        'delivery_device_comp'     => $faker->word,
        'dsr_date_delivered'       => $faker->word,
        'ltr_phy_prepared'         => $faker->word,
        'ltr_phy_sent'             => $faker->word,
        'first_check_apt'          => $faker->word,
        'first_check_comp'         => $faker->word,
        'add_check_apt'            => $faker->word,
        'add_check_comp'           => $faker->word,
        'home_sleep_apt'           => $faker->word,
        'home_sleep_comp'          => $faker->word,
        'further_checks_apt'       => $faker->word,
        'further_checks_comp'      => $faker->word,
        'comp_treatment_date'      => $faker->word,
        'portable_date_comp'       => $faker->word,
        'treatment_success'        => $faker->word,
        'ltr_doc_ss_date_prepared' => $faker->word,
        'ltr_doc_ss_date_sent'     => $faker->word,
        'annual_exam_apt'          => $faker->word,
        'annual_exam_comp'         => $faker->word,
        'ltr_doc_pt_date_prepared' => $faker->word,
        'ltr_doc_pt_date_sent'     => $faker->word,
        'ambulatory_ss_apt'        => $faker->dateTime->format('m/d/Y'),
        'ambulatory_ss_comp'       => $faker->dateTime->format('m/d/Y'),
        'diag_s_md_sent'           => $faker->dateTime->format('m/d/Y'),
        'diag_s_md_received'       => $faker->dateTime->format('m/d/Y'),
        'psg_apt'                  => $faker->dateTime->format('m/d/Y'),
        'psg_comp'                 => $faker->word,
        'sleep_lab'                => $faker->word,
        'lomn'                     => $faker->word,
        'rxfrommd'                 => $faker->word,
        'not_candidate'            => $faker->word,
        'financial_restraints'     => $faker->word,
        'pt_needing_dental_work'   => $faker->word,
        'inadequate_dentition'     => $faker->word,
        'pt_not_ds_other'          => $faker->word,
        'ltr_pp_date_prepared'     => $faker->dateTime->format('m/d/Y'),
        'ltr_pp_date_sent'         => $faker->word,
        'userid'                   => $faker->randomDigit,
        'docid'                    => $faker->randomDigit,
        'status'                   => $faker->randomDigit,
        'adddate'                  => $faker->dateTime,
        'ip_address'               => $faker->ipv4,
        'step'                     => $faker->randomDigit,
        'sstep'                    => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Task::class, function (\Faker\Generator $faker) {
    return [
        'task'           => $faker->sentence($nbWords = 5),
        'description'    => $faker->sentence($nbWords = 5),
        'userid'         => $faker->randomDigit,
        'responsibleid'  => $faker->randomDigit,
        'status'         => $faker->randomDigit,
        'due_date'       => $faker->dateTime,
        'recurring'      => $faker->randomDigit,
        'recurring_unit' => $faker->randomDigit,
        'adddate'        => $faker->dateTime,
        'ip_address'     => $faker->ipv4,
        'patientid'      => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest::class, function (\Faker\Generator $faker) {
    return [
        'doc_id'               => $faker->randomDigit,
        'user_id'              => $faker->randomDigit,
        'company_id'           => $faker->randomDigit,
        'patient_id'           => $faker->randomDigit,
        'screener_id'          => $faker->randomDigit,
        'ins_co_id'            => $faker->randomDigit,
        'ins_phone'            => $faker->numerify('##########'),
        'patient_ins_group_id' => $faker->numerify('##'),
        'patient_ins_id'       => $faker->numerify('##'),
        'patient_firstname'    => $faker->firstNameMale,
        'patient_lastname'     => $faker->lastName,
        'patient_add1'         => $faker->address,
        'patient_add2'         => $faker->address,
        'patient_city'         => $faker->city,
        'patient_state'        => $faker->stateAbbr,
        'patient_zip'          => $faker->numerify('#####'),
        'patient_dob'          => $faker->date,
        'patient_cell_phone'   => $faker->numerify('##########'),
        'patient_home_phone'   => $faker->numerify('##########'),
        'patient_email'        => $faker->email,
        'diagnosis_id'         => $faker->randomDigit,
        'hst_type'             => $faker->randomDigit,
        'provider_firstname'   => $faker->firstNameMale,
        'provider_lastname'    => $faker->lastName,
        'provider_phone'       => $faker->numerify('##########'),
        'provider_address'     => $faker->address,
        'provider_city'        => $faker->city,
        'provider_state'       => $faker->stateAbbr,
        'provider_zip'         => $faker->numerify('#####'),
        'provider_signature'   => $faker->word,
        'provider_date'        => $faker->date,
        'snore_1'              => $faker->randomDigit,
        'snore_2'              => $faker->randomDigit,
        'snore_3'              => $faker->randomDigit,
        'snore_4'              => $faker->randomDigit,
        'snore_5'              => $faker->randomDigit,
        'viewed'               => $faker->randomDigit,
        'status'               => $faker->randomDigit,
        'adddate'              => $faker->dateTime,
        'ip_address'           => $faker->ipv4,
        'office_notes'         => $faker->sentence($nbWords = 6),
        'sleep_study_id'       => $faker->randomDigit,
        'authorized_id'        => $faker->randomDigit,
        'authorizeddate'       => $faker->dateTime,
        'updatedate'           => $faker->dateTime,
        'rejected_reason'      => $faker->sentence($nbWords = 6),
        'rejecteddate'         => $faker->dateTime,
        'canceled_id'          => $faker->randomDigit,
        'canceled_date'        => $faker->dateTime,
        'hst_nights'           => $faker->randomDigit,
        'hst_positions'        => $faker->sentence($nbWords = 2)
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SupportTicket::class, function (\Faker\Generator $faker) {
    return [
        'title'       => $faker->sentence($nbWords = 6),
        'userid'      => $faker->randomDigit,
        'docid'       => $faker->randomDigit,
        'body'        => $faker->sentence($nbWords = 5),
        'category_id' => $faker->randomDigit,
        'adddate'     => $faker->dateTime,
        'status'      => $faker->randomDigit,
        'ip_address'  => $faker->ipv4,
        'attachment'  => $faker->regexify('[a-z0-9_-]{15,20}\.(jpg|jpeg|png|gif|bmp)'),
        'viewed'      => $faker->boolean,
        'creator_id'  => $faker->randomDigit,
        'create_type' => $faker->randomDigit,
        'company_id'  => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Notification::class, function (\Faker\Generator $faker) {
    return [
        'notification'      => $faker->sentence($nbWords = 4),
        'notification_type' => $faker->word,
        'status'            => $faker->randomDigit,
        'notification_date' => $faker->dateTime,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\Summary::class, function (\Faker\Generator $faker) {
    return [
        'formid'                           => $faker->randomDigit,
        'patient_name'                     => $faker->name,
        'patient_dob'                      => $faker->dateTime->format('m/d/Y'),
        'docpcp'                           => $faker->numerify('##'),
        'docsmd'                           => $faker->numerify('##'),
        'docomd1'                          => $faker->numerify('##'),
        'docomd2'                          => $faker->numerify('##'),
        'docdds'                           => $faker->word,
        'osite'                            => $faker->word,
        'referral_source'                  => $faker->word,
        'reason_seeking_tx'                => $faker->word,
        'symptoms_osa'                     => $faker->word,
        'bed_time_partner'                 => $faker->word,
        'snoring'                          => $faker->word,
        'apnea'                            => $faker->word,
        'history_surgery'                  => $faker->word,
        'tried_cpap'                       => $faker->word,
        'cpap_totalnights'                 => $faker->randomDigit,
        'fna'                              => $faker->word,
        'cpap_date'                        => $faker->word,
        'problem_cpap'                     => $faker->word,
        'wearing_cpap'                     => $faker->word,
        'max_translation_from'             => $faker->word,
        'max_translation_to'               => $faker->word,
        'max_translation_equal'            => $faker->word,
        'initial_device_titration_1'       => $faker->randomElement(['-', '+']) . $faker->numerify('##'),
        'initial_device_titration_equal_h' => $faker->randomElement(['-', '+']) . $faker->numerify('##'),
        'initial_device_titration_equal_v' => $faker->randomElement(['-', '+']) . $faker->numerify('##'),
        'optimum_echovision_ver'           => $faker->randomElement(['-', '+']) . $faker->numerify('##'),
        'optimum_echovision_hor'           => $faker->randomElement(['-', '+']) . $faker->numerify('##'),
        'type_device'                      => $faker->word,
        'personal'                         => $faker->word,
        'lab_name'                         => $faker->word,
        'sti_test_1'                       => $faker->word,
        'sti_test_2'                       => $faker->word,
        'sti_test_3'                       => $faker->word,
        'sti_test_4'                       => $faker->word,
        'sti_date_1'                       => $faker->dateTime->format('Y-m-d'),
        'sti_date_2'                       => $faker->dateTime->format('Y-m-d'),
        'sti_date_3'                       => $faker->dateTime->format('Y-m-d'),
        'sti_date_4'                       => $faker->dateTime->format('Y-m-d'),
        'sti_ahi_1'                        => $faker->word,
        'sti_ahi_2'                        => $faker->word,
        'sti_ahi_3'                        => $faker->word,
        'sti_ahi_4'                        => $faker->word,
        'sti_rdi_1'                        => $faker->word,
        'sti_rdi_2'                        => $faker->word,
        'sti_rdi_3'                        => $faker->word,
        'sti_rdi_4'                        => $faker->word,
        'sti_supine_ahi_1'                 => $faker->word,
        'sti_supine_ahi_2'                 => $faker->word,
        'sti_supine_ahi_3'                 => $faker->word,
        'sti_supine_ahi_4'                 => $faker->word,
        'sti_supine_rdi_1'                 => $faker->word,
        'sti_supine_rdi_2'                 => $faker->word,
        'sti_supine_rdi_3'                 => $faker->word,
        'sti_supine_rdi_4'                 => $faker->word,
        'sti_lsat_1'                       => $faker->word,
        'sti_lsat_2'                       => $faker->word,
        'sti_lsat_3'                       => $faker->word,
        'sti_lsat_4'                       => $faker->word,
        'sti_titration_1'                  => $faker->word,
        'sti_titration_2'                  => $faker->word,
        'sti_titration_3'                  => $faker->word,
        'sti_titration_4'                  => $faker->word,
        'sti_cpap_p_1'                     => $faker->word,
        'sti_cpap_p_2'                     => $faker->word,
        'sti_cpap_p_3'                     => $faker->word,
        'sti_cpap_p_4'                     => $faker->word,
        'sti_apnea_1'                      => $faker->word,
        'sti_apnea_2'                      => $faker->word,
        'sti_apnea_3'                      => $faker->word,
        'sti_apnea_4'                      => $faker->word,
        'ep_date_1'                        => $faker->dateTime->format('Y-m-d'),
        'ep_date_2'                        => $faker->dateTime->format('Y-m-d'),
        'ep_date_3'                        => $faker->dateTime->format('Y-m-d'),
        'ep_date_4'                        => $faker->dateTime->format('Y-m-d'),
        'ep_date_5'                        => $faker->dateTime->format('Y-m-d'),
        'dset1'                            => $faker->word,
        'dset2'                            => $faker->word,
        'dset3'                            => $faker->word,
        'dset4'                            => $faker->word,
        'dset5'                            => $faker->word,
        'ep_e_1'                           => $faker->word,
        'ep_e_2'                           => $faker->word,
        'ep_e_3'                           => $faker->word,
        'ep_e_4'                           => $faker->word,
        'ep_e_5'                           => $faker->word,
        'ep_s_1'                           => $faker->word,
        'ep_s_2'                           => $faker->word,
        'ep_s_3'                           => $faker->word,
        'ep_s_4'                           => $faker->word,
        'ep_s_5'                           => $faker->word,
        'ep_w_1'                           => $faker->word,
        'ep_w_2'                           => $faker->word,
        'ep_w_3'                           => $faker->word,
        'ep_w_4'                           => $faker->word,
        'ep_w_5'                           => $faker->word,
        'ep_a_1'                           => $faker->word,
        'ep_a_2'                           => $faker->word,
        'ep_a_3'                           => $faker->word,
        'ep_a_4'                           => $faker->word,
        'ep_a_5'                           => $faker->word,
        'ep_el_1'                          => $faker->word,
        'ep_el_2'                          => $faker->word,
        'ep_el_3'                          => $faker->word,
        'ep_el_4'                          => $faker->word,
        'ep_el_5'                          => $faker->word,
        'ep_h_1'                           => $faker->word,
        'ep_h_2'                           => $faker->word,
        'ep_h_3'                           => $faker->word,
        'ep_h_4'                           => $faker->word,
        'ep_h_5'                           => $faker->word,
        'ep_r_1'                           => $faker->word,
        'ep_r_2'                           => $faker->word,
        'ep_r_3'                           => $faker->word,
        'ep_r_4'                           => $faker->word,
        'ep_r_5'                           => $faker->word,
        'mini_consult'                     => $faker->word,
        'exam_impressions'                 => $faker->word,
        'oa_soap'                          => $faker->word,
        'fm_blue'                          => $faker->word,
        'oa_check_1'                       => $faker->word,
        'oa_check_2'                       => $faker->word,
        'oa_check_3'                       => $faker->word,
        'oa_check_4'                       => $faker->word,
        'oa_check_5'                       => $faker->word,
        'oa_check_6'                       => $faker->word,
        'month_check_1'                    => $faker->word,
        'month_check_2'                    => $faker->word,
        'month_check_3'                    => $faker->word,
        'month_check_4'                    => $faker->word,
        'oa_psg'                           => $faker->word,
        'year_check_1'                     => $faker->word,
        'year_check_2'                     => $faker->word,
        'year_check_3'                     => $faker->word,
        'year_check_4'                     => $faker->word,
        'additional_notes'                 => $faker->sentence($nbWords = 5),
        'status'                           => $faker->randomDigit,
        'adddate'                          => $faker->dateTime,
        'ip_address'                       => $faker->ipv4,
        'office'                           => $faker->word,
        'sleep_same_room'                  => $faker->word,
        'currently_wearing'                => $faker->word,
        'what_percentage'                  => $faker->word,
        'how_long'                         => $faker->word,
        'sleep_md'                         => $faker->word,
        'test_type_name'                   => $faker->word,
        'sti_sleep_efficiency_1'           => $faker->word,
        'sti_sleep_efficiency_2'           => $faker->word,
        'sti_sleep_efficiency_3'           => $faker->word,
        'sti_sleep_efficiency_4'           => $faker->word,
        'sti_rem_ahi_1'                    => $faker->word,
        'sti_rem_ahi_2'                    => $faker->word,
        'sti_rem_ahi_3'                    => $faker->word,
        'sti_rem_ahi_4'                    => $faker->word,
        'sti_o2_1'                         => $faker->word,
        'sti_o2_2'                         => $faker->word,
        'sti_o2_3'                         => $faker->word,
        'sti_o2_4'                         => $faker->word,
        'sti_other_1'                      => $faker->word,
        'sti_other_2'                      => $faker->word,
        'sti_other_3'                      => $faker->word,
        'sti_other_4'                      => $faker->word,
        'ep_ts_1'                          => $faker->word,
        'ep_ts_2'                          => $faker->word,
        'ep_ts_3'                          => $faker->word,
        'ep_ts_4'                          => $faker->word,
        'ep_ts_5'                          => $faker->word,
        'ep_tr_1'                          => $faker->word,
        'ep_tr_2'                          => $faker->word,
        'ep_tr_3'                          => $faker->word,
        'ep_tr_4'                          => $faker->word,
        'ep_tr_5'                          => $faker->word,
        'appt_notes_1'                     => $faker->word,
        'appt_notes_2'                     => $faker->word,
        'appt_notes_3'                     => $faker->word,
        'appt_notes_4'                     => $faker->word,
        'appt_notes_1p3'                   => $faker->word,
        'appt_notes_2p3'                   => $faker->word,
        'appt_notes_3p3'                   => $faker->word,
        'appt_notes_4p3'                   => $faker->word,
        'appt_notes_5p3'                   => $faker->word,
        'wapn1'                            => $faker->word,
        'wapn2'                            => $faker->word,
        'wapn3'                            => $faker->word,
        'wapn4'                            => $faker->word,
        'wapn5'                            => $faker->word,
        'patientphoto'                     => $faker->regexify('[a-z0-9_\-]+\.(jpg|gif|bmp|png)'),
        'sleep_qual1'                      => $faker->word,
        'sleep_qual2'                      => $faker->word,
        'sleep_qual3'                      => $faker->word,
        'sleep_qual4'                      => $faker->word,
        'sleep_qual5'                      => $faker->word,
        'location'                         => $faker->randomDigit,
    ];
});

$factory->define(DentalSleepSolutions\Eloquent\Models\Dental\SupportAttachment::class, function (\Faker\Generator $faker) {
    return [
        'ticket_id'   => $faker->randomDigit,
        'response_id' => $faker->randomDigit,
        'filename'    => $faker->regexify('support_attachment_[0-9]{1,2}_[0-9]_[0-9]{4}\.(gif|jpeg|png|bmp|jpg)'),
        'adddate'     => $faker->dateTime,
        'ip_address'  => $faker->ipv4,
    ];
});
