<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/admin/includes/claim_functions.php'; // claim_status_history_update

// This php://input does not work when NOT bypassing Laravel
$requestBody = file_get_contents('php://input');
$jsonResponse = json_decode($requestBody);

/**
 * Ignore claim acknowledgements.
 * 
 * Claim acknowledgements:
 * 
 * - JSON->acknowledgements IS set
 * - JSON->details IS not set
 */
if (isset($jsonResponse->details) && !isset($jsonResponse->acknowledgements)) {
    $eventType = $jsonResponse->event;
    $referenceId = isset($jsonResponse->reference_id) ? $jsonResponse->reference_id : '';

    switch ($eventType) {
        case 'claim_rejected':
        case 'claim_denied':
        case 'claim_more_info_required':
            updateClaimStatusFromReferenceId($referenceId, 'rejected');
            break;
        case 'claim_paid':
            updateClaimStatusFromReferenceId($referenceId, 'paid-insurance');
            break;
        case 'claim_pended':
        case 'claim_created':
        case 'claim_received':
            updateClaimStatusFromReferenceId($referenceId, 'sent');
            break;
        case 'claim_accepted':
            updateClaimStatusFromReferenceId($referenceId, 'efile-accepted');
            break;
        case 'enrollment_status':
            $referenceId = $jsonResponse->details->id;
            $status = $jsonResponse->details->status;

            if ($status == 'accepted') {
                $db->query("UPDATE dental_eligible_enrollment SET
                    status = '1'
                    WHERE reference_id = '".$db->escape($referenceId)."'");
            }

            break;
        case 'received_pdf':
            $referenceId = $jsonResponse->details->id;
            $downloadUrl = $jsonResponse->details->received_pdf->download_url;

            if ($downloadUrl) {
                $db->query("UPDATE dental_eligible_enrollment SET
                    status = '".DSS_ENROLLMENT_PDF_RECEIVED."',
                    download_url = '".$db->escape($downloadUrl)."'
                    WHERE reference_id = '".$db->escape($referenceId)."'");
            }

            break;
        case 'payment_report':
            $claimId = claimIdFromReferenceId($referenceId);

            $db->query("INSERT INTO dental_payment_reports SET
                claimid = '$claimId',
                reference_id = '".$db->escape($referenceId)."',
                response = '".$db->escape($requestBody)."',
                adddate = now(),
                ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");

            break;
    }
} else {
    $eventType = 'claim_acknowledgement';
    $referenceId = $jsonResponse->reference_id;
    echo "";
}

/**
 * Save webhook payload
 */
$db->query("INSERT INTO dental_eligible_response SET
    response = '".$db->escape($requestBody)."',
    reference_id = '".$db->escape($referenceId)."',
    event_type = '".$db->escape($eventType)."',
    adddate = now(),
    ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");

// Auxiliary functions to reduce verbosity of the code

/**
 * @param string $referenceId
 * @return int
 */
function claimIdFromReferenceId ($referenceId) {
    $db = new Db();
    $referenceId = $db->escape($referenceId);

    $eClaim = $db->getRow("SELECT claimid
        FROM dental_claim_electronic
        WHERE COALESCE(reference_id, '') != '' AND reference_id = '$referenceId'");

    return $eClaim ? intval($eClaim['claimid']) : 0;
}

/**
 * @param string $referenceId
 * @return array
 */
function minimalClaimDataFromReferenceId ($referenceId) {
    $db = new Db();

    $claimId = claimIdFromReferenceId($referenceId);

    $claim = $db->getRow("SELECT insuranceid, status
        FROM dental_insurance
        WHERE insuranceid = '$claimId'");

    return $claim ?: [];
}

/**
 * Encapsulate update status logic
 *
 * @param string $referenceId
 * @param string $statusName
 */
function updateClaimStatusFromReferenceId ($referenceId, $statusName) {
    $db = new Db();

    $claimData = minimalClaimDataFromReferenceId($referenceId);

    echo "Claim ID {$claimData['insuranceid']} with reference '$referenceId' needs to change to status '$statusName'";

    /**
     * Update claim only if the statuses differ
     */
    if ($claimData && !ClaimFormData::isStatus($statusName, $claimData['status'])) {
        // This status list returns a pair: [primary status, secondary status]
        $possibleStatuses = ClaimFormData::statusListByName($statusName);
        $newStatus = ClaimFormData::isPrimary($claimData['status']) ? $possibleStatuses[0] : $possibleStatuses[1];

        $db->query("UPDATE dental_insurance
            SET status = '".$db->escape($newStatus)."'
            WHERE insuranceid = '".$db->escape($claimData['insuranceid'])."'");

        claim_status_history_update($claimData['insuranceid'], $newStatus, $claimData['status'], 0, 0);
    }
}
