<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/main_include.php';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/../admin/includes/invoice_functions.php';

$patientId = intval($_POST['pid']);
$response = $_POST['response'];
$jsonResponse = @json_decode($response, true);
$type = isset($jsonResponse['type']) ? $jsonResponse['type'] : '1';

$insertData = $db->escapeAssignmentList([
    'patientid' => $patientId,
    'userid' => $_SESSION['userid'],
    'eligible_id' => $jsonResponse['eligible_id'],
    'ip_address' => $_SERVER['REMOTE_ADDR'],
    'response' => $response
]);

$eligibleId = $db->getInsertId("INSERT INTO dental_eligibility SET $insertData, adddate = NOW()");
invoice_add_eligibility($type, $_SESSION['admincompanyid'], $eligibleId);

$response = [
    ($eligibleId ? 'success' : 'error') => true,
    'id' => $eligibleId
];

echo json_encode($response);
