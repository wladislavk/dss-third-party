<?php

    $config_db_name = "dentalsl_site_dev_new";
    $config_db_user = "root";
    $config_db_pass = "";
    $config_db_host = "localhost";

    session_start();
    $con = mysqli_connect($config_db_host, $config_db_user, $config_db_pass) or die('connection failure');
    mysqli_select_db($con, $config_db_name);

    include ROOT_DIR . '/manage/admin/classes/Db.php';

    $db = new Db();
    
    $base_path = 'http://staging1.dss.xforty.com/dental/manage/';
    $sitename = 'Dental';
