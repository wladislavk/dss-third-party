<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/../includes/claim_create.php';
require_once __DIR__ . '/../includes/claim_functions.php';

$is_front_office = false;
$is_back_office = true;

$manage_path = "../";
$admin_path = "";
$called_from = "view_claim_history.php";
$electronic_form = "insurance_eligible.php?insid=".(!empty($_GET['insid']) ? $_GET['insid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '');

$isEClaimView = $_GET['view'] === 'efile';
$isHistoricView = true;

if ($isEClaimView) {
    require_once __DIR__ . '/../includes/claim_form_eligible.inc';
} else {
    require_once __DIR__ . '/../includes/claim_form_v2.inc';
}
