<?php
session_start();
require_once '../../admin/includes/main_include.php';
require_once '../../admin/includes/password.php';

    $s = "SELECT u.*, ac.plan_id FROM dental_users u 
		JOIN dental_access_codes ac ON u.access_code = ac.access_code
		WHERE 
	u.email='".mysql_real_escape_string($_POST['email'])."' AND
	u.access_code='".mysql_real_escape_string($_POST['code'])."'";

    $q = mysql_query($s);
    if(mysql_num_rows($q)>0){
    	$r = mysql_fetch_assoc($q);
                        $psql = "UPDATE dental_users set access_code='', plan_id='".mysql_real_escape_string($r['plan_id'])."' WHERE userid='".mysql_real_escape_string($r['userid'])."'";
                        mysql_query($psql);
                session_register("regid");
                $_SESSION['regid']=$r['userid'];
	echo '{"success":true}';
    }else{
	echo '{"error":"code"}';
    }
?> 
