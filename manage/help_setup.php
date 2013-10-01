<?php
  include 'admin/includes/main_include.php';
  include 'includes/help_functions.php';

  $u_sql = "SELECT * FROM dental_users";
  $u_q = mysql_query($u_sql);
  while($u = mysql_fetch_assoc($u_q)){ 
    echo $u['username']."|".$u['help_id']."|"."<br />";
    help_user_update($u['userid'], $help_con);

  }

?>
