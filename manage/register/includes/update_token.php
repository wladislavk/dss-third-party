<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once '../../admin/includes/main_include.php';
  include_once '../../3rdParty/stripe/lib/Stripe.php';
  include_once '../../includes/constants.inc';

  $id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
  $token = (!empty($_REQUEST['token']) ? $_REQUEST['token'] : '');
  $email = (!empty($_REQUEST['email']) ? $_REQUEST['email'] : '');
  $name = (!empty($_REQUEST['name']) ? $_REQUEST['name'] : '');
  $companyid = (!empty($_REQUEST['companyid']) ? $_REQUEST['companyid'] : '');
  $company = (!empty($_REQUEST['company']) ? $_REQUEST['company'] : '');
  $address= (!empty($_REQUEST['address']) ? $_REQUEST['address'] : '');
  $desc = $name." - ".$company."  - ".$address;
  $number = (!empty($_REQUEST['cnumber']) ? $_REQUEST['cnumber'] : '');
  $cname = (!empty($_REQUEST['cname']) ? $_REQUEST['cname'] : '');
  $exp_month = (!empty($_REQUEST['exp_month']) ? $_REQUEST['exp_month'] : '');
  $exp_year = (!empty($_REQUEST['exp_year']) ? $_REQUEST['exp_year'] : '');
  $cvc = (!empty($_REQUEST['cvc']) ? $_REQUEST['cvc'] : '');
  $zip = (!empty($_REQUEST['zip']) ? $_REQUEST['zip'] : '');

  $key_sql = "SELECT stripe_secret_key FROM companies WHERE id='".mysqli_real_escape_string($con,$companyid)."'";
  $key_r= $db->getRow($key_sql);

  \Stripe::setApiKey($key_r['stripe_secret_key']);

  try {
    // create a Customer
    $customer = \Stripe_Customer::create(array(
                  "card" => array(
                	"number" => $number,
                	"exp_month" => $exp_month,
                	"exp_year" => $exp_year,
                	"cvc" =>  $cvc,
                  "name" => $cname,
                	"address_zip" => $zip
    		        ),
                "email" => $email,
                "description" => $desc)
    );
  } catch(\Stripe_CardError $e) {
      // Since it's a decline, Stripe_CardError will be caught
      $body = $e->getJsonBody();
      $err  = $body['error'];
      echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
      trigger_error("Die called", E_USER_ERROR);
  } catch (\Stripe_InvalidRequestError $e) {
      // Invalid parameters were supplied to Stripe's API
      $body = $e->getJsonBody();
      $err  = $body['error'];
      echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
      trigger_error("Die called", E_USER_ERROR);
  } catch (\Stripe_AuthenticationError $e) {
      // Authentication with Stripe's API failed
      // (maybe you changed API keys recently)
      return $e;
  } catch (\Stripe_ApiConnectionError $e) {
      // Network communication with Stripe failed
      return $e;
  } catch (\Stripe_Error $e) {
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
  $sql = "UPDATE dental_users SET cc_id='".mysqli_real_escape_string($con,$customer->id)."', 
      		status=1,
      		recover_hash='',
      		recover_time=''
      	 	WHERE userid='".mysqli_real_escape_string($con,$id)."'";

  $db->query($sql);

  echo '{"success": true}';
?>
