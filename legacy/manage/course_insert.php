<?php namespace Ds3\Libraries\Legacy; ?><?php
include 'admin/includes/main_include.php';
if(false){
$sql = "SELECT * FROM dental_users WHERE username!=''";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){

                          $course_sql = "INSERT INTO users set
                                        name = '".mysqli_real_escape_string($con, $r["username"])."',
                                        mail = '".mysqli_real_escape_string($con, $r["email"])."',
                                        status = '1'";
                        mysqli_query($con, $course_sql, $course_con) or trigger_error("u - " . mysqli_error($con$course_con), E_USER_ERROR);
                        $course_uid = mysqli_insert_id($con$course_con);
			echo $course_uid."<br />";
                        $roles_sql = "INSERT INTO users_roles SET
                                        uid = '".mysqli_real_escape_string($con, $course_uid)."',
                                        rid = '3'";
                        mysqli_query($con, $roles_sql, $course_con) or trigger_error("role - " . mysqli_error($con$course_con), E_USER_ERROR);
                        $rev_sql = "INSERT INTO node_revisions (title) VALUES ('dss profile')";
                        mysqli_query($con, $rev_sql, $course_con) or trigger_error("rev - " . mysqli_error($con$course_con), E_USER_ERROR);
                        $vid = mysqli_insert_id($con$course_con);
                        $profile_sql = "INSERT INTO node 
                                                (type, status, title, vid, uid)
                                        VALUES
                                                ('profile', 1, 'dss profile', '".$vid."', '".mysqli_real_escape_string($con, $course_uid)."')";
                        mysqli_query($con, $profile_sql, $course_con) or trigger_error($profile_sql ." | ".mysqli_error($con$course_con), E_USER_ERROR);
                        $nid = mysqli_insert_id($con$course_con);
                        $rev_sql = "UPDATE node_revisions SET nid=".$nid." WHERE vid=".$vid;
                        mysqli_query($con, $rev_sql, $course_con) or trigger_error("up - ".mysqli_error($con$course_con), E_USER_ERROR);;
                        if($r['docid']==0){
                          $docid = $r['userid'];
                        }else{
                          $docid = $r['docid'];
                        }

			$docname_sql = "SELECT name from dental_users WHERE userid='".mysqli_real_escape_string($con, $docid)."'";
                        $docname_q = mysqli_query($con, $docname_sql);
                        $docname_r = mysqli_fetch_assoc($docname_q);
                        $docname = $docname_r['name'];
                        $co_sql = "SELECT c.id, c.name from companies c
                                        JOIN dental_user_company uc ON c.id = uc.companyid
                                        JOIN dental_users u ON u.userid = uc.userid
                                         WHERE u.userid='".mysqli_real_escape_string($con, $docid)."'";
                        $co_q = mysqli_query($con, $co_sql);
                        $co_r = mysqli_fetch_assoc($co_q);
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
                                                ('".mysqli_real_escape_string($con, $vid)."',
                                                        '".mysqli_real_escape_string($con, $nid)."',
                                                        '".mysqli_real_escape_string($con, $cid)."',
                                                        '".mysqli_real_escape_string($con, $cname)."',
                                                        '".mysqli_real_escape_string($con, $docid)."',
                                                        '".mysqli_real_escape_string($con, $docname)."',
                                                        '".mysqli_real_escape_string($con, $r['name'])."',
                                                        '".mysqli_real_escape_string($con, $r['userid'])."')";
                        mysqli_query($con, $ctp_sql, $course_con) or trigger_error(mysqli_error($con$course_con), E_USER_ERROR);

//echo $ctp_sql;
}

}

//mysqli_query($con, "DELETE FROM users where uid>10;", $course_con);


$u = 'staff1e';
		$user_sql = "SELECT * FROM users";
		$q = mysqli_query($con, $user_sql, $course_con);
		while($row = mysqli_fetch_assoc($q)){
			print_r($row);
			$uid=$row['uid'];
		}

		?><br /><br /><?php
                $user_sql = "SELECT * FROM x40_dss_login where user='".$u."'";
                $q = mysqli_query($con, $user_sql, $course_con);
                while($row = mysqli_fetch_assoc($q)){
                        print_r($row);
                }
 
		?><br /><br /><?php
                $user_sql = "SELECT * FROM users_roles";
                $q = mysqli_query($con, $user_sql, $course_con) or trigger_error(mysqli_error($con), E_USER_ERROR);
                while($row = mysqli_fetch_assoc($q)){
                        print_r($row);
                }

                ?><br /><br /><?php
                $user_sql = "SELECT * FROM node where type='profile' AND uid=".$uid;
                $q = mysqli_query($con, $user_sql, $course_con) or trigger_error(mysqli_error($con), E_USER_ERROR);
                while($row = mysqli_fetch_assoc($q)){
                        print_r($row);
			$nid = $row['nid'];
			$vid = $row['vid'];
                }

                ?><br /><br /><?php
		$user_sql = "SELECT * FROM content_type_profile ";
		//echo $user_sql;
                $q = mysqli_query($con, $user_sql, $course_con) or trigger_error(mysqli_error($con$course_con), E_USER_ERROR);
                while($row = mysqli_fetch_assoc($q)){
                        print_r($row);
                }

?>
