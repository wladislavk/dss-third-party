<?php namespace Ds3\Libraries\Legacy; ?><?php

header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

define('ROOT_DIR',$_SERVER['DOCUMENT_ROOT']);

include_once ROOT_DIR . '/manage/admin/includes/config.php';
include_once ROOT_DIR . '/manage/admin/includes/general.htm';
include_once ROOT_DIR . '/manage/includes/general_functions.php';

logRequestData();
