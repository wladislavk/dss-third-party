<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('../admin/includes/main_include.php');
	include_once('../includes/constants.inc');
	include("../includes/sescheck.php");
	include_once('../includes/general_functions.php');
?>
	<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<?php
	if(isset($_REQUEST['submit'])) {
		$sqlex = "update dental_flow_pg2_info set delay_reason='".mysqli_real_escape_string($con,$_REQUEST['delay_reason'])."' where id='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
		$qex = $db->query($sqlex);
?>
		<script type="text/javascript">
			parent.updateDelayReason('<?php echo  $_GET['id']; ?>', '<?php echo  $_REQUEST['delay_reason']; ?>');
			parent.disablePopup1();
			<?php if($_REQUEST['delay_reason']=='other') { ?>
				parent.loadPopup('flowsheet_other_reason.php?ed=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid']; ?>&sid=5');
			<?php } ?>
		</script>
<?php } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="css/form.css" type="text/css" />
		<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
		<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
		<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="/manage/admin/script/validation.js"></script>
	</head>

	<body>
		<?php
		  $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
		  
		  $r = $db->getRow($s);
		?>

		<h2 style="margin-top:20px;">What is the reason for delaying treatment for <?php echo  $r['firstname']." ".$r['lastname']; ?>?</h2>

		<?php
			$sql = "select * from dental_flow_pg2_info where id='".(!empty($_GET['id']) ? $_GET['id'] : '')."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";

			$r = $db->getRow($sql);
			$sid = st($r['segmentid']);
		?>
		<form action="#" method="post">
		    Reason
			<select name="delay_reason" width="250px">
				<option value="insurance">Insurance</option>
				<option value="dental work">Dental Work</option>
				<option value="deciding">Deciding</option>
				<option value="sleep study">Sleep Study</option>
				<option value="other">Other</option>
			</select>
		    <input type="submit" name="submit" value="Submit" />
		</form>
	</body>
</html>
