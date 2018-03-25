<?php

namespace Ds3\Libraries\Legacy;

session_start();

define('ROOT_DIR', config('app.legacy_path'));

$dbConfig = config('database.connections.mysql');

$config_db_name = $dbConfig['database'];
$config_db_user = $dbConfig['username'];
$config_db_pass = $dbConfig['password'];
$config_db_host = $dbConfig['host'];

$con = mysqli_connect($config_db_host, $config_db_user, $config_db_pass);

if (!$con) {
    throw new \RuntimeException('DB connection failure', E_USER_ERROR);
}

if (!mysqli_select_db($con, $config_db_name)) {
    throw new \RuntimeException('DB selection failure', E_USER_ERROR);
}

mysqli_set_charset($con, 'utf8');

$GLOBALS['con'] = $con;

$base_path = config('app.url');
$site_name = config('app.name');
$site_url = config('app.domain');

include 'general.htm';
