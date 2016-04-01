<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../admin/includes/main_include.php';
require_once __DIR__ . '/../../3rdParty/stripe/lib/Stripe.php';
require_once __DIR__ . '/../../includes/constants.inc';
require_once __DIR__ . '/../../includes/general_functions.php';

$id = intval($_REQUEST['id']);

linkRequestData('dental_users', $id);

$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$companyid = $_REQUEST['companyid'];
$company = $_REQUEST['company'];
$desc = $name." - ".$company;
$number = $_REQUEST['cnumber'];
$cname = $_REQUEST['cname'];
$exp_month = $_REQUEST['exp_month'];
$exp_year = $_REQUEST['exp_year'];
$cvc = $_REQUEST['cvc'];
$zip = $_REQUEST['zip'];

$key_sql = "SELECT stripe_secret_key FROM companies WHERE id = '" . $db->escape($companyid) . "'";
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
        "description" => $desc
    ));
} catch (\Stripe_CardError $e) {
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

$recover_hash = hash('sha256', $id.$email.rand());

$sql = "UPDATE dental_users SET
        cc_id = '" . $db->escape($customer->id) . "',
        status = 2,
        recover_hash = '" . $recover_hash . "',
        recover_time = NOW()
    WHERE userid = '" . $db->escape($id) . "'";
$db->query($sql);

//send registration email.
$from = 'Dental Sleep Solutions Support <support@dentalsleepsolutions.com>';
$to = "$name <$email>";
$subject = 'Dental Sleep Solutions Account Activation';
$template = getTemplate('user/registration');

$sent = sendEmail($from, $to, $subject, $template, ['id' => $id, 'hash' => $recover_hash]);

if ($sent) {
    $e_sql = "UPDATE dental_users
        SET registration_email_date = NOW()
        WHERE userid = '" . $db->escape($id) . "'";
    $db->query($e_sql);
}

echo json_encode(['success' => $sent]);
