<?php 
include "includes/top.htm";

$ins_sql = "insert into dental_forms set docid='".$_SESSION['docid']."', patientid = '".s_for($_GET["pid"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
mysql_query($ins_sql) or die($ins_sql . " | ".mysql_error());

$ins_id = mysql_insert_id();
?>

<script type="text/javascript">
	window.location = "q_page1.php?pid=<?=$_GET["pid"];?>&fid=<?=$ins_id;?>";
</script>

<?php 
include "includes/bottom.htm";?>