<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/admin/includes/claim_functions.php'; // claim_status_history_update

// This php://input does not work when NOT bypassing Laravel
$plainTextResponse = file_get_contents('php://input');
processEligibleResponse($plainTextResponse);
