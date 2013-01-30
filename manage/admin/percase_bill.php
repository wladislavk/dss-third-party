<?php
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
require_once '../includes/constants.inc';
require_once 'includes/access.php';
require_once '../3rdParty/stripe/lib/Stripe.php';
?><br /><br /><br /><?php
$id = $_GET['docid'];
$sql = "SELECT cc_id FROM dental_users
	WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
$customerID = $r['cc_id'];
if($customerID!=''){
Stripe::setApiKey(DSS_STRIPE_SEC_KEY);

Stripe_Charge::create(array(
    "amount" => 1500, # $15.00 this time
    "currency" => "usd",
    "customer" => $customerID)
);
?><h3>Billed $15.</h3><?php
}else{
?><h3>Not entered in Stripe.</h3><?php
}

?>



