<?php namespace Ds3\Libraries\Legacy; ?><?php
  include 'includes/main_include.php';
  include 'includes/edx_functions.php';

  $u_sql = "SELECT * FROM dental_users";
  $u_q = mysqli_query($con, $u_sql);
  while($u = mysqli_fetch_assoc($u_q)){ 
    echo $u['username']."|".$u['edx_id']."|"."<br />";
    //edx_user_update($u['userid']);



  }

?>
