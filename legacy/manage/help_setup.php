<?php namespace Ds3\Libraries\Legacy; ?><?php
  include 'admin/includes/main_include.php';
  include 'includes/help_functions.php';

  $u_sql = "SELECT * FROM dental_users";
  
  $u_q = $db->getResults($u_sql);
  if (!empty($u_q)) foreach ($u_q as $u) { 
    echo $u['username']."|".$u['help_id']."|"."<br />";
    help_user_update($u['userid'], (!empty($help_con) ? $help_con : ''));
  }
?>
