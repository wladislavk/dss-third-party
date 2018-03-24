<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../../manage/admin/includes/main_include.php';

$response = sendRecoveryCodeSMS('patient', $_POST['email']);
echo json_encode($response);
