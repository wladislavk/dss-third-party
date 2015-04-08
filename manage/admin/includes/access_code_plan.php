<?php
require_once 'main_include.php';
$ac_id = $_REQUEST['ac_id'];
$s = "select plan_id FROM dental_access_codes
	WHERE id='".mysqli_real_escape_string($con, $ac_id)."'";
$q=mysqli_query($con, $s);
if(mysqli_num_rows($q)>0){
  $r = mysqli_fetch_assoc($q);
  echo '{"plan_id":"'.$r['plan_id'].'"}';
}else{
  echo '{"error":true}';
}
?>
