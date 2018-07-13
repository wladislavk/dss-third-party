<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/stripe-functions.php';
include_once '../admin/includes/main_include.php';
include_once 'constants.inc';

$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
$email = (!empty($_REQUEST['email']) ? $_REQUEST['email'] : '');
$name = (!empty($_REQUEST['name']) ? $_REQUEST['name'] : '');
$companyid = (!empty($_REQUEST['companyid']) ? $_REQUEST['companyid'] : '');
$company = (!empty($_REQUEST['company']) ? $_REQUEST['company'] : '');
$desc = $name." - ".$company;
$number = (!empty($_REQUEST['cnumber']) ? $_REQUEST['cnumber'] : '');
$cname = (!empty($_REQUEST['cname']) ? $_REQUEST['cname'] : '');
$exp_month = (!empty($_REQUEST['exp_month']) ? $_REQUEST['exp_month'] : '');
$exp_year = (!empty($_REQUEST['exp_year']) ? $_REQUEST['exp_year'] : '');
$cvc = (!empty($_REQUEST['cvc']) ? $_REQUEST['cvc'] : '');
$zip = (!empty($_REQUEST['zip']) ? $_REQUEST['zip'] : '');

$db = new Db();

$key_sql = "SELECT stripe_secret_key FROM companies WHERE id='".$db->escape($companyid)."'";
$key_r = $db->getRow($key_sql);
setupStripeConnection($key_r['stripe_secret_key']);

$cardDetails = [
    'number' => $number,
    'exp_month' => $exp_month,
    'exp_year' => $exp_year,
    'cvc' => $cvc,
    'name' => $cname,
    'address_zip' => $zip,
];
$customerDetails = [
    'email' => $email,
    'description' => $desc,
];

try {
    // create a Customer
    $customer = searchStripeCustomer($email);

    if (!$customer) {
        $customer = createStripeCustomer($customerDetails);
    }

    createStripeCard($customer, $cardDetails);
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
    $body = $e->getJsonBody();
    $err  = $body['error'];
    echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
    trigger_error("Die called", E_USER_ERROR);
} catch (\Stripe\Error\ApiConnection $e) {
    // Network communication with Stripe failed
    $body = $e->getJsonBody();
    $err  = $body['error'];
    echo '{"error": {"code":"'.$err['code'].'","message":"'.$err['message'].'"}}';
    trigger_error("Die called", E_USER_ERROR);
} catch (\Exception $e) {
    // Something else happened, completely unrelated to Stripe
    echo '{"error": {"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}';
    trigger_error("Die called", E_USER_ERROR);
}

$sql = "UPDATE dental_users SET cc_id='".$db->escape($customer->id)."'
        WHERE userid='".$db->escape($id)."'";

$db->query($sql);
echo '{"success": true}';
