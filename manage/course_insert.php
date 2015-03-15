<?php namespace Ds3\Libraries\Legacy; ?><?php
include 'admin/includes/main_include.php';
if(false){
$sql = "SELECT * FROM dental_users WHERE username!=''";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){

                          $course_sql = "INSERT INTO users set
                                        name = '".mysql_real_escape_string($r["username"])."',
                                        mail = '".mysql_real_escape_string($r["email"])."',
                                        status = '1'";
                        mysql_query($course_sql, $course_con) or die("u - " . mysql_error($course_con));
                        $course_uid = mysql_insert_id($course_con);
			echo $course_uid."<br />";
                        $roles_sql = "INSERT INTO users_roles SET
                                        uid = '".mysql_real_escape_string($course_uid)."',
                                        rid = '3'";
                        mysql_query($roles_sql, $course_con) or die("role - " . mysql_error($course_con));
                        $rev_sql = "INSERT INTO node_revisions (title) VALUES ('dss profile')";
                        mysql_query($rev_sql, $course_con) or die("rev - " . mysql_error($course_con));
                        $vid = mysql_insert_id($course_con);
                        $profile_sql = "INSERT INTO node 
                                                (type, status, title, vid, uid)
                                        VALUES
                                                ('profile', 1, 'dss profile', '".$vid."', '".mysql_real_escape_string($course_uid)."')";
                        mysql_query($profile_sql, $course_con) or die($profile_sql ." | ".mysql_error($course_con));
                        $nid = mysql_insert_id($course_con);
                        $rev_sql = "UPDATE node_revisions SET nid=".$nid." WHERE vid=".$vid;
                        mysql_query($rev_sql, $course_con) or die("up - ".mysql_error($course_con));;
                        if($r['docid']==0){
                          $docid = $r['userid'];
                        }else{
                          $docid = $r['docid'];
                        }

			$docname_sql = "SELECT name from dental_users WHERE userid='".mysql_real_escape_string($docid)."'";
                        $docname_q = mysql_query($docname_sql);
                        $docname_r = mysql_fetch_assoc($docname_q);
                        $docname = $docname_r['name'];
                        $co_sql = "SELECT c.id, c.name from companies c
                                        JOIN dental_user_company uc ON c.id = uc.companyid
                                        JOIN dental_users u ON u.userid = uc.userid
                                         WHERE u.userid='".mysql_real_escape_string($docid)."'";
                        $co_q = mysql_query($co_sql);
                        $co_r = mysql_fetch_assoc($co_q);
                        $cid = $co_r['id'];
                        $cname = $co_r['name'];

                        $ctp_sql = "INSERT INTO content_type_profile
                                                (vid,
                                                         nid,
                                                         field_companyid_value,
                                                         field_companyname_value,
                                                         field_docid_value,
                                                         field_docname_value,
                                                         field_dssusername_value,
                                                         field_dssuid_value)
                                        VALUES
                                                ('".mysql_real_escape_string($vid)."',
                                                        '".mysql_real_escape_string($nid)."',
                                                        '".mysql_real_escape_string($cid)."',
                                                        '".mysql_real_escape_string($cname)."',
                                                        '".mysql_real_escape_string($docid)."',
                                                        '".mysql_real_escape_string($docname)."',
                                                        '".mysql_real_escape_string($r['name'])."',
                                                        '".mysql_real_escape_string($r['userid'])."')";
                        mysql_query($ctp_sql, $course_con) or die(mysql_error($course_con));

//echo $ctp_sql;
}

}

//mysql_query("DELETE FROM users where uid>10;", $course_con);


$u = 'staff1e';
		$user_sql = "SELECT * FROM users";
		$q = mysql_query($user_sql, $course_con);
		while($row = mysql_fetch_assoc($q)){
			print_r($row);
			$uid=$row['uid'];
		}

		?><br /><br /><?php
                $user_sql = "SELECT * FROM x40_dss_login where user='".$u."'";
                $q = mysql_query($user_sql, $course_con);
                while($row = mysql_fetch_assoc($q)){
                        print_r($row);
                }
 
		?><br /><br /><?php
                $user_sql = "SELECT * FROM users_roles";
                $q = mysql_query($user_sql, $course_con) or die(mysql_error());
                while($row = mysql_fetch_assoc($q)){
                        print_r($row);
                }

                ?><br /><br /><?php
                $user_sql = "SELECT * FROM node where type='profile' AND uid=".$uid;
                $q = mysql_query($user_sql, $course_con) or die(mysql_error());
                while($row = mysql_fetch_assoc($q)){
                        print_r($row);
			$nid = $row['nid'];
			$vid = $row['vid'];
                }

                ?><br /><br /><?php
		$user_sql = "SELECT * FROM content_type_profile ";
		//echo $user_sql;
                $q = mysql_query($user_sql, $course_con) or die(mysql_error($course_con));
                while($row = mysql_fetch_assoc($q)){
                        print_r($row);
                }

?>
