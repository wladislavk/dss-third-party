<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';

header('Content-Type: text/json');

apiToken(refreshApiToken($_SESSION['token']));
$token = apiToken();

echo json_encode(['token' => $token]);
