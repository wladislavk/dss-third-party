<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';

header('Content-Type: text/json');

$_SESSION['api_token'] = generateApiToken('u_' . $_SESSION['userid']);
$token = apiToken();

echo json_encode(['token' => $token]);
