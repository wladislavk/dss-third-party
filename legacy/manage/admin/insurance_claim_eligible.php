<?php namespace Ds3\Libraries\Legacy; ?><?php 
include_once '../includes/constants.inc';
include_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/claim_create.php';
include_once 'includes/claim_functions.php';
include_once 'includes/invoice_functions.php';
include_once '../includes/general_functions.php';

$is_back_office = true;
$manage_path = "../";
$admin_path = "";
$called_from = "manage_claims.php";
$v2_form = "insurance_claim_v2.php?insid=".(!empty($_GET['insid']) ? $_GET['insid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '')."&instype=".(!empty($_GET['instype']) ? $_GET['instype'] : '');
include_once("../includes/claim_form_eligible.inc");
?>

    <script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="/manage/js/masks.js?v=<?= time() ?>"></script>
