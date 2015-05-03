<?php

    define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);

    $config_db_name = "dentalsl_site_dev_new";
    $config_db_user = "root";
    $config_db_pass = "";
    $config_db_host = "localhost";

    session_start();
    $con = mysqli_connect($config_db_host, $config_db_user, $config_db_pass) or die('connection failure');
    mysqli_select_db($con, $config_db_name);
    
    $base_path = 'http://' . $_SERVER['HTTP_HOST'] . '/dental/';

    include 'general.htm';

    $site_name = 'Dental Sleep Solutions';
    $site_url = 'dentalsleepsolutions.com';
