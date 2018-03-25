<!--
<?php
	if(isset($_REQUEST['submit'])) {
		$sqlex = "update dental_flow_pg2_info set noncomp_reason='".mysqli_real_escape_string($con,$_REQUEST['noncomp_reason'])."' where id='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
		$qex = $db->query($sqlex);
?>
<script type="text/javascript">
  parent.updateNoncompReason('<?php echo  $_GET['id']; ?>', '<?php echo  $_REQUEST['noncomp_reason']; ?>');
  parent.disablePopup1();
  <?php if($_REQUEST['noncomp_reason']=='other') { ?>
    parent.loadPopup('flowsheet_other_reason.php?ed=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid']; ?>&sid=9');
  <?php } ?>
</script>
<?php } ?>

<?php
		  $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";

		  $r = $db->getRow($s);
?>

<h2 style="margin-top:20px;">What is the reason <?php echo  $r['firstname']." ".$r['lastname']; ?> is non-compliant?</h2>

<?php
			$sql = "select * from dental_flow_pg2_info where id='".(!empty($_GET['id']) ? $_GET['id'] : '')."' AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";

			$r = $db->getRow($sql);
$sid = st($r['segmentid']);
?>
<form action="#" method="post">
  Reason
  <select name="noncomp_reason" style="width:250px;">
    <option value="pain/discomfort">Pain/Discomfort</option>
    <option value="lost device">Lost Device</option>
    <option value="device not working">Device Not Working</option>
    <option value="other">Other</option>
  </select>
  <input type="submit" name="submit" value="Submit" />
</form>
-->
