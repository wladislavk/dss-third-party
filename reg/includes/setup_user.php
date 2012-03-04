<?php
require_once '../../manage/admin/includes/config.php';
require_once '../../manage/admin/includes/password.php';

    $s = "SELECT * FROM dental_patients WHERE 
	email='".mysql_real_escape_string($_POST['email'])."' AND
	access_code='".mysql_real_escape_string($_POST['code'])."'";

    $q = mysql_query($s);
    if(mysql_num_rows($q)>0){
    	$r = mysql_fetch_assoc($q);
			$p = $_POST['p'];
                        $salt = create_salt();
                        $password = gen_password($p , $salt);
                        $psql = "UPDATE dental_patients set password='".$password."', salt='".$salt."', recover_hash='', access_code='', registration_status=2  WHERE patientid='".mysql_real_escape_string($r['patientid'])."'";
                        mysql_query($psql);
	echo '{"success":true}';
    }else{
	echo '{"error":"code"}';
    }
?> 
