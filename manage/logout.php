<?php namespace Ds3\Legacy; ?><?php
	include "admin/includes/main_include.php";

	$login_up_sql = "update dental_login set logout_date = now() where loginid='".$_SESSION['loginid']."'";
	
	$db->query($login_up_sql);
	if(isset($_SESSION['userid'])){
		$_SESSION['userid'] = '';
	}
?>
	<script type="text/javascript">
		alert("Logout Successfully");
		window.location = "login.php";
	</script>
<?php
	die();
?>
