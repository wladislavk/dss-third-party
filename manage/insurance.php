<?php 
session_start();
require_once('includes/constants.inc');
require_once('admin/includes/config.php');
include("includes/sescheck.php");

$is_front_office = true;
$manage_path = "";
$admin_path = "admin/";
$called_from = "manage_insurance.php";

include_once("includes/claim_form.inc");