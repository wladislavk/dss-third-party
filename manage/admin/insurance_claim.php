<?php 
session_start();
require_once('../includes/constants.inc');
require_once('includes/config.php');
include("includes/sescheck.php");

$is_back_office = true;
$manage_path = "../";
$admin_path = "";
$called_from = "manage_claims.php";

include_once("../includes/claim_form.inc");