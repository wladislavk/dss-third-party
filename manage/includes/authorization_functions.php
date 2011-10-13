<?php

function authorize($u, $p, $l){
  return true;  //bypass for function until it is determined how this should work.
  if($_SESSION['user_access']==$l){
    return true;
  }else{
    $auth_sql = "SELECT userid FROM dental_users 
                WHERE 
                        username='".mysql_real_escape_string($u)."' AND 
                        password='".mysql_real_escape_string($p)."' AND
                        user_access=".DSS_USER_TYPE_ADMIN;
    $auth_q = mysql_query($auth_sql);
    if(mysql_num_rows($auth_q)>0){
      return true;
    }
  }
  return false;
}

?>
