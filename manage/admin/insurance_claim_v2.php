<?php 
session_start();
require_once '../includes/constants.inc';
require_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/claim_create.php';
include_once '../includes/claim_functions.php';
include_once '../includes/general_functions.php';

$is_back_office = true;
$manage_path = "../";
$admin_path = "";
$called_from = "manage_claims.php";
$electronic_form = "insurance_claim_eligible.php?insid=".(!empty($_GET['insid']) ? $_GET['insid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '')."&instype=".(!empty($_GET['instype']) ? $_GET['instype'] : '');
include_once("../includes/claim_form_v2.inc");
