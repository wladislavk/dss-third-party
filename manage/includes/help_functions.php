<?php
function help_user_update($id, $help_con){
  $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);

  $help_id = $r['help_id'];
  $docid = ($r['docid']!=0)?$r['docid']:$r['userid'];

  $loc_sql = "SELECT * from dental_locations WHERE docid='".mysql_real_escape_string($docid)."' order by default_location DESC limit 1";
  $loc_q = mysql_query($loc_sql);
  $loc = mysql_fetch_assoc($loc_q);
  $address = $loc['address']." ".$loc['city'].", ".$loc['state']." ".$loc['zip'];

  if($help_id == '' || $help_id == '0'){
    $help_sql = "INSERT INTO help_wp.wp_users 
		(user_login, 
		user_nicename,
		user_email,
		display_name) VALUES 
		('".mysql_real_escape_string($r['username'])."', 
		'".mysql_real_escape_string($r['username'])."',
		'".mysql_real_escape_string($r['email'])."',
		'".mysql_real_escape_string($r['firstname'].' '.$r['lastname'])."')";
    $help_q = mysql_query($help_sql, $help_con) or die(mysql_error($help_con));
error_log($help_sql);
    $help_id = mysql_insert_id($help_con);
    

    //USER ROLES

      //remove previous roles
	$del_role_sql = "delete from wp_usermeta where userid=".mysql_real_escape_string($help_id)." AND meta_key = 'wp_capabilities'";
	mysql_query($del_role_sql);

    $role_sql = "insert into wp_usermeta (user_id, meta_key, meta_value) values (".mysql_real_escape_string($help_id).", 'wp_capabilities', 'a:1:{s:10:\"subscriber\";b:1;}');";
    mysql_query($role_sql);



    $u_sql = "UPDATE dental_users SET help_id='".mysql_real_escape_string($help_id)."' WHERE userid='".mysql_real_escape_string($id)."'";
    mysql_query($u_sql);
	
  }else{
    $help_sql = "UPDATE help_wp.wp_users SET
                user_login = '".mysql_real_escape_string($r['username'])."', 
		user_nicename = '".mysql_real_escape_string($r['username'])."',
                user_email = '".mysql_real_escape_string($r['email'])."',
		display_name = '".mysql_real_escape_string($r['first_name'].' '.$r['last_name'])."'
		where ID = '".mysql_real_escape_string($help_id)."'";
    $help_q = mysql_query($help_sql, $help_con);
  }


}


function help_user_delete($id, $help_con){
  $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  $profile_sql = "DELETE FROM help_wp.wp_users WHERE ID = '".mysql_real_escape_string($r['edx_id'])."'";
  mysql_query($profile_sql, $help_con);
}

?>
