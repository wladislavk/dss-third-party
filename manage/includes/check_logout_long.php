<?php
//session_start();
require_once '../admin/includes/config.php';
$id = $_SESSION['userid'];
$logout_time = 4*60*60; //seconds
$s = "SELECT last_accessed_date FROM dental_users
	WHERE userid='".mysql_real_escape_string($id)."'";
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
