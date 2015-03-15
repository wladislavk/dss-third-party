<?php namespace Ds3\Libraries\Legacy; ?><?php

include 'admin/includes/config.php';

$s = "SELECT userid, name FROM dental_users";
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

  $u = "UPDATE dental_users SET first_name = '".mysql_real_escape_string($f)."',
		last_name = '".mysql_real_escape_string($l)."'
		WHERE userid='".mysql_real_escape_string($r['userid'])."'
		";
  //mysql_query($u);



}


?>
