<?php
session_start();
include 'admin/includes/config.php';
include("includes/sescheck.php");

$u_sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$u_q = mysql_query($u_sql);
$u_r = mysql_fetch_assoc($u_q);

                //COOKIES FOR COURSE SITE
                $expire=time()+60*2;
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";		
		$val = substr( str_shuffle( $chars ), 0, 16 );
		$pass = hash('sha256', session_id());
		$user = $u_r['username']; 
		$md5_pass = md5($pass);
                setcookie("dss_login_key", $val, $expire, "/", "xforty.com", false);


 
		$login_sql = "SELECT * FROM x40_dss_login WHERE user='".mysql_real_escape_string($user)."'";
                $login_q = mysql_query($login_sql, $course_con);
		if(mysql_num_rows($login_q)==0){
                  $course_sql = "INSERT INTO x40_dss_login SET keyval1='".mysql_real_escape_string($val)."', keyval2='".mysql_real_escape_string($pass)."', user='".mysql_real_escape_string($user)."'";
	 	  mysql_query($course_sql, $course_con);
		}else{
                  $course_sql = "UPDATE x40_dss_login SET keyval1='".mysql_real_escape_string($val)."', keyval2='".mysql_real_escape_string($pass)."' WHERE user='".mysql_real_escape_string($user)."'";
                  mysql_query($course_sql, $course_con);
		}
		//$user_sql = "INSERT INTO users SET pass='".mysql_real_escape_string($md5_pass)."', name='".mysql_real_escape_string($user)."', status='1'";
		$user_sql = "UPDATE users SET pass='".mysql_real_escape_string($md5_pass)."' WHERE name='".mysql_real_escape_string($user)."'";
		mysql_query($user_sql, $course_con) or die($user_sql." | ".mysql_error());
?>
<script type="text/javascript">
  window.location='/course/autoauth';
</script>
