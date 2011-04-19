<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from filemanager where id='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
  die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from filemanager where docid='".$_SESSION['docid']."' order by name";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_contact=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup3.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Files
</span>
<br />
<br />
&nbsp;

<!--<div align="right">
	<button onclick="Javascript: loadPopup('add_file.php?step=step1');" class="addButton">
		Add New File
	</button>
	&nbsp;&nbsp;
</div>-->

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

	<span class="admin_head"><em> General Files: </em></span>
	<p></p>
	<br />
	<table width="660" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	<table width="659" cellpadding="0" cellspacing="0" border="0" align="center"  class="em_box">
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
	 <p></p>
<table width="660" border="0" cellspacing="1" cellpadding="1" align="center"  class="sample">
  <tr>
    <td valign="top"><table width="659" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
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
	<p></p>
	<table width="660" border="0" align="center" cellpadding="1" cellspacing="1"  class="sample">
  <tr>
    <td valign="top"><table width="659" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
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
	  <p></p>
	<table width="660" border="0" cellspacing="1" cellpadding="1" class="sample" align="center">
  <tr>
    <td>
	<table width="659" cellpadding="0" cellspacing="0" border="0" align="center" class="em_box">
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
	<p></p>
<table width="660" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	  <table width="659" cellpadding="0" cellspacing="0" border="0" align="center"  class="em_box">
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
	<p></p>
<table width="660" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
	  <table width="659" cellpadding="0" cellspacing="0" border="0" align="center"  class="em_box">
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


<div id="popupContact" style="height:225px;width:394px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>