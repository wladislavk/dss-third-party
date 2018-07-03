<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../manage/admin/includes/main_include.php';
require_once __DIR__ . '/../../manage/includes/constants.inc';

$action = $_POST['type'];

$db = new Db();

$patientId = $db->getColumn("SELECT patientid
    FROM dental_patients
    WHERE email = '" . $db->escape($_POST['email']) . "'
    LIMIT 1", 'patientid', 0);

$mailerData = retrieveMailerData($patientId);
$patientData = $mailerData['patientData'];

$response = ['error' => 'email'];

if ($patientData) {
    if ($patientData['registration_status'] == 1 && $patientData['password'] == '') {
        $action = 'activate';
    }
    
    if ($patientData['password'] != '' && $action == 'activate') {
        $response = ['error' => 'existing'];
    } elseif ($patientData['password'] == '' && $action == 'reset') {
        $response = ['error' => 'activate'];
    } elseif ($action == 'activate' && $patientData['registration_status'] == 0) {
        $response = ['error' => 'restricted'];
    } else {
        if ($patientData['recover_hash'] == '') {
            $patientData['recover_hash'] = hash('sha256', $patientData['patientid'] . $patientData['email'] . rand());
            $mailerData['patientData']['recover_hash'] = $patientData['recover_hash'];

            $db->query("UPDATE dental_patients
                SET recover_hash = '{$patientData['recover_hash']}', recover_time = NOW()
                WHERE patientid = '$patientId'");
        }
        
        if ($action == 'activate') {
            $subject = 'Dental Sleep Solutions Account Activation';
            $template = getTemplate('patient/activate-account');
        } else {
            $subject = 'Dental Sleep Solutions Password Reset';
            $template = getTemplate('patient/reset-password');
        }
        
        $from = 'Dental Sleep Solutions <support@dentalsleepsolutions.com>';
        $to = "{$patientData['firstname']} {$patientData['lastname']} <{$patientData['email']}>";
        $emailData = $mailerData['patientData'] + $mailerData['mailingData'];
        
        sendEmail($from, $to, $subject, $template, $emailData);
        $response = ['success' => true];
    }
}

echo json_encode($response);
