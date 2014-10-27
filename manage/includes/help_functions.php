<?php
    function help_user_update($id, $help_con)
    {
        //return true; //temp work around until fully setup
        $db = new Db();

        $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";

        $r = $db->getRow($sql);
        $help_id = $r['help_id'];
        $docid = ($r['docid']!=0)?$r['docid']:$r['userid'];

        $loc_sql = "SELECT * from dental_locations WHERE docid='".mysql_real_escape_string($docid)."' order by default_location DESC limit 1";

        $loc = $db->getRow($loc_sql);
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

            $help_id = $db->getInsertId($help_sql);  
            //USER ROLES
            //remove previous roles
        	$del_role_sql = "delete from wp_usermeta where userid=".mysql_real_escape_string($help_id)." AND meta_key = 'wp_capabilities'";
        	
            $db->query($del_role_sql);    
            $role_sql = "insert into wp_usermeta (user_id, meta_key, meta_value) values (".mysql_real_escape_string($help_id).", 'wp_capabilities', 'a:1:{s:10:\"subscriber\";b:1;}');";
            
            $db->query($role_sql);
            $u_sql = "UPDATE dental_users SET help_id='".mysql_real_escape_string($help_id)."' WHERE userid='".mysql_real_escape_string($id)."'";
            
            $db->query($u_sql);
        } else {
            $help_sql = "UPDATE help_wp.wp_users SET
                        user_login = '".mysql_real_escape_string($r['username'])."', 
    		            user_nicename = '".mysql_real_escape_string($r['username'])."',
                        user_email = '".mysql_real_escape_string($r['email'])."',
                		display_name = '".mysql_real_escape_string($r['first_name'].' '.$r['last_name'])."'
                		where ID = '".mysql_real_escape_string($help_id)."'";

            $help_q = $db->query($help_sql);
        }
    }

    function help_user_delete($id, $help_con)
    {
        $db = new Db();

        $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
        
        $r = $db->getRow($sql);
        $profile_sql = "DELETE FROM help_wp.wp_users WHERE ID = '".mysql_real_escape_string($r['edx_id'])."'";
        $db->query($profile_sql);
    }
?>