<?php namespace Ds3\Libraries\Legacy; ?><?php

function authorize($u, $p, $l){
  $db = new Db();
  $con = $GLOBALS['con'];
  return true;
  if($_SESSION['user_access']==$l){
    return true;
  } else {
    $auth_sql = "SELECT userid FROM dental_users 
                 WHERE 
                 username='".mysqli_real_escape_string($con, $u)."' AND 
                 password='".mysqli_real_escape_string($con, $p)."' AND
                 user_access=".DSS_USER_TYPE_ADMIN;

    if($db->getNumberRows($auth_sql) > 0){
      return true;
    }
  }
  return false;
}

?>
