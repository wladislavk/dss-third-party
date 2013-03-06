<?php include 'includes/top.htm';?>

<!--<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />-->
<!--<script src="admin/popup/popup2.js" type="text/javascript"></script>-->

<br />
<div>
 <table>
 <tr>
 <td valign="top" style="border-right:1px solid #00457c;width:290px;">

<div style="padding-left:10px; padding-right:10px; margin-right:5px;" id="formLeftC"> 
                




<?php




$adminmemo_check_sql = "SELECT * FROM memo_admin";
$adminmemo_check_qry = mysql_query($adminmemo_check_sql);
while($adminmemo_array = mysql_fetch_array($adminmemo_check_qry)){
if($adminmemo_array['memo'] != NULL || $adminmemo_array['memo'] != ''){

$todays_date = date("Y-m-d"); 
$exp_date = $adminmemo_array['off_date'];
$today = strtotime($todays_date);
$expiration_date = strtotime($exp_date);
if ($expiration_date > $today) {
	?>
	  
    <div style="color:#ff0000; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;"><span class="admin_head" style="color:#ff0000;"><em> Global Memo: </em></span></div>
	<br />
	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php

echo "". $adminmemo_array['memo'] . "<br />";
 
?>

    </td>
    
  </tr>
  </table>
  <br />
 <?php 
 } else {}
 }
 } ?>

  <div style="color:#00457c; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;"><span class="admin_head" style="color:#00457c;"><em> Todays Memo: </em></span></div>
	<br />
	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php 

$memouserid = $_SESSION['userid'];
$memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid}";
$memo_check_qry = mysql_query($memo_check_sql);
while($memo_array = mysql_fetch_array($memo_check_qry)){
if($memo_array != NULL || $memo_array != ''){
echo $memo_array['memo'] . "<br /><hr />";
}
}
?>

<a href="Javascript: ;" target="_blank" class="viewtable" title="EDIT" onclick="Javascript: loadPopup('memo.php'); getElementById('popupMemo').style.top = '200px'; return false;">Edit Memo</a>
    </td>
    
  </tr>
  </table>
  <br /> 
  <?php if($num_rejected_preauth>0){ ?>
  <a href="manage_vobs.php?status=<?= DSS_PREAUTH_REJECTED; ?>&viewed=0" class="notification bad_count"><?= $num_rejected_preauth; ?> Alerts</a>
  <?php } ?>

  <?php if($pending_letters > 0 && $use_letters){ ?>
  <a href="letters.php?status=pending" class="notification <?= ($pending_letters==0)?"good_count":"bad_count"; ?>"><?= $pending_letters;?> Letters</a>
  <?php } ?>

  <?php if($num_preauth > 0){ ?>
  <a href="manage_vobs.php?status=<?= DSS_PREAUTH_COMPLETE; ?>&viewed=0" class="notification <?= ($num_preauth==0)?"good_count":"great_count"; ?>"><?= $num_preauth;?> Verifications</a>
  <?php } ?>

<?php if($num_bounce !=0 ){?>
  <a href="manage_email_bounces.php" class="notification <?= ($num_bounce==0)?"good_count":"bad_count"; ?>"><?= $num_bounce;?> Email Bounces</a>
<?php } ?>

<?php if($num_unsigned !=0 ){?>
  <a href="manage_unsigned_notes.php" class="notification <?= ($num_unsigned==0)?"good_count":"bad_count"; ?>"><?= $num_unsigned;?> Unsigned Notes</a>
<?php } ?>

<!--
  <table width="260" border="0px" align="center" cellpadding="1" cellspacing="1">
  <tr><td valign="top"><h2>Letters (<?php echo $pending_letters; ?>)</h2></td></tr>
  <tr>
    <td style="border:1px solid;"><p><strong>You have <span class="blue"><?php echo $pending_letters; ?></span> letters to review.</strong></p>
      <p><strong>The oldest letter is <span class="red"><?php echo $oldest_letter; ?> day(s) old</span>.</strong></p> 
    </td></tr>
  </table>

  <br />

  <table width="260" border="0px" align="center" cellpadding="1" cellspacing="1">
  <tr><td valign="top"><h2>VOBs (<?php echo $num_pending_preauth; ?>/<?php echo $num_preauth; ?>)</h2></td></tr>
  <tr>
    <td style="border:1px solid;"><p><strong>You have <span class="blue"><?php echo $num_pending_preauth; ?></span> pending verification of benefits.</strong></p>
              <p><strong>You have <span class="blue"><?php echo $num_preauth; ?></span> new completed verification of benefits.</strong></p>
    </td></tr>
  </table>



  <br /><br />

 <?

$sqlddlist = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if(isset($_GET['sh'])){
if($_GET['sh'] != 2)
{
	$sqlddlist .= " and status = 1";
}
}
$sqlddlist .= " order by lastname, firstname";
$myddlist = mysql_query($sqlddlist);

?>
<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Elements:</font><br />
<FORM NAME="DropDown" ACTION="http://www.cgiforme.com/jumporama/cgi/jumporama.cgi" METHOD="post" >
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php
$sqlddlist2 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if(isset($_GET['sh'])){
if($_GET['sh'] != 2)
{
	$sqlddlist2 .= " and status = 1";
}
}
$sqlddlist2 .= " order by lastname, firstname";
$myddlist2 = mysql_query($sqlddlist2);
while($ddlistpname2 = (mysql_fetch_array($myddlist2))){
?>
<option value="manage_patient.php?pid=<?php echo $ddlistpname2['patientid']; ?>">
<?php echo $ddlistpname2['lastname'].", ".$ddlistpname2['firstname']." ".$ddlistpname2['middlename']; ?>
</option>
<?php  
}

?>                
</SELECT>
<br />

</FORM>






<div style="margin-top:25px;  width:100%;">&nbsp;</div> 
<hr />
<div style="margin-top:0px; width:100%;">&nbsp;</div> 




<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Flowsheet:</font><br />
<FORM NAME="DropDown">
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php

$sqlddlist3 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if(isset($_GET['sh'])){
if($_GET['sh'] != 2)
{
	$sqlddlist3 .= " and status = 1";
}
}
$sqlddlist3 .= " order by lastname, firstname";
$myddlist3 = mysql_query($sqlddlist3);
while($ddlistpname3 = (mysql_fetch_array($myddlist3))){
?>
<option value="manage_flowsheet3.php?pid=<?php echo $ddlistpname3['patientid']; ?>">
<?php echo $ddlistpname3['lastname'].", ".$ddlistpname3['firstname']." ".$ddlistpname3['middlename']; ?>
</option>
<?php  
}

?>                
</SELECT>
<br />

</FORM>  
  




<div style="margin-top:25px;  width:100%;">&nbsp;</div> 
<hr />
<div style="margin-top:0px; width:100%;">&nbsp;</div>  

 <?

$sqlddlist = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if(isset($_GET['sh'])){
if($_GET['sh'] != 2)
{
	$sqlddlist .= " and status = 1";
}
}
$sqlddlist .= " order by lastname, firstname";
$myddlist = mysql_query($sqlddlist);

?>
<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Summary Sheet:</font><br />
<FORM NAME="DropDown" ACTION="http://www.cgiforme.com/jumporama/cgi/jumporama.cgi" METHOD="post" >
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php
$sqlddlist2 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if(isset($_GET['sh'])){
if($_GET['sh'] != 2)
{
	$sqlddlist2 .= " and status = 1";
}
}
$sqlddlist2 .= " order by lastname, firstname";
$myddlist2 = mysql_query($sqlddlist2);
while($ddlistpname2 = (mysql_fetch_array($myddlist2))){
?>
<option value="dss_summ.php?pid=<?php echo $ddlistpname2['patientid']; ?>">
<?php echo $ddlistpname2['lastname'].", ".$ddlistpname2['firstname']." ".$ddlistpname2['middlename']; ?>
</option>
<?php  
}

?>                
</SELECT>
<br />

</FORM>

-->

<div class="task_menu index_task">
<h3>My Tasks</h3>

<?php
$od_q = mysql_query($od_sql);
if(mysql_num_rows($od_q)>0){
?>

<h4 style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>
<ul class="task_od_list">
<?php
while($od_r = mysql_fetch_assoc($od_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" style="float:left; " class="task_status" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?>
</div>
</li>
<?php
}
?>
</ul>
<?php
}

$tod_q = mysql_query($tod_sql);
if(mysql_num_rows($tod_q)>0){
?>


<h4 style="margin-bottom:0px;" class="task_tod_header">Today</h4>
<ul class="task_tod_list">
<?php
while($od_r = mysql_fetch_assoc($tod_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" style="float:left;" class="task_status" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php

}
?>
</ul>
<?php
}

$tom_q = mysql_query($tom_sql);
if(mysql_num_rows($tom_q)>0){
?>
<h4 style="margin-bottom:0px;" class="task_tom_header">Tomorrow</h4>
<ul class="task_tom_list">
<?php
while($od_r = mysql_fetch_assoc($tom_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" style="float:left;" class="task_status" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>


<?php
$tw_q = mysql_query($tw_sql);
if(mysql_num_rows($tw_q)>0){
?>
<h4 id="task_tw_header" class="task_tw_header">This Week</h4>
<ul id="task_tw_list">
<?php
while($od_r = mysql_fetch_assoc($tw_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>

<?php
$nw_q = mysql_query($nw_sql);
if(mysql_num_rows($nw_q)>0){
?>
<h4 id="task_nw_header" class="task_nw_header">Next Week</h4>
<ul id="task_nw_list">
<?php
while($od_r = mysql_fetch_assoc($nw_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>



<?php
$lat_q = mysql_query($lat_sql);
if(mysql_num_rows($lat_q)>0){
?>
<h4 id="task_lat_header" class="task_lat_header">Later</h4>
<ul id="task_lat_list">
<?php
while($od_r = mysql_fetch_assoc($lat_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;">
<?= date('M d', strtotime($od_r['due_date'])); ?>
-
<?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>
<br /><br />
<a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>

</div>



<div style="margin-top:25px;  width:100%;">&nbsp;</div> 
<hr />
<div style="margin-top:0px; width:100%;">&nbsp;</div>  





  
  
              
</div>
</td>

<td valign="top">
<div style="width:660px; float:right; margin-left:5px;">
 <table width="660" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" class="em_title">
			<? if($_SESSION['username'] <> '') {?>
				Welcome <?=$_SESSION['username'];?>
			<? }
			else
			{
			?>
				Welcome to <?=$sitename;?>
			<? }?>
		</td>
	</tr>
</table>


<br />
<br />

<? 
if($_SESSION['userid'] != '')
{
	$welcome_sql = "select * from dental_doc_welcome where status=1 and (docid = '' or docid like '%~".$_SESSION['docid']."~%') order by sortby";
	$welcome_my = mysql_query($welcome_sql) or die($welcome_sql." | ".mysql_error());
	
	while($welcome_myarray = mysql_fetch_array($welcome_my)) 
	{
		if(st($welcome_myarray['video_file']) != '')
		{?>
			<center>
			<a href="Javascript: ;" class="click" title="Welcome Video" onclick="Javascript: loadPopup('welcome_detail.php?v_f=<?=st($welcome_myarray['video_file'])?>'); getElementById('popupContact').style.top = '200px'; return false;">
				Click Here for Welcome Video </a>
			</center>
			
			<!--<center>
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="414" height="340">
				<param name="movie" value="video_lounge_with_fullscreen.swf" />
				<param name="quality" value="high" />
				<param name="menu" value="false" />
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="FlashVars" value="flv_name=<?=st($welcome_myarray['video_file'])?>" />
				<embed src="video_lounge_with_fullscreen.swf" width="414" height="340" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" flashvars="flv_name=<?=st($welcome_myarray['video_file'])?>" allowScriptAccess="sameDomain"></embed>
			</object>
			</center> -->
		<? 
		}
		?>
		<?=html_entity_decode(st($welcome_myarray['description']));?>
		<br />
		<?
	}
  


  ?>
	<center><img src="images/cpanelImgMap_06.jpg" width="474" height="466" border="0" usemap="#Map" />
<map name="Map" id="Map">
  <area shape="rect" alt="PATIENTS" title="Manage Patients" coords="13,4,234,230" href="manage_patient.php" />
  <area shape="rect" alt="LEDGER/REPORTS" title="Ledger Reports" coords="233,4,462,231" href="ledger.php" />
  <area shape="rect" alt="DIRECTORY/CONTACTS" title="Contacts" coords="13,230,233,459" href="directory.php" />
  <area shape="rect" alt="TOOLS" title="Configuration" coords="232,230,462,458" href="tools.php" />
</map></center>
  
  <br />
  <? if($_SESSION['username'] <> '') {?>
				<font style="font-size:15px; font-weight:bold; color:#00457c;"><center>Welcome <?=$_SESSION['username'];?> -</font><font style="font-size:17px; font-weight:bold; color:#000000;"> Select A Category</center></font>
			<? }
			else
			{
			?>
				<font style="font-size:15px; font-weight:bold; color:#00457c;"><center>Welcome to <?=$sitename;?></center></font>
			<? }?><br />
	
	


	<!--<br />
	
	<span class="admin_head"><em>
		Insurance Information:	</em></span>
	<br />
	<table width="660" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	<table width="659" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
	<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">Related Document</td>
			  <td valign="top"  align="center" class="em_boxhead" >View Detail</td>
	  </tr>
		<?
		$insurance_sql = "select * from dental_doc_insurance where status=1 and (docid = '' or docid like '%~".$_SESSION['docid']."~%') order by sortby";
		$insurance_my = mysql_query($insurance_sql) or die($insurance_sql." | ".mysql_error());
		
		if(mysql_num_rows($insurance_my) == 0)
		{
		?>
			<tr>
				<td valign="top" colspan="3" align="center">
					<b>No Records</b>
				</td>
			</tr>
		<?
		}
		else
		{
			while($insurance_myarray = mysql_fetch_array($insurance_my)) 
			{
				?>
				<tr>
					<td valign="top" width="50%"  class="titlesub">
						<?=st($insurance_myarray['title'])?>
					</td>
					<td width="30%" align="center" valign="top">
						<? if(st($insurance_myarray['doc_file']) <> '') {?>
						<a href="doc_file/<?=st($insurance_myarray['doc_file'])?>" target="_blank" class="viewtable" title="EDIT">
							View / Download</a>
						<? }?>					</td>
					<td width="20%" align="center" valign="top">
						<a href="Javascript: ;" target="_blank" class="viewtable" title="EDIT" onclick="Javascript: loadPopup('insurance_detail.php?id=<?=st($insurance_myarray['doc_insuranceid'])?>'); getElementById('popupContact').style.top = '500px'; return false;">
							View Detail</a>					</td>
				</tr>
				<?
			}
		}
		?>
	</table></td>
  </tr>
</table>
 -->
	
	
<?
}?>
</div>
</div>
</td></tr>
</table>
<!--
<div id="popupMemo" style="width:750px; z-index:9999; display:none; height:400px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

-->
<br /><br />
<? include 'includes/bottom.htm';?> 
