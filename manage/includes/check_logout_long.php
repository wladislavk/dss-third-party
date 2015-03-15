<?php namespace Ds3\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';

	$id = (!empty($_SESSION['userid']) ? $_SESSION['userid'] : '');
	$logout_time = 4*60*60;
	$s = "SELECT last_accessed_date FROM dental_users
		WHERE userid='".mysqli_real_escape_string($con,$id)."'";
	
	$r = $db->getRow($s);
	$lat = strtotime($r['last_accessed_date']);
	$now = time();
	if($lat > $now - $logout_time) {
	  $rt = ($logout_time - ($now - $lat))*1000;	
	  echo '{"reset_time":'.$rt.'}';
	} else {
	  echo '{"logout":true}';
	}
?>
