<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/claim_functions.php';

function create_claim($pid, $prod)
{
    $claimId = ClaimFormData::createPrimaryClaim($pid, $prod);
    return $claimId;
}
