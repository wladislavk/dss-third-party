<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../../reg/twilio/twilio.config.php';
require_once __DIR__ . '/../../admin/includes/main_include.php';

$userId = intval($_REQUEST['id']);
$hash = $_REQUEST['hash'];

linkRequestData('dental_users', $userId);

$r = $db->getRow("SELECT *
    FROM dental_users
    WHERE userid = '$userId'
        AND recover_hash = '" . $db->escape($hash) . "'");

if ($r['text_num'] >= 5 && strtotime($r['text_date']) > (time()-3600)) {
    echo '{"error":"limit"}';
    trigger_error("Die called", E_USER_ERROR);
}

if ($r['access_code'] == '' || strtotime($r['access_code_date']) < time()-86400){
    $recover_hash = rand(100000, 999999);
    $db->query("UPDATE dental_users
        SET access_code = '$recover_hash', access_code_date = NOW()
        WHERE userid = '$userId'");
} else {
    $recover_hash = $r['access_code'];
}

$isCellError = true;

if ($r['phone'] != '') {
    // instantiate a new Twilio Rest Client
    $client = new \Services_Twilio($AccountSid, $AuthToken);
    // Send a new outgoing SMS
    if ($send_texts) {
        try {
            $sms = $client->account->sms_messages->create(
                $twilio_number,
                $r['phone'],
                "Your Dental Sleep Solutions access code is $recover_hash"
            );

            if (strtotime($r['text_date']) < (time() - 3600) || $r['text_num'] == 0) {
                $db->query("UPDATE dental_users
                    SET text_num = 1, text_date = NOW()
                    WHERE userid = '$userId'");
            } else {
                $db->query("UPDATE dental_users
                    SET text_num = text_num + 1
                    WHERE userid = '$userId'");
            }

            echo '{"success":true}';
        } catch (\Services_Twilio_RestException $e) {
            $isCellError = true;
        }
    } else {
        echo '{"error":"inactive"}';
    }
} else {
    $isCellError = true;
}

if ($isCellError) {
    echo '{"error":"cell"}';
}

