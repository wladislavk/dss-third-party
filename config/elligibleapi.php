<?php

return [
    'test' => true,
    'default_api_key' => '33b2e3a5-8642-1285-d573-07a22f8a15b4',
    'base_uri'  => 'https://gds.eligibleapi.com/v1.5/',
    'request_uri' =>
    [
        'enrollment_payers_list' => 'payers.json?endpoint=coverage&enrollment_required=true&api_key=',
        'enrollments' => 'enrollment_npis',
    ],
    'enrollment_statuses' => [
        'DSS_ENROLLMENT_SUBMITTED'      => 0,
        'DSS_ENROLLMENT_ACCEPTED'       => 1,
        'DSS_ENROLLMENT_REJECTED'       => 2,
        'DSS_ENROLLMENT_PDF_RECEIVED'   => 3,
        'DSS_ENROLLMENT_PDF_SENT'       => 4,
    ],
    'transaction_types' => [
        'DSS_TRXN_TYPE_MED'     => 1,
        'DSS_TRXN_TYPE_PATIENT' => 2,
        'DSS_TRXN_TYPE_INS'     => 3,
        'DSS_TRXN_TYPE_DIAG'    => 4,
        'DSS_TRXN_TYPE_ADJ'     => 6,
    ]
];