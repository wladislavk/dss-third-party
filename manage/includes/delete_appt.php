<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/../admin/includes/main_include.php';

$id = $db->escape($_REQUEST['id']);
$pid = $db->escape($_REQUEST['pid']);

$response = ['error' => true];

if (empty($_SESSION['userid'])) {
    throw new \RuntimeException('Unregistered users cannot delete appt.');
}

/**
 * This section was deleting dental_letters rows by mistake. We now NEVER delete them, we just deactivate them.
 *
 * @see DSS-196
 * @see DSS-198
 */
if ($id && $pid) {
    $infoData = $db->query("SELECT id from dental_flow_pg2_info WHERE id = '$id' AND patientid = '$pid'");

    if ($infoData) {
        $userId = $db->escape($_SESSION['userid']);

        $db->query("DELETE from dental_flow_pg2_info WHERE id = '$id' AND patientid = '$pid'");
        $db->query("UPDATE dental_letters SET deleted = 1, deleted_by = '$userId', deleted_on = NOW()
            WHERE info_id != '' AND info_id = '$id'");

        $response = ['success' => true];
    }
}

echo json_encode($response);
