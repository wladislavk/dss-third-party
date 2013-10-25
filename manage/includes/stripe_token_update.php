<?php
require_once '../admin/includes/main_include.php';
require_once '../3rdParty/stripe/lib/Stripe.php';
require_once 'constants.inc';
$id = $_REQUEST['id'];
$token = $_REQUEST['token'];
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$companyid = $_REQUEST['companyid'];
$company = $_REQUEST['company'];
//$address= $_REQUEST['address'];
$desc = $name." - ".$company;
$number = $_REQUEST['cnumber'];
$cname = $_REQUEST['cname'];
$exp_month = $_REQUEST['exp_month'];
$exp_year = $_REQUEST['exp_year'];
$cvc = $_REQUEST['cvc'];
$zip = $_REQUEST['zip'];

$key_sql = "SELECT stripe_secret_key FROM companies WHERE id='".mysql_real_escape_string($companyid)."'";
$key_q = mysql_query($key_sql);
$key_r= mysql_fetch_assoc($key_q);

Stripe::setApiKey($key_r['stripe_secret_key']);
$customer = Stripe_Customer::retrieve($token);
$new_card = $customer->cards->create(array("card" => array(
        "number" => $number,
        "exp_month" => $exp_month,
        "exp_year" => $exp_year,
        "cvc" =>  $cvc,
        "name" => $cname,
        "address_zip" => $zip
                )));
$cc = json_decode($new_card);
$customer->default_card = $cc->id;
try {
// create a Customer
$customer->save();
} catch(Stripe_CardError $e) {
  // Since it's a decline, Stripe_CardError will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
  die();
} catch (Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
  $body = $e->getJsonBody();
  $err  = $body['error'];
  echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
  die();
} catch (Stripe_AuthenticationError $e) {
  // Authen-rication with Stripe's API failed
  // (maybe you changed API keys recently)
  return $e;
} catch (Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  return $e;
} catch (Stripe_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  return $e;
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  return $e;
}

// charge the Customer instead of the card
//Stripe_Charge::create(array(
//  "amount" => 1000, # amount in cents, again
//  "currency" => "usd",
//  "customer" => $customer->id)
//);


$sql = "UPDATE dental_users SET cc_id='".mysql_real_escape_string($customer->id)."', 
	 	WHERE userid='".mysql_real_escape_string($id)."'";
mysql_query($sql);


echo '{"success": true}';
?>
