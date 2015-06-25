<?php

namespace Ds3\Libraries\Legacy;

session_start();

define('ROOT_DIR', config('app.legacy_path'));

$dbConfig = config('database.connections.mysql');

$config_db_name = $dbConfig['database'];
$config_db_user = $dbConfig['username'];
$config_db_pass = $dbConfig['password'];
$config_db_host = $dbConfig['host'];

$con = mysqli_connect($config_db_host, $config_db_user, $config_db_pass)
    or trigger_error('DB connection failure', E_USER_ERROR);

mysqli_select_db($con, $config_db_name) or trigger_error('DB selection failure', E_USER_ERROR);

$GLOBALS['con'] = $con;

include ROOT_DIR . '/manage/admin/classes/Db.php';

$db = new Db();
$GLOBALS['db'] = $db;

$base_path = config('app.url') . 'manage/';
$sitename = config('app.name');
