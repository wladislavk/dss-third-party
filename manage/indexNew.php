<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm';?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup2.js" type="text/javascript"></script>

<br />
<div>
 <table>
 <tr>
 <td valign="top" style="border-right:1px solid #00457c;width:290px;">

<div style="padding-left:10px; padding-right:10px; margin-right:5px;"> 
                




<?php

$adminmemo_check_sql = "SELECT * FROM memo_admin LIMIT 1";
$adminmemo_check_qry = mysqli_query($con, $adminmemo_check_sql);
while($adminmemo_array = mysqli_fetch_array($adminmemo_check_qry)){
if($adminmemo_array['memo'] != NULL || $adminmemo_array['memo'] != ''){
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
 }
 } ?>

  <div style="color:#00457c; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;"><span class="admin_head" style="color:#00457c;"><em> Todays Memo: </em></span></div>
	<br />
	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php 

$memouserid = $_SESSION['userid'];
$memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";
$memo_check_qry = mysqli_query($con, $memo_check_sql);
while($memo_array = mysqli_fetch_array($memo_check_qry)){
if($memo_array != NULL || $memo_array != ''){
echo $memo_array['memo'] . "<br /><hr />";
}
}
?>

<a href="Javascript: ;" target="_blank" class="viewtable" title="EDIT" onclick="Javascript: loadPopup('memo.php'); getElementById('popupMemo').style.top = '200px'; return false;">Edit Memo</a>
    </td>
    
  </tr>
  </table>
  <br /> <br /><br />

 <?

$sqlddlist = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if($_GET['sh'] != 2)
{
	$sqlddlist .= " and status = 1";
}
$sqlddlist .= " order by lastname, firstname";
$myddlist = mysqli_query($con, $sqlddlist);

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
if($_GET['sh'] != 2)
{
	$sqlddlist2 .= " and status = 1";
}
$sqlddlist2 .= " order by lastname, firstname";
$myddlist2 = mysqli_query($con, $sqlddlist2);
while($ddlistpname2 = (mysqli_fetch_array($myddlist2))){
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
if($_GET['sh'] != 2)
{
	$sqlddlist3 .= " and status = 1";
}
$sqlddlist3 .= " order by lastname, firstname";
$myddlist3 = mysqli_query($con, $sqlddlist3);
while($ddlistpname3 = (mysqli_fetch_array($myddlist3))){
?>
<option value="manage_flowsheet.php?pid=<?php echo $ddlistpname3['patientid']; ?>">
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



<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Summary Sheet:</font><br />
<FORM NAME="DropDown">
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php
$sqlddlist4 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if($_GET['sh'] != 2)
{
	$sqlddlist4 .= " and status = 1";
}
$sqlddlist4 .= " order by lastname, firstname";
$myddlist4 = mysqli_query($con, $sqlddlist4);
while($ddlistpname4 = (mysqli_fetch_array($myddlist4))){
?>
<option value="dss_summ.php?pid=<?php echo $ddlistpname4['patientid']; ?>">
<?php echo $ddlistpname4['lastname'].", ".$ddlistpname4['firstname']." ".$ddlistpname4['middlename']; ?>
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
	$welcome_my = mysqli_query($con, $welcome_sql) or trigger_error($welcome_sql." | ".mysqli_error($con), E_USER_ERROR);
	
	while($welcome_myarray = mysqli_fetch_array($welcome_my)) 
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
  <area shape="rect" alt="PATIENTS" coords="13,4,234,230" href="manage_patient.php" />
  <area shape="rect" alt="LEDGER/REPORTS" coords="233,4,462,231" href="ledger.php" />
  <area shape="rect" alt="DIRECTORY/CONTACTS" coords="13,230,233,459" href="directory.php" />
  <area shape="rect" alt="TOOLS" coords="232,230,462,458" href="tools.php" />
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
		$insurance_my = mysqli_query($con, $insurance_sql) or trigger_error($insurance_sql." | ".mysqli_error($con), E_USER_ERROR);
		
		if(mysqli_num_rows($insurance_my) == 0)
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
			while($insurance_myarray = mysqli_fetch_array($insurance_my)) 
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
<div id="popupMemo" style="width:750px; z-index:9999; height:400px; position:absolute;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

<div id="backgroundPopup"></div>

<br /><br />
<? include 'includes/bottom.htm';?> 
