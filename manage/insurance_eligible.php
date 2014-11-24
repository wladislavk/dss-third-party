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
	$v2_form = "insurance_v2.php?insid=".(!empty($_GET['insid']) ? $_GET['insid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '');
	
	include_once("includes/claim_form_eligible.inc");
?>

	<link rel="stylesheet" href="css/insurance_eligible.css">
