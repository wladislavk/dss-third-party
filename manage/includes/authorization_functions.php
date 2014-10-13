<?php

function authorize($u, $p, $l){
  return true;
  if($_SESSION['user_access']==$l){
    return true;
  } else {
    $auth_sql = "SELECT userid FROM dental_users 
                 WHERE 
                 username='".mysql_real_escape_string($u)."' AND 
                 password='".mysql_real_escape_string($p)."' AND
                 user_access=".DSS_USER_TYPE_ADMIN;

    if($db->getNumberRows($auth_sql) > 0){
      return true;
    }
  }
  return false;
}

?>
