<?php namespace Ds3\Libraries\Legacy; ?><?php
session_start();
require_once './main_include.php';
$id = $_SESSION['adminuserid'];
$logout_time = 3*60*60; // 3 hours in seconds
$s = "SELECT last_accessed_date FROM admin
	WHERE adminid='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);
$lat = strtotime($r['last_accessed_date']);
$now = time();
if($lat > $now - $logout_time){
  $rt = ($logout_time - ($now - $lat))*1000;	
  echo '{"reset_time":'.$rt.'}';
}else{
  echo '{"logout":true}';
}
?>
