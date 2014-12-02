<?php 
include_once('includes/constants.inc');
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include('includes/claim_create.php');
include('includes/claim_functions.php');
//include('includes/general_functions.php');

$is_front_office = true;
$manage_path = "";
$admin_path = "admin/";
$called_from = "manage_insurance.php";
$electronic_form = "insurance_eligible.php?insid=".(!empty($_GET['insid']) ? $_GET['insid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '');
include_once("includes/claim_form_v2.inc");
