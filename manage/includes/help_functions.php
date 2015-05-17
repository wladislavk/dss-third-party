<?php namespace Ds3\Libraries\Legacy; ?><?php
    function help_user_update($id, $help_con)
    {
        //return true; //temp work around until fully setup
        $db = new Db();

        $sql = "SELECT * FROM dental_users WHERE userid='".mysqli_real_escape_string($GLOBALS['con'], $id)."'";

        $r = $db->getRow($sql);
        $help_id = $r['help_id'];
        $docid = ($r['docid']!=0)?$r['docid']:$r['userid'];

        $loc_sql = "SELECT * from dental_locations WHERE docid='".mysqli_real_escape_string($GLOBALS['con'], $docid)."' order by default_location DESC limit 1";

        $loc = $db->getRow($loc_sql);
        $address = $loc['address']." ".$loc['city'].", ".$loc['state']." ".$loc['zip'];
        if(empty($help_id)){
            $help_sql = "INSERT INTO help_wp.wp_users 
                		(user_login, 
                		user_nicename,
                		user_email,
                		display_name) VALUES 
                		('".mysqli_real_escape_string($GLOBALS['con'], $r['username'])."', 
                		'".mysqli_real_escape_string($GLOBALS['con'], $r['username'])."',
                		'".mysqli_real_escape_string($GLOBALS['con'], $r['email'])."',
                		'".mysqli_real_escape_string($GLOBALS['con'], (!empty($r['firstname']) ? $r['firstname'] : '').' '.(!empty($r['lastname']) ? $r['lastname'] : ''))."')";

            $help_id = $db->getInsertId($help_sql);  
            //USER ROLES
            //remove previous roles
        	$del_role_sql = "delete from help_wp.wp_usermeta where user_id=".mysqli_real_escape_string($GLOBALS['con'], $help_id)." AND meta_key = 'wp_capabilities'";
        	
            $db->query($del_role_sql);    
            $role_sql = "insert into help_wp.wp_usermeta (user_id, meta_key, meta_value) values (".mysqli_real_escape_string($GLOBALS['con'], $help_id).", 'wp_capabilities', 'a:1:{s:10:\"subscriber\";b:1;}');";
            
            $db->query($role_sql);
            $u_sql = "UPDATE dental_users SET help_id='".mysqli_real_escape_string($GLOBALS['con'], $help_id)."' WHERE userid='".mysqli_real_escape_string($GLOBALS['con'], $id)."'";
            
            $db->query($u_sql);
        } else {
            $help_sql = "UPDATE help_wp.wp_users SET
                        user_login = '".mysqli_real_escape_string($GLOBALS['con'], $r['username'])."', 
    		            user_nicename = '".mysqli_real_escape_string($GLOBALS['con'], $r['username'])."',
                        user_email = '".mysqli_real_escape_string($GLOBALS['con'], $r['email'])."',
                		display_name = '".mysqli_real_escape_string($GLOBALS['con'], $r['first_name'].' '.$r['last_name'])."'
                		where ID = '".mysqli_real_escape_string($GLOBALS['con'], $help_id)."'";

            $help_q = $db->query($help_sql);
        }
    }

    function help_user_delete($id, $help_con)
    {
        $db = new Db();

        $sql = "SELECT * FROM dental_users WHERE userid='".mysqli_real_escape_string($GLOBALS['con'], $id)."'";
        
        $r = $db->getRow($sql);
        $profile_sql = "DELETE FROM help_wp.wp_users WHERE ID = '".mysqli_real_escape_string($GLOBALS['con'], $r['edx_id'])."'";
        $db->query($profile_sql);
    }
?>
