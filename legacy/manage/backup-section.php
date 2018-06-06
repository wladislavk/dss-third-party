<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';

set_time_limit(0);
ignore_user_abort(true);

if (!function_exists('\array_get')) {
    /**
     * @param array      $source
     * @param string     $key
     * @param null|mixed $default
     * @return null|mixed
     */
    function array_get(array $source, $key, $default = null)
    {
        if (array_key_exists($key, $source)) {
            return $source[$key];
        }
        return $default;
    }
}

if (!function_exists('\config')) {
    /**
     * @param string     $option
     * @param null|mixed $default
     * @return null|mixed
     */
    function config($option, $default = null)
    {
        if (strlen($option)) {
            return $option;
        }
        return $default;
    }
}

/**
 * @param string $url
 * @param array  $postData
 * @param array  $headers
 * @return array
 */
function postData($url, array $postData, array $headers)
{
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 2,
        CURLOPT_POSTFIELDS => http_build_query($postData),
        CURLOPT_HTTPHEADER => $headers,
    ]);
    usleep(500);
    curl_exec($curl);
    $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $errorNumber = curl_errno($curl);
    $errorMessage = curl_error($curl);
    curl_close($curl);

    return [
        'url' => $url,
        'code' => $responseCode,
        'error' => $errorNumber,
        'message' => $errorMessage,
    ];
}

/**
 * @return array
 */
function buildHeaders()
{
    $cookieName = session_name();
    $cookieValue = session_id();
    $apiToken = apiToken();
    $headers = [
        "Cookie: $cookieName=$cookieValue",
        "Authorization: Bearer $apiToken",
    ];
    return $headers;
}

/**
 * @param string $section
 * @param int    $patientId
 * @return array
 */
function backupSection($section, $patientId)
{
    $legacySections = [
        'questionnaires' => [
            'q_page1',
            'q_page2',
            'q_page3',
            'q_page4',
        ],
        'exams' => [
            'ex_page1',
            'ex_page2',
            'ex_page3',
            'ex_page4',
            'ex_page5',
            'ex_page6',
            'ex_page7',
            'ex_page8',
        ],
    ];
    $apiSections = [
        'questionnaires' => [
            'pain-tmd-exams',
        ],
        'exams' => [
            'advanced-pain-tmd-exams',
            'assessment-plan-exams',
            'evaluation-management-exams',
        ],
    ];
    $postData = [
        'backup_table' => true,
        'kill_switch' => 'bulk-backup',
    ];

    if ($section === 'exam') {
        $section = 'exams';
    }

    if (!array_key_exists($section, $legacySections) || !array_key_exists($section, $apiSections)) {
        return [];
    }

    $patientId = (int)$patientId;
    $legacyHost = config('app.url');
    $apiHost = config('app.apiUrl');
    $headers = buildHeaders();
    $responses = [];

    foreach ($legacySections[$section] as $page) {
        $responses[] = postData("{$legacyHost}manage/{$page}.php?pid=$patientId", $postData, $headers);
    }

    foreach ($apiSections[$section] as $endpoint) {
        $responses[] = postData("{$apiHost}api/v1/{$endpoint}?patient_id=$patientId", [], $headers);
    }

    return $responses;
}

$section = array_get($_POST, 'section');
$patientId = array_get($_POST, 'pid');
$backupReport = backupSection($section, $patientId);

echo json_encode([
    'success' => sizeof($backupReport) > 0,
    'report' => $backupReport,
]);
