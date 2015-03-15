<?php namespace Ds3\Legacy; ?><?php
    include_once '../../admin/includes/main_include.php';
    include_once '../../admin/includes/password.php';

    $s = "SELECT u.* FROM dental_users u 
          WHERE 
    	  u.email='".mysqli_real_escape_string($con, $_POST['email'])."' AND
    	  u.access_code='".mysqli_real_escape_string($con, $_POST['code'])."'";

    $q = $db->getResults($s);
    if(count($q)>0){
    	$r = $q[0];
        $psql = "UPDATE dental_users set access_code='' WHERE userid='".mysqli_real_escape_string($con, $r['userid'])."'";
        
        $db->query($psql);
        session_register("regid");
        $_SESSION['regid'] = $r['userid'];
	    echo '{"success":true}';
    }else{
	    echo '{"error":"code"}';
    }
?> 
