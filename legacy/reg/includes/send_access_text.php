<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../manage/admin/includes/main_include.php';

$response = sendAccessCodeSMS('patient', $_REQUEST['id'], $_REQUEST['hash']);
echo json_encode($response);
