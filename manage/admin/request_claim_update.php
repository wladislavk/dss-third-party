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

    if ($referenceId != '') {
        $claimData = $db->getRow("SELECT eligible_test, dental_insurance.docid, dental_insurance.status
            FROM dental_users
                JOIN dental_insurance ON dental_users.userid = dental_insurance.docid
            WHERE insuranceid = '$claimId'");

        $eligibleApiKey = DSS_DEFAULT_ELIGIBLE_API_KEY;
        $docId = intval($claimData['docid']);

        $apiKeyData = $db->getRow("SELECT eligible_api_key
            FROM dental_user_company
                LEFT JOIN companies ON dental_user_company.companyid = companies.id
            WHERE dental_user_company.userid = '$docId'");

        if ($apiKeyData && !empty($apiKeyData['eligible_api_key']) && trim($apiKeyData['eligible_api_key']) != '') {
            $eligibleApiKey = $apiKeyData['eligible_api_key'];
        }

        $eligibleEndPoint = 'https://gds.eligibleapi.com/v1.5/claims/' . urlencode($referenceId) .
            '/acknowledgements?api_key=' . urlencode($eligibleApiKey);

        if ($claimData['eligible_test'] == 1) {
            $eligibleEndPoint .= '&test=true';
        }

        $eligibleApiRequest = curl_init();

        curl_setopt($eligibleApiRequest, CURLOPT_URL, $eligibleEndPoint);
        curl_setopt($eligibleApiRequest, CURLOPT_RETURNTRANSFER, true);

        $eligibleResponse = curl_exec($eligibleApiRequest);

        $jsonResponse = processEligibleResponse($eligibleResponse);
        $message = detailsFromEligibleResponse($jsonResponse);

        $message = $message ? join('\n\n', $message) : '';
    }
}

?>
<script type="text/javascript">
    <?php if (!empty($message)) { ?>
        alert("<?= e($message) ?>");
    <?php } ?>
    window.location = "manage_claims.php";
</script>
