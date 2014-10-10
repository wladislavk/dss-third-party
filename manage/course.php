<?php
	include 'admin/includes/main_include.php';
	include 'includes/sescheck.php';

	$u_sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
	$u_r = $db->getRow($u_sql);

    //COOKIES FOR COURSE SITE
    $expire = time()+60*2;
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";		
	$val = substr( str_shuffle( $chars ), 0, 16 );
	$pass = hash('sha256', session_id());
	$user = $u_r['username']; 
	$md5_pass = md5($pass);
	if($_SERVER['HTTP_HOST']=='dentalsleepsolutions.com'){
		setcookie("dss_login_key", $val, $expire, "/", "dentalsleepsolutions.com", false);
	} else {
		setcookie("dss_login_key", $val, $expire, "/", "xforty.com", false);
	}

	$login_sql = "SELECT * FROM x40_dss_login WHERE user='".mysql_real_escape_string($user)."'";

	if($db->getNumberRows($login_sql)==0){
      $course_sql = "INSERT INTO x40_dss_login SET keyval1='".mysql_real_escape_string($val)."', keyval2='".mysql_real_escape_string($pass)."', user='".mysql_real_escape_string($user)."'";
 	  $db->query($course_sql);
	} else {
      $course_sql = "UPDATE x40_dss_login SET keyval1='".mysql_real_escape_string($val)."', keyval2='".mysql_real_escape_string($pass)."' WHERE user='".mysql_real_escape_string($user)."'";
      $db->query($course_sql);
	}
	$user_sql = "UPDATE users SET pass='".mysql_real_escape_string($md5_pass)."' WHERE name='".mysql_real_escape_string($user)."'";
	$db->query($user_sql);
?>

<?php if($_SERVER['HTTP_HOST']=='dentalsleepsolutions.com' || $_SERVER['HTTP_HOST']=='stage.dss-rh.xforty.com'){ ?>
		<script type="text/javascript">
			window.location='/course/autoauth';
		</script>
<?php } else { ?>
		<script type="text/javascript">
  			window.location='http://course.dss.xforty.com/drupal/autoauth';
  		</script>
<?php } ?>