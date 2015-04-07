<?php
session_start();
require_once '../../manage/admin/includes/main_include.php';
require_once '../../manage/admin/includes/password.php';

    $s = "SELECT * FROM dental_patients WHERE 
	email='".mysqli_real_escape_string($con, $_POST['email'])."' AND
	access_code='".mysqli_real_escape_string($con, $_POST['code'])."'";

    $q = mysql_query($s);
    if(mysql_num_rows($q)>0){
    	$r = mysql_fetch_assoc($q);
			$p = $_POST['p'];
                        $salt = create_salt();
                        $password = gen_password($p , $salt);
                        $psql = "UPDATE dental_patients set password='".$password."', salt='".$salt."', recover_hash='', access_code='', registration_status=2  WHERE patientid='".mysqli_real_escape_string($con, $r['patientid'])."'";
                        mysql_query($psql);
                session_register("pid");
                $_SESSION['pid']=$r['patientid'];
	echo '{"success":true}';
    }else{
	echo '{"error":"code"}';
    }
?> 
