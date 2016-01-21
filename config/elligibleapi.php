<?php

return [
    'test' => env('TEST_ELIGIBLE', true),
    'default_api_key' => '33b2e3a5-8642-1285-d573-07a22f8a15b4',
    'base_uri' => 'https://gds.eligibleapi.com/v1.5/',
    'request_uri' => [
        'enrollment_payers_list' => 'payers.json?endpoint=coverage&enrollment_required=true&api_key=',
        'enrollments' => 'enrollment_npis',
    ],
];
