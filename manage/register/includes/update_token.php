<?php
require_once '../../admin/includes/config.php';
require_once '../../3rdParty/stripe/lib/Stripe.php';
require_once '../../includes/constants.inc';
$id = $_REQUEST['id'];
$token = $_REQUEST['token'];
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$address= $_REQUEST['address'];
$desc = $name." - ".$address;
Stripe::setApiKey(DSS_STRIPE_SEC_KEY);

// create a Customer
$customer = Stripe_Customer::create(array(
  "card" => $token,
  "email" => $email,
  "description" => $desc)
);

// charge the Customer instead of the card
//Stripe_Charge::create(array(
//  "amount" => 1000, # amount in cents, again
//  "currency" => "usd",
//  "customer" => $customer->id)
//);
$sql = "UPDATE dental_users SET cc_id='".mysql_real_escape_string($customer->id)."' WHERE userid='".mysql_real_escape_string($id)."'";
mysql_query($sql);
?>
