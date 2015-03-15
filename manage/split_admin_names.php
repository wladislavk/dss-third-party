<?php namespace Ds3\Legacy; ?><?php

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

  $u = "UPDATE admin SET first_name = '".mysql_real_escape_string($f)."',
		last_name = '".mysql_real_escape_string($l)."'
		WHERE adminid='".mysql_real_escape_string($r['adminid'])."'
		";
  //mysql_query($u);



}


?>
