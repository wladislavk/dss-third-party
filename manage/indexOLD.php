<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm';?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup2.js" type="text/javascript"></script>

<br />
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
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



  $adminmemo_check_sql = "SELECT * FROM memo_admin LIMIT 1";
$adminmemo_check_qry = mysql_query($adminmemo_check_sql);
while($adminmemo_array = mysql_fetch_array($adminmemo_check_qry)){
if($adminmemo_array['memo'] != NULL || $adminmemo_array['memo'] != ''){
	?>
	
    <span class="admin_head" style="color:#ff0000;"><em> Global Memo: </em></span>
	<br />
	<table width="960" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php 
echo "". $adminmemo_array['memo'] . "<br />";
?>

    </td>
    
  </tr>
  </table>
  <br /><br />
 <?php 
 }
 } ?>

  <span class="admin_head"><em> Todays Memo: </em></span>
	<br />
	<table width="960" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php 

$memouserid = $_SESSION['userid'];
$memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";
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
	<br /><br />
	
	
	<span class="admin_head"><em> General Files: </em></span>
	<br />
	<table width="960" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	<table width="959" cellpadding="0" cellspacing="0" border="0" align="center"  class="em_box">
	<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">Details</td>
			  
	  </tr>
		<?
		$new_sql = "select * from filemanager where docid=".$_SESSION['docid']." order by date DESC LIMIT 3";
		$new_my = mysql_query($new_sql) or die($new_sql." | ".mysql_error());
		
		if(mysql_num_rows($new_my) == 0)
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
			while($new_myarray = mysql_fetch_array($new_my)) 
			{
				?>
				<tr>
					<td valign="top" width="70%"  class="titlesub">
						<?php echo $new_myarray['name']; ?>
					</td>
					<td width="30%" align="center" valign="top">
						<a href="download.php?id=<?php echo $new_myarray['id']; ?>">
          View/Download
          
          </a>
										</td>
					
				</tr>
				<?
			}
		}
		?>
	</table></td>
  </tr>
</table>
	
	<br />
	<span class="admin_head"><em>
		Educational Materials:	</em>
	</span>
	<br />
	
<table width="960" border="0" cellspacing="1" cellpadding="1" align="center"  class="sample">
  <tr>
    <td valign="top"><table width="959" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
		<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">Detail</td>
	  </tr>
		<?
		$educational_sql = "select * from filemanager_edu where docid=".$_SESSION['docid'] ." order by date DESC LIMIT 3";
		$educational_my = mysql_query($educational_sql) or die($educational_sql." | ".mysql_error());
		
		if(mysql_num_rows($educational_my) == 0)
		{
		?>
			<tr>
				<td valign="top" colspan="3" align="center">
					<b>No Records</b>				</td>
			</tr>
		<?
		}
		else
		{
			while($educational_myarray = mysql_fetch_array($educational_my)) 
			{
				?>
				<tr>
					<td valign="top" width="70%" class="titlesub">
					<?php echo $educational_myarray['name']?></td>
					<td width="30%" align="center" valign="top">
						
						<a href="download.php?id=<?php echo $educational_myarray['id']; ?>">
						   View/Download
						</a>
						</td>
					
				</tr>
				<?
			}
		}
		?>
</table></td>
  </tr>
</table>

	<br />
	
	<span class="admin_head"><em>
		Marketing Materials:	</em></span>
	<br />
	<table width="960" border="0" align="center" cellpadding="1" cellspacing="1"  class="sample">
  <tr>
    <td valign="top"><table width="959" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
			<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">Detail</td>
			  
	  </tr>
		<?
		$marketing_sql = "select * from filemanager_mark where docid=".$_SESSION['docid'] ." order by date DESC LIMIT 3";
		$marketing_my = mysql_query($marketing_sql) or die($marketing_sql." | ".mysql_error());
		
		if(mysql_num_rows($marketing_my) == 0)
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
			while($marketing_myarray = mysql_fetch_array($marketing_my)) 
			{
				?>
				<tr>
					<td valign="top" width="50%" class="titlesub">
						<?php echo $marketing_myarray['name'];?>
					</td>
				
					<td width="20%" align="center" valign="top">
						<a href="download.php?id=<?php echo $marketing_myarray['id']; ?>">
						   View/Download
						</a>	</td>
				</tr>
				<?
			}
		}
		?>
	</table></td>
  </tr>
</table>

		<br />
	
	<span class="admin_head"><em> View DVD’S: </em></span>
	<br />
	
	<table width="960" border="0" cellspacing="1" cellpadding="1" class="sample" align="center">
  <tr>
    <td>
	<table width="959" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
		<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">View Detail</td>
	  </tr>
		
		<?
		$dvd_sql = "select * from filemanager_dvd where docid=".$_SESSION['docid'] ." order by date DESC LIMIT 3";
		$dvd_my = mysql_query($dvd_sql) or die($dvd_sql." | ".mysql_error());
		
		if(mysql_num_rows($dvd_my) == 0)
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
			while($dvd_myarray = mysql_fetch_array($dvd_my)) 
			{
				?>
				<tr>
					<td valign="top" width="70%" class="titlesub">
						<?php echo $dvd_myarray['name'];?>
					</td>
					<td width="30%" align="center" valign="top">
						<a href="download.php?id=<?php echo $dvd_myarray['id']; ?>">
						   View/Download
						</a>
									</td>
				</tr>
				<?
			}
		}
		?>
	</table></td>
  </tr>
</table>
<br />
	
	
	<span class="admin_head"><em>
		Dental Appliance Lab Files:	</em></span>
	<br />
<table width="960" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	  <table width="959" cellpadding="0" cellspacing="0" border="0" align="center"  class="em_box">
	<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">View Detail</td>
	  </tr>
		<?
		$lab_sql = "select * from filemanager_al where docid=".$_SESSION['docid'] ." order by date DESC LIMIT 3";
		$lab_my = mysql_query($lab_sql) or die($lab_sql." | ".mysql_error());
		
		if(mysql_num_rows($lab_my) == 0)
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
			while($lab_myarray = mysql_fetch_array($lab_my)) 
			{
				?>
				<tr>
					<td valign="top" width="70%" class="titlesub">
						<?php echo $lab_myarray['name'];?>
					</td>
					<td width="30%" align="center" valign="top">
						<a href="download.php?id=<?php echo $lab_myarray['id']; ?>">
						   View/Download
						</a>					</td>
				</tr>
				<?
		}
		}
		?>
	</table></td>
  </tr>
</table>



<br />
	
	
	<span class="admin_head"><em>
		Sleep Lab Files:	</em></span>
	<br />
<table width="960" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	  <table width="959" cellpadding="0" cellspacing="0" border="0" align="center"  class="em_box">
	<tr >
			  <td valign="top" class="em_boxhead">Title</td>
			  <td valign="top"  align="center"  class="em_boxhead">View Detail</td>
	  </tr>
		<?
		$sllab_sql = "select * from filemanager_sl where docid=".$_SESSION['docid']." order by date DESC LIMIT 3";
		$sllab_my = mysql_query($sllab_sql) or die($sllab_sql." | ".mysql_error());
		
		if(mysql_num_rows($lab_my) == 0)
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
			while($sllab_myarray = mysql_fetch_array($sllab_my)) 
			{
				?>
				<tr>
					<td valign="top" width="70%" class="titlesub">
						<?php echo $sllab_myarray['name'];?>
					</td>
					<td width="30%" align="center" valign="top">
						<a href="download.php?id=<?php echo $sllab_myarray['id']; ?>">
						   View/Download
						</a>					</td>
				</tr>
				<?
		}
		}
		?>
	</table></td>
  </tr>
</table>	

	<!--<br />
	
	<span class="admin_head"><em>
		Insurance Information:	</em></span>
	<br />
	<table width="960" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	<table width="959" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
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

<div id="popupMemo" style="width:750px; z-index:9999;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="400" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

<div id="backgroundPopup"></div>

<br /><br />
<? include 'includes/bottom.htm';?> 
