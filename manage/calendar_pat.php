<?php 
//session_start();
//require_once 'admin/includes/main_include.php';

include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
?>
<div style="clear: both">
<span class="admin_head">
	Calendar
</span>

<br />
<div align="center" class="red">
	<b><? if(!empty($_GET['msg'])) {echo $_GET['msg'];} ?></b>
</div>
<table>
	<tr>
		<th>Start</th>
		<th>End</th>
		<th>Title</th>
		<th>Type</th>
		<th>Action</th>
	</tr>
		<?php
		//$sql = "SELECT * from dental_calendar WHERE docid='".$_SESSION['docid']." order by id asc'";
		$sql = "SELECT dc.*, dp.*, dt.name as etype from dental_calendar as dc left join dental_patients as dp on dc.patientid = dp.patientid inner join dental_appt_types as dt on dc.category = dt.classname WHERE dc.docid='".$_SESSION['docid']."' and dt.docid='".$_SESSION['docid']."' AND dc.patientid='".mysql_real_escape_string($_GET['pid'])."' order by dc.id asc";
		$q = mysql_query($sql);
		while($r = mysql_fetch_assoc($q)){
			?><tr>
				<td><?= date('m/d/Y H:i', strtotime($r['start_date'])); ?></td>
				<td><?= date('m/d/Y H:i', strtotime($r['end_date'])); ?></td>
				<td><?= str_replace("\n", " ", addslashes($r['description'])); ?></td>
				<td><?= $r['etype']; ?></td>
				<td><a href="calendar.php?eid=<?= $r['event_id'];?>">View</a></td>
			</tr>	
		<?php
		}
		?>
</table>
<div style="clear:both;"></div>
<br /><br />	
<? include "includes/bottom.htm";?>
