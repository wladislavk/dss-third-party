<?php
session_start();
require_once '../../admin/includes/config.php';
require_once '../../admin/includes/password.php';

    $s = "SELECT * FROM dental_users WHERE 
	email='".mysql_real_escape_string($_POST['email'])."' AND
	access_code='".mysql_real_escape_string($_POST['code'])."'";

    $q = mysql_query($s);
    if(mysql_num_rows($q)>0){
    	$r = mysql_fetch_assoc($q);
                        $psql = "UPDATE dental_users set access_code='' WHERE userid='".mysql_real_escape_string($r['userid'])."'";
                        mysql_query($psql);
                session_register("regid");
                $_SESSION['regid']=$r['userid'];
	echo '{"success":true}';
    }else{
	echo '{"error":"code"}';
    }
?> 
