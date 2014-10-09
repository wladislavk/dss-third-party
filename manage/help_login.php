<?php
	include 'admin/includes/main_include.php';
	include 'includes/sescheck.php';

	$username = $_SESSION['username'];
	$key = sha1(rand().'*&Tuvt7X'.$_SESSION['username'].rand());
	$pass = sha1($_SESSION['username'].'HNb%5#fc'.rand());

	$del_sql = "delete from help_wp.dss_wp_signon where user_name = '".mysql_real_escape_string($username)."'";
	$db->query($del_sql, $help_con);

	$login_sql = "insert into help_wp.dss_wp_signon (user_name, user_temp_key) values ('".$username."', '".$key."');";
	$db->query($login_sql, $help_con);

	if($_SERVER['HTTP_HOST']=='www.dentalsleepsolutions.com' || $_SERVER['HTTP_HOST']=='dentalsleepsolutions.com'){
?>
		<script type="text/javascript">
		 	window.location = 'http://help.dentalsleepsolutions.com/?un=<?php echo  $username; ?>&dsswpkey=<?php echo  $key; ?>&dssup=<?php echo  $pass; ?>';
		</script>
<?php
    } else {
?>
	   	<script type="text/javascript">
	  		window.location = 'http://help.dss-rh.xforty.com/?un=<?php echo  $username; ?>&dsswpkey=<?php echo  $key; ?>&dssup=<?php echo  $pass; ?>';
	 	</script>
<?php
    }
?>