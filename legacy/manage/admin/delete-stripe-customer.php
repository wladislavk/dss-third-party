<?php
namespace Ds3\Libraries\Legacy;

use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/access.php';
require_once __DIR__ . '/includes/stripe-functions.php';

set_time_limit(0);

/**
 * @param int $statusCode
 */
function sendResponseWithJsonStatus($statusCode)
{
    if (!isset(Response::$statusTexts[$statusCode])) {
        $statusCode = Response::HTTP_BAD_REQUEST;
    }

    $response = [
        'code' => $statusCode,
        'status' => Response::$statusTexts[$statusCode],
    ];
    http_response_code($statusCode);
    echo json_encode($response);
    trigger_error('Die called', E_USER_ERROR);
}

if (!getenv('DOCKER_USED') || !is_super($_SESSION['admin_access'])) {
    sendResponseWithJsonStatus(Response::HTTP_UNAUTHORIZED);
}

if (strtolower($_SERVER['REQUEST_METHOD']) !== 'post') {
    sendResponseWithJsonStatus(Response::HTTP_METHOD_NOT_ALLOWED);
}

if (empty($_POST['docid'])) {
    sendResponseWithJsonStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
}

$docId = (int)$_POST['docid'];
$userData = getStripeRelatedUserData($docId);

if (!sizeof($userData)) {
    sendResponseWithJsonStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
}

setupStripeConnection($userData['stripe_secret_key']);
$customer = getStripeCustomer($userData['cc_id']);

if (!$customer && strlen($userData['email'])) {
    $customer = searchStripeCustomer($userData['email']);
}

if ($customer) {
    $customer->delete();
}

sendResponseWithJsonStatus(Response::HTTP_OK);
