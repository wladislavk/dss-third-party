<?php 
//session_start();
//require_once 'admin/includes/main_include.php';

include "includes/top.htm";
require_once('includes/constants.inc');
require_once('includes/formatters.php');
?>
<div style="clear: both">
<br />
<span class="admin_head">
	All Calendar Events for <?= $thename; ?>
</span>
<a href="manage_flowsheet3.php?pid=<?=$_GET['pid'];?>&addtopat=1" class="button" style="float:right; margin-right:20px;">View Tracker</a>
<br />
<div align="center" class="red">
	<b><? if(!empty($_GET['msg'])) {echo $_GET['msg'];} ?></b>
</div>
<br />
<table width="90%" style="margin-left:5%;">
	<tr class="tr_bg_h">
		<th class="col_head">Start</th>
		<th class="col_head">End</th>
		<th class="col_head">Title</th>
		<th class="col_head">Type</th>
		<th class="col_head">View in Scheduler</th>
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
