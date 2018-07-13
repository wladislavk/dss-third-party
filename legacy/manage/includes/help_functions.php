<?php
namespace Ds3\Libraries\Legacy;

function help_user_update($id)
{
    if (getenv('DOCKER_USED')) {
        return;
    }

    $db = new Db();

    $sql = "SELECT * FROM dental_users WHERE userid='".mysqli_real_escape_string($GLOBALS['con'], $id)."'";

    $r = $db->getRow($sql);
    $help_id = $r['help_id'];

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
        $db->query($help_sql);
    }
}
