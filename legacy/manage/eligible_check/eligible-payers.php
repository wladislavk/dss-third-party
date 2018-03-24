<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/main_include.php';
require_once __DIR__ . '/../includes/constants.inc';

$json = @file_get_contents('https://gds.eligibleapi.com/v1.5/payers.json?api_key=' . DSS_DEFAULT_ELIGIBLE_API_KEY);

header('Content-Type: application/json');
echo $json;
