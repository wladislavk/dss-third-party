<?php
namespace Ds3\Libraries\Legacy;

use function call_user_func;
use Stripe\ApiRequestor;
use Stripe\Card;
use Stripe\Collection;
use Stripe\Customer;
use Stripe\HttpClient\CurlClient;
use Stripe\StripeObject;
use Stripe\Stripe;

/**
 * @param int $docId
 * @return array
 */
function getStripeRelatedUserData($docId)
{
    $db = new Db();
    $docId = (int)$docId;
    $sql = "SELECT
            c.stripe_secret_key,
            u.cc_id,
            u.userid,
            c.id,
            c.name,
            u.email
        FROM companies c
            JOIN dental_user_company uc ON c.id = uc.companyid
            JOIN dental_users u ON u.userid = uc.userid
        WHERE u.userid = $docId";

    $data = $db->getRow($sql);

    if (sizeof($data)) {
        $data['user_name'] = $data['first_name'] . ' ' . $data['last_name'];
    }

    return $data;
}

/**
 * @param string $privateKey
 */
function setupStripeConnection($privateKey)
{

    if ($_SESSION['docid'] == 16) {
        $privateKey = 'sk_test_2Bwg6V5pLmm8Gbidwxc8Iwhk';
    }
    $curl = new CurlClient([CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2]);
    ApiRequestor::setHttpClient($curl);
    $apiUrl = getenv('LAN_API_URL');
    // Temporary proxy
    Stripe::$apiBase = $apiUrl . 'stripe';
    Stripe::setApiKey($privateKey);
}

/**
 * @param StripeObject|null $customer
 * @return bool
 */
function isValidStripeCustomer(StripeObject $customer = null)
{
    if (
        !$customer
        || (property_exists($customer, 'deleted') && $customer->deleted)
        || !isset($customer->sources)
        || !$customer->sources
    ) {
        return false;
    }

    return true;
}

/**
 * @param string      $customerId
 * @return Customer|null
 */
function getStripeCustomer($customerId)
{
    if (!$customerId) {
        return null;
    }

    /** @var Customer|StripeObject $customer */
    $customer = Customer::retrieve($customerId);

    if (isValidStripeCustomer($customer)) {
        return $customer;
    }

    return null;
}

/**
 * @param string $email
 * @return Customer|null
 */
function searchStripeCustomer($email)
{
    if (!strlen($email)) {
        return null;
    }

    $matches = Customer::all([
        'email' => $email,
    ]);

    if (!sizeof($matches->data)) {
        return null;
    }

    $customer = $matches->data[0];

    if (isValidStripeCustomer($customer)) {
        return $customer;
    }

    return null;
}

/**
 * @param Customer|null $customer
 * @return Card|null
 */
function getActiveStripeCard($customer = null)
{
    if (!isValidStripeCustomer($customer)) {
        return null;
    }

    if ($customer->default_source) {
        $card = $customer->sources->retrieve($customer->default_source);
        return $card;
    }

    /** @var Collection $cardCollection */
    $cardCollection = $customer->sources->all(['object' => 'card']);

    if (!$cardCollection) {
        return null;
    }

    /** @var Card[] $cards */
    $cards = $cardCollection->data;

    if (isset($cards[0])) {
        return $cards[0];
    }

    return null;
}

/**
 * @param array $details
 * @return Customer
 */
function createStripeCustomer(array $details)
{
    /** @var Customer $customer */
    $customer = Customer::create($details);
    return $customer;
}

/**
 * @param Customer|null $customer
 * @param array         $details
 * @return Card|null
 */
function createStripeCard(Customer $customer = null, array $details)
{
    if (!isValidStripeCustomer($customer)) {
        return null;
    }

    $details['object'] = 'card';
    $cardSource = ['source' => $details];

    /** @var \Stripe\Card $card */
    $card = $customer->sources->create($cardSource);
    return $card;
}

/**
 * @param array $details
 * @return Customer
 */
function createStripeCustomerWithCard(array $details)
{
    $customerDetails = $details;
    $cardDetails = [];

    if (isset($customerDetails['card'])) {
        $cardDetails = $customerDetails['card'];
        unset($customerDetails['card']);
    }

    $cardDetails['object'] = 'card';
    $customerDetails['source'] = $cardDetails;

    $customer = createStripeCustomer($customerDetails);
    return $customer;
}
