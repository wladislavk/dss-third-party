<?php namespace Ds3\Libraries\Legacy; ?><?php

require(dirname(__FILE__).'/class.fax.php');
require(dirname(__FILE__).'/config.php');

set_time_limit(5*60); // 5 minutes

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
$limit = $limit < 1 ? 50 : $limit;

$sql = "SELECT f.*, c.companyid
    FROM dental_faxes f
        JOIN dental_user_company c ON c.userid = f.docid
    WHERE sfax_completed=0
    AND sfax_transmission_id IS NOT NULL
    ORDER BY f.id ASC
    LIMIT 0, $limit";
$q = mysqli_query($con, $sql);

if ($q) {
    error_log('Update Fax Status: pending faxes - ' . mysqli_num_rows($q));
    $apiCalls = 0;

    $successFaxes = array();
    $pendingFaxes = array();
    $updatedFaxes = array();
    $updatedLetters = array();

    while ($r = mysqli_fetch_assoc($q)) {
        $faxId = intval($r['id']);
        $letterId = intval($r['letterid']);
        $companyId = intval($r['companyid']);
        $transmissionId = $r['sfax_transmission_id'];

        $apiResponse = '';
        $faxStatus = array();

        $_SESSION['companyid'] = $companyId;
        $fts = new \FTSSamples();

        // Try/catch block for API calls
        try {
            $apiResponse = $fts->OutboundFaxStatus($transmissionId);
            $apiCalls++;

            $faxStatus = json_decode($apiResponse, true);
        } catch (\Exception $e) {
            error_log("Update Fax Status: exception for fax id [$faxId]" . $e->getMessage());
            continue;
        }

        // If the API does NOT return fax status, it is still in process/pending
        // NOTE: this key starts with LOWERCASE, but the ITEM starts with UPPERCASE
        if (empty($faxStatus['isSuccess']) || !isset($faxStatus['RecipientFaxStatusItems'][0])) {
            $pendingFaxes []= $faxId;
            continue;
        }

        $item = $faxStatus['RecipientFaxStatusItems'][0];
        $errorCode = isset($item['ErrorCode']) ? $item['ErrorCode'] :
            (isset($faxStatus['ErrorCode']) ? $faxStatus['ErrorCode'] : -1);
        $success = isset($item['IsSuccess']) && $item['IsSuccess'] ? '1' : '2';

        $apiResponse = mysqli_real_escape_string($con, $apiResponse);
        $errorCode = mysqli_real_escape_string($con, $errorCode);

        $up_sql = "UPDATE dental_faxes SET
                sfax_completed = '1',
                sfax_response = '$apiResponse',
                sfax_status = '$success',
                sfax_error_code = '$errorCode'
            WHERE id = '$faxId'";
        mysqli_query($con, $up_sql);

        $updatedFaxes []= $faxId;

        if ($success == '2') {
            $let_sql = "UPDATE dental_letters SET status='0' WHERE letterid='$letterId'";
            mysqli_query($con, $let_sql);

            $updatedLetters []= $letterId;
        } else {
            $successFaxes []= $faxId;
        }
    }

    error_log("Update Fax Status: $apiCalls API calls, " . count($successFaxes) . " faxes marked as successful");
    error_log("Update Fax Status: pending fax ids - " . join(', ', $pendingFaxes));
    error_log("Update Fax Status: updated fax ids - " . join(', ', $updatedFaxes));
    error_log("Update Fax Status: success fax ids - " . join(', ', $successFaxes));
    error_log("Update Fax Status: updated letter ids - " . join(', ', $updatedLetters));
} else {
    error_log('Update Fax Status: no pending faxes');
}
