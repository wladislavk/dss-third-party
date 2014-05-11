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
$v2_form = "insurance_claim_v2.php?insid=".$_GET['insid']."&pid=".$_GET['pid'];
include_once("../includes/claim_form_eligible.inc");
