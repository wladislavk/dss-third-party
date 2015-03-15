<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include "includes/top.htm";

	$ins_sql = "insert into dental_forms set docid='".$_SESSION['docid']."', patientid = '".s_for($_GET["pid"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";

	$ins_id = $db->getInsertId($ins_sql);
?>

	<script type="text/javascript">
		window.location = "q_page1.php?pid=<?php echo $_GET["pid"];?>&fid=<?php echo $ins_id;?>";
	</script>

<?php include "includes/bottom.htm"; ?>
