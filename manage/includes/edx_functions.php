<?php
function edx_user_update($id, $edx_con){
  $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);

  $edx_id = $r['edx_id'];
  $docid = ($r['docid']!=0)?$r['docid']:$r['userid'];

  $loc_sql = "SELECT * from dental_locations WHERE docid='".mysql_real_escape_string($docid)."' order by default_location DESC limit 1";
  $loc_q = mysql_query($loc_sql);
  $loc = mysql_fetch_assoc($loc_q);
  $address = $loc['address']." ".$loc['city'].", ".$loc['state']." ".$loc['zip'];

  if($edx_id == ''){
    $edx_sql = "INSERT INTO auth_user SET
	username = '".mysql_real_escape_string($r['username'])."',
	first_name = '".mysql_real_escape_string($r['first_name'])."',
        last_name = '".mysql_real_escape_string($r['last_name'])."', 
        email = '".mysql_real_escape_string($r['email'])."', 
        password = '".mysql_real_escape_string(sha1($r['username'].'ed&$s8e'.$r['email'].rand()))."', 
        is_active  = 1, 
        date_joined = now()";
    $edx_q = mysql_query($edx_sql, $edx_con);
    $edx_id = mysql_insert_id($edx_con);
    $u_sql = "UPDATE dental_users SET edx_id='".mysql_real_escape_string($edx_id)."' WHERE userid='".mysql_real_escape_string($id)."'";
    mysql_query($u_sql);
	
    $profile_sql = "INSERT INTO auth_userprofile SET
	user_id = '".mysql_real_escape_string($edx_id)."',
        name = '".mysql_real_escape_string($r['first_name'].' '.$r['last_name'])."',
        location = '".mysql_real_escape_string($loc['location'])."',
        mailing_address = '".mysql_real_escape_string($address)."',
	allow_certificate = 1,
        docid = '".mysql_real_escape_string($docid)."'";
    mysql_query($profile_sql, $edx_con);
  }else{
    $edx_sql = "UPDATE auth_user SET
        username = '".mysql_real_escape_string($r['username'])."',
        first_name = '".mysql_real_escape_string($r['first_name'])."',
        last_name = '".mysql_real_escape_string($r['last_name'])."', 
        email = '".mysql_real_escape_string($r['email'])."' 
	WHERE id='".mysql_real_escape_string($edx_id)."'";
    $edx_q = mysql_query($edx_sql, $edx_con);
    $profile_sql = "UPDATE auth_userprofile SET
        user_id = '".mysql_real_escape_string($edx_id)."',
        name = '".mysql_real_escape_string($r['first_name'].' '.$r['last_name'])."',
        location = '".mysql_real_escape_string($loc['location'])."',
        mailing_address = '".mysql_real_escape_string($address)."',
        docid = '".mysql_real_escape_string($docid)."'
	WHERE user_id='".mysql_real_escape_string($edx_id)."'";
    mysql_query($profile_sql, $edx_con);
  }


}


function edx_user_delete($id, $edx_con){
  $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  $profile_sql = "DELETE FROM auth_userprofile WHERE user_id = '".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($profile_sql, $edx_con);
  $edx_sql = "DELETE FROM auth_user WHERE id='".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($edx_sql, $edx_con);
  $profile_sql = "DELETE FROM auth_userprofile WHERE user_id = '".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($profile_sql, $edx_con);
}

?>
