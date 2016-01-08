<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/access.php';

$errorMessage = switchBackOfficeClaimMarker(\Request::input('claim_id'), \Request::input('filed_by_back_office'));

$response = [
    'success' => !$errorMessage,
    'message' => $errorMessage
];

header('Content-Type: text/json');
echo json_encode($response);

function switchBackOfficeClaimMarker ($claimId, $markAsFiledByBackOffice) {
    $db = new Db();

    $claimId = intval($claimId);
    $markAsFiledByBackOffice = !!$markAsFiledByBackOffice;

    if (!is_super($_SESSION['admin_access'])) {
        return 'This action requires admin access';
    }

    $claimData = $db->getRow("SELECT primary_claim_id, p_m_dss_file, s_m_dss_file
        FROM dental_insurance
        WHERE insuranceid = '$claimId'");

    if (!$claimData) {
        return 'The given claim id is not valid';
    }

    $filedByBackOffice = ($claimData['p_m_dss_file'] == 3) ||
        (!$claimData['primary_claim_id'] && ($claimData['p_m_dss_file'] == 1)) ||
        ($claimData['primary_claim_id'] && ($claimData['s_m_dss_file'] == 1));

    if ($filedByBackOffice != $markAsFiledByBackOffice) {
        $markerValue = $markAsFiledByBackOffice ? 3 : 0;

        $db->query("UPDATE dental_insurance SET
          p_m_dss_file = '$markerValue', s_m_dss_file = 0
          WHERE insuranceid = '$claimId'");

        $insertData = [
            $claimId,
            $markerValue,
            $_SESSION['adminuserid'],
            $_SERVER['REMOTE_ADDR']
        ];

        $insertData = $db->escapeList($insertData);

        $db->query("INSERT INTO dental_insurance_bo_status (
                insuranceid,
                p_m_dss_file,
                adminid,
                ip_address,
                adddate
            ) VALUES ($insertData, NOW())");
    }

    return '';
}
