<?php
	include 'admin/includes/main_include.php';
	include("includes/sescheck.php");

	$u_sql = "SELECT edx_id FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $_SESSION['userid'])."'";

	$u = $db->getRow($u_sql);
	$userid = $u['edx_id'];
	$ses = shell_exec('sh edx_scripts/edxScript.sh '.urlencode($userid));
	$expire = time() + 60 * 60 * 2;
	if($_SERVER['HTTP_HOST']=='www.dentalsleepsolutions.com' || $_SERVER['HTTP_HOST']=='dentalsleepsolutions.com'){
		setcookie("edxloggin", "true", $expire, "/", "dentalsleepsolutions.com", false);
		setcookie("sessionid", $ses, $expire, "/", "dentalsleepsolutions.com", false);
	} else {
		setcookie("edxloggin", "true", $expire, "/", "xforty.com", false);
		setcookie("sessionid", $ses, $expire, "/", "xforty.com", false);
	}
?>

<?php if($_SERVER['HTTP_HOST']=='www.dentalsleepsolutions.com' || $_SERVER['HTTP_HOST']=='dentalsleepsolutions.com') { ?>
	<script type="text/javascript">
		window.location = 'http://education.dentalsleepsolutions.com/dashboard';
	</script>
<?php } elseif($_SERVER['HTTP_HOST']=='preprod.dss.xforty.com' || $_SERVER['HTTP_HOST']=='staging.dss-rh.xforty.com') {	?>
	<script type="text/javascript">
		window.location = 'http://preprod.edx.dss.xforty.com/dashboard';
	</script>
<?php } else { ?>
	<script type="text/javascript">
		window.location = 'http://staging1.edx.dss.xforty.com/dashboard';
	</script>
<?php } ?>