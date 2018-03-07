<?php namespace Ds3\Libraries\Legacy; ?><?php
  require_once __DIR__ . '/../../../vendor/autoload.php';
  include_once '../../admin/includes/main_include.php';
  include_once '../../includes/constants.inc';

  $id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');

linkRequestData('dental_users', $id);

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

  $key_sql = "SELECT stripe_secret_key FROM companies WHERE id='".$db->escape($companyid)."'";
  $key_r= $db->getRow($key_sql);

  $curl = new \Stripe\HttpClient\CurlClient(array(CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2));
  \Stripe\ApiRequestor::setHttpClient($curl);
  \Stripe\Stripe::setApiKey($key_r['stripe_secret_key']);

  try {
    // create a Customer
    $customer = \Stripe\Customer::create(array(
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
  } catch(\Stripe\Error\Card $e) {
      // Since it's a decline, Stripe_CardError will be caught
      $body = $e->getJsonBody();
      $err  = $body['error'];
      echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
      trigger_error("Die called", E_USER_ERROR);
  } catch (\Stripe\Error\InvalidRequest $e) {
      // Invalid parameters were supplied to Stripe's API
      $body = $e->getJsonBody();
      $err  = $body['error'];
      echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
      trigger_error("Die called", E_USER_ERROR);
  } catch (\Stripe\Error\Authentication $e) {
      // Authentication with Stripe's API failed
      // (maybe you changed API keys recently)
      return $e;
  } catch (\Stripe\Error\ApiConnection $e) {
      // Network communication with Stripe failed
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
  $sql = "UPDATE dental_users SET cc_id='".$db->escape($customer->id)."', 
      		status=1,
      		recover_hash='',
      		recover_time=''
      	 	WHERE userid='".$db->escape($id)."'";

  $db->query($sql);

  echo '{"success": true}';
?>
