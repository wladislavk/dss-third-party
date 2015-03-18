<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once '../../admin/includes/main_include.php';
  include_once '../../3rdParty/stripe/lib/Stripe.php';
  include_once '../../includes/constants.inc';
  $id = $_REQUEST['id'];
  //$token = $_REQUEST['token'];
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

  $key_sql = "SELECT stripe_secret_key FROM companies WHERE id='".mysqli_real_escape_string($con, $companyid)."'";
  
  $key_r= $db->getRow($key_sql);

  Stripe::setApiKey($key_r['stripe_secret_key']);

  try {
    // create a Customer
    $customer = Stripe_Customer::create(array(
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
  } catch(Stripe_CardError $e) {
      // Since it's a decline, Stripe_CardError will be caught
      $body = $e->getJsonBody();
      $err  = $body['error'];
      echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
      trigger_error("Die called", E_USER_ERROR);
  } catch (Stripe_InvalidRequestError $e) {
      // Invalid parameters were supplied to Stripe's API
      $body = $e->getJsonBody();
      $err  = $body['error'];
      echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
      trigger_error("Die called", E_USER_ERROR);
  } catch (Stripe_AuthenticationError $e) {
      // Authentication with Stripe's API failed
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

  $recover_hash = hash('sha256', $id.$email.rand());

  $sql = "UPDATE dental_users SET cc_id='".mysqli_real_escape_string($con, $customer->id)."', 
      		status=2,
      		recover_hash='".$recover_hash."',
      		recover_time=NOW()
      	 	WHERE userid='".mysqli_real_escape_string($con, $id)."'";

  $db->query($sql);

  //send registration email.
  $m = "<html><body><center>
        <table width='600'>
        <tr><td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
        <tr><td width='400'>
        <h2>Create your Software Account</h2>
        <p>Welcome to the Dental Sleep Solutions&reg; Team! Please click the link below to activate your software account:
        <p><a href='http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$id."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$id."&hash=".$recover_hash."</a></p>
        </td><td width='200'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
        <tr><td>
        <h3>Need assistance?
        Contact us at 877-95-SNORE or at<br>
        Support@dentalsleepsolutions.com</b></h3></td></tr>
        <tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
        </table>
        </center></body></html>
        ";
  $m .= DSS_EMAIL_FOOTER;
  $headers = 'From: support@dentalsleepsolutions.com' . "\r\n" .
              'Content-type: text/html' ."\r\n" .
              'Reply-To: support@dentalsleepsolutions.com' . "\r\n" .
              'X-Mailer: PHP/' . phpversion();

  $subject = "Dental Sleep Solutions Account Activation";
  $mail = mail($email, $subject, $m, $headers);
  if($mail){
    $e_sql = "UPDATE dental_users SET registration_email_date=now() WHERE userid='".mysqli_real_escape_string($con, $id)."'";
    $db->query($e_sql);
  }

  echo '{"success": true}';
?>
