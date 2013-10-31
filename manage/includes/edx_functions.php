<?php

function edx_user_update($id){
//return true; //temp workaround until fully setup
  $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);

  $edx_id = $r['edx_id'];
  $docid = ($r['docid']!=0)?$r['docid']:$r['userid'];

  $loc_sql = "SELECT * from dental_locations WHERE docid='".mysql_real_escape_string($docid)."' order by default_location DESC limit 1";
  $loc_q = mysql_query($loc_sql);
  $loc = mysql_fetch_assoc($loc_q);
  $address = $loc['address']." ".$loc['city'].", ".$loc['state']." ".$loc['zip'];

  if($edx_id == '' || $edx_id == '0'){
    $name = $r['first_name']. ' '.$r['last_name'];
    $pass = sha1($r['username'].'ed&$s8e'.$r['email'].rand());
error_log('sh ../edxNewUser.sh '.$r['username'].' '.$r['email'].' 123abc "'.$name.'"');
    $edx_id = shell_exec('sh ../edxNewUser.sh '.$r['username'].' '.$r['email'].' 123abc "'.$name.'"');
error_log($edx_id."XXXXXXXXXXXXXXXXXXXXX");
    $u_sql = "UPDATE dental_users SET edx_id='".mysql_real_escape_string($edx_id)."' WHERE userid='".mysql_real_escape_string($id)."'";
    mysql_query($u_sql);
  }else{
    $name = $r['first_name']. ' '.$r['last_name'];
    $pass = sha1($r['username'].'ed&$s8e'.$r['email'].rand());
    $edx_id = shell_exec('sh ../edxEditUser.sh '.$edx_id.' "'.$r['username'].'" '.$r['email'].' '.$pass.' "'.$name.'"');
    error_log($edx_id."EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE");
  }


}


function edx_user_delete($id, $edx_con){
  //WEB SERVICE NEEDS COMPLETED
  /*
  $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  $profile_sql = "DELETE FROM auth_userprofile WHERE user_id = '".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($profile_sql, $edx_con);
  $edx_sql = "DELETE FROM auth_user WHERE id='".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($edx_sql, $edx_con);
  $profile_sql = "DELETE FROM auth_userprofile WHERE user_id = '".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($profile_sql, $edx_con);
  */
}

?>
