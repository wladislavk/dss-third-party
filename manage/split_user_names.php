<?php

include 'admin/includes/config.php';

$s = "SELECT userid, name FROM dental_users";
$q = mysqli_query($con, $s);
while($r = mysqli_fetch_assoc($q)){

  echo $r['name'];
  echo "<br />";

  $n = $r['name'];
  $p = '/(Dr\.|Dr)?[ ]?([^ ]*)[ ]?(.*)/i';
  preg_match($p, $n, $m);
  $f = $m[2];
  $l = $m[3];
  echo " ".$f. " " .$l;
  echo "<br /><br />";

  $u = "UPDATE dental_users SET first_name = '".mysqli_real_escape_string($con, $f)."',
		last_name = '".mysqli_real_escape_string($con, $l)."'
		WHERE userid='".mysqli_real_escape_string($con, $r['userid'])."'
		";
  //mysqli_query($con, $u);



}


?>
