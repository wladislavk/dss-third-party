<?php
    include_once '../../admin/includes/main_include.php';
    include_once '../../admin/includes/password.php';

    $s = "SELECT u.* FROM dental_users u 
          WHERE 
    	  u.email='".mysql_real_escape_string($_POST['email'])."' AND
    	  u.access_code='".mysql_real_escape_string($_POST['code'])."'";

    $q = $db->getResults($s);
    if(count($q)>0){
    	$r = $q[0];
        $psql = "UPDATE dental_users set access_code='' WHERE userid='".mysql_real_escape_string($r['userid'])."'";
        
        $db->query($psql);
        session_register("regid");
        $_SESSION['regid'] = $r['userid'];
	    echo '{"success":true}';
    }else{
	    echo '{"error":"code"}';
    }
?> 
