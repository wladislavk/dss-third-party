<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/general.htm';
require_once __DIR__ . '/includes/claim_functions.php';
require_once __DIR__ . '/includes/invoice_functions.php';
require_once __DIR__ . '/../includes/claim_functions.php';

$claimId = intval($_GET['insid']);

$eClaimData = $db->getRow("SELECT *
    FROM dental_claim_electronic
    WHERE claimid = '$claimId'
    ORDER BY adddate DESC
    LIMIT 1");

if ($eClaimData) {
    $referenceId = $eClaimData['reference_id'];

    if ($referenceId != "") {
        $claimData = $db->getRow("SELECT eligible_test, dental_insurance.docid, dental_insurance.status
            FROM dental_users
                JOIN dental_insurance ON dental_users.userid = dental_insurance.docid
            WHERE insuranceid = '$claimId'");

        $eligibleApiKey = DSS_DEFAULT_ELIGIBLE_API_KEY;
        $docId = intval($claimData['docid']);
        $currentStatus = intval($claimData['status']);

        $apiKeyData = $db->getRow("SELECT eligible_api_key
            FROM dental_user_company
                LEFT JOIN companies ON dental_user_company.companyid = companies.id
            WHERE dental_user_company.userid = '$docId'");

        if ($apiKeyData && !empty($apiKeyData['eligible_api_key']) && trim($apiKeyData['eligible_api_key']) != "") {
            $eligibleApiKey = $apiKeyData['eligible_api_key'];
        }

        $eligibleEndPoint = 'https://gds.eligibleapi.com/v1.5/claims/' . urlencode($referenceId) .
            '/acknowledgements?api_key=' . urlencode($eligibleApiKey);

        if ($claimData['eligible_test'] == "1") {
            $eligibleEndPoint .= '&test=true';
        }

        $eligibleApiRequest = curl_init();

        curl_setopt($eligibleApiRequest, CURLOPT_URL, $eligibleEndPoint);
        curl_setopt($eligibleApiRequest, CURLOPT_RETURNTRANSFER, true);

        $eligibleResponse = curl_exec($eligibleApiRequest);
        echo $eligibleResponse;
        
        $jsonResponse = json_decode($eligibleResponse);

        $referenceId = $jsonResponse->reference_id;
        $acknowledgements = $jsonResponse->acknowledgements;
        $responseStatus = $acknowledgements[0]->status;
        
        $message = "Status: " . $responseStatus . "\\n\\nMessage: " . $acknowledgements[0]->message;
        echo "<br>".$acknowledgements[0]->errors;
        
        foreach ($acknowledgements[0]->errors as $error) {
            $message .= "\\n\\nERROR: " . $error->message;
        }

        $db->query("INSERT INTO dental_eligible_response SET
            response = '".$db->escape($eligibleResponse)."',
            reference_id = '".$db->escape($referenceId)."',
            event_type = '".$db->escape($responseStatus)."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");

        $newStatus = 0;
        $isSecondary = ClaimFormData::isSecondary($currentStatus);

        if ($isSecondary) {
            if ($responseStatus == "created") {
                $newStatus = DSS_CLAIM_SEC_SENT;
            } elseif ($responseStatus == "received") {
                $newStatus = DSS_CLAIM_SEC_SENT;
            } elseif ($responseStatus == "rejected") {
                $newStatus = DSS_CLAIM_SEC_REJECTED;
            } elseif ($responseStatus == "accepted") {
                $newStatus = DSS_CLAIM_SEC_EFILE_ACCEPTED;
            }
        } else {
            if ($responseStatus == "created") {
                $newStatus = DSS_CLAIM_SENT;
            } elseif ($responseStatus == "received") {
                $newStatus = DSS_CLAIM_SENT;
            } elseif ($responseStatus == "rejected") {
                $newStatus = DSS_CLAIM_REJECTED;
            } elseif ($responseStatus == "accepted") {
                $newStatus = DSS_CLAIM_EFILE_ACCEPTED;
            }
        }

        echo $dss_claim_status_labels[$currentStatus];

        if (!$isSecondary) {
            $db->query("UPDATE dental_insurance
                SET status = '$newStatus'
                WHERE insuranceid = '$claimId'");
            claim_status_history_update($claimId, $newStatus, $currentStatus, 0, 0);
        }
    }
}

?>
<script type="text/javascript">
    <?php if (!empty($message)) { ?>
        alert("<?= htmlspecialchars($message) ?>\n<?= $dss_claim_status_labels[$currentStatus] . '-' . $currentStatus ?> ");
    <?php } ?>
    window.location = "manage_claims.php";
</script>
