<?php namespace Ds3\Legacy; ?><?php
  include 'includes/main_include.php';
  include 'includes/edx_functions.php';

  $u_sql = "SELECT * FROM dental_users";
  $u_q = mysql_query($u_sql);
  while($u = mysql_fetch_assoc($u_q)){ 
    echo $u['username']."|".$u['edx_id']."|"."<br />";
    //edx_user_update($u['userid']);



  }

?>
