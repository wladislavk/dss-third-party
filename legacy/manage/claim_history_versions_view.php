<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/claim_create.php';
require_once __DIR__ . '/includes/claim_functions.php';

$is_front_office = true;
$manage_path = "";
$admin_path = "admin/";
$called_from = "manage_insurance.php";
$electronic_form = "insurance_eligible.php?insid=".(!empty($_GET['insid']) ? $_GET['insid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '');

$isEClaimView = $_GET['view'] === 'efile';
$isHistoricView = true;

if ($isEClaimView) {
    require_once __DIR__ . '/includes/claim_form_eligible.inc';
} else {
    require_once __DIR__ . '/includes/claim_form_v2.inc';
}
