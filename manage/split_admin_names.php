<?php

include 'admin/includes/config.php';

$s = "SELECT adminid, name FROM admin";
$q = mysql_query($s);
while($r = mysql_fetch_assoc($q)){

  echo $r['name'];
  echo "<br />";

  $n = $r['name'];
  $p = '/(Dr\.|Dr)?[ ]?([^ ]*)[ ]?(.*)/i';
  preg_match($p, $n, $m);
  $f = $m[2];
  $l = $m[3];
  echo " ".$f. " " .$l;
  echo "<br /><br />";

  $u = "UPDATE admin SET first_name = '".mysqli_real_escape_string($con, $f)."',
		last_name = '".mysqli_real_escape_string($con, $l)."'
		WHERE adminid='".mysqli_real_escape_string($con, $r['adminid'])."'
		";
  //mysql_query($u);



}


?>
