<?php 
session_start();
require_once('../includes/constants.inc');
require_once('includes/main_include.php');
include("includes/sescheck.php");
include('../includes/claim_create.php');
include('../includes/general_functions.php');

$is_back_office = true;
$manage_path = "../";
$admin_path = "";
$called_from = "manage_claims.php";

include_once("../includes/claim_form.inc");
