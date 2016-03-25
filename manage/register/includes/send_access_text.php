<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../admin/includes/main_include.php';

$response = sendAccessCodeSMS('user', $_REQUEST['id'], $_REQUEST['hash']);
echo json_encode($response);
