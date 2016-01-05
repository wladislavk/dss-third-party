<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/claim_functions.php';

function create_claim ($pid, $prod) {
    $claimId = ClaimFormData::createPrimaryClaim($pid, $prod);
    return $claimId;
}

function create_claim_sec ($pid, $primary_claim_id, $prod) {
    $claimId = ClaimFormData::createSecondaryClaim($pid, $prod, $primary_claim_id);
    return $claimId;
}
