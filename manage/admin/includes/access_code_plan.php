<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once 'main_include.php';
$ac_id = $_REQUEST['ac_id'];
$s = "select plan_id FROM dental_access_codes
	WHERE id='".mysql_real_escape_string($ac_id)."'";
$q=mysql_query($s);
if(mysql_num_rows($q)>0){
  $r = mysql_fetch_assoc($q);
  echo '{"plan_id":"'.$r['plan_id'].'"}';
}else{
  echo '{"error":true}';
}
?>
