<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';

dd($_POST);

if (!empty($_POST['report'])) {
    $logData = $db->escapeAssignmentList([
        'userid' => intval($_SESSION['userid']),
        'adminid' => intval($_SESSION['adminid']),
        'report' => $_POST['report'],
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'referrer' => $_SERVER['HTTP_REFERER']
    ]);

    $db->query("INSERT INTO dental_js_error_log SET $logData, created_at = NOW()");
}
