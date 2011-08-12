<? 
include "includes/top.htm";
require_once('includes/patient_info.php');
if ($patient_info) {


if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_notes where notesid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
	</script>
	<?
	die();
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_notes where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Progress Notes
	-
	<i>
	<?=$name;?>
    </i>
</span>
<div align="left">
&nbsp;&nbsp;&nbsp;
<a href="manage_patient.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
</div>

<div align="right">
	<button onclick="Javascript: loadPopup('view_notes.php?pid=<?=$_GET['pid'];?>');" class="addButton">
		View/Print Progress Note
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('add_notes.php?pid=<?=$_GET['pid'];?>');" class="addButton">
		Add New Progress Note
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="15%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="right" >
	<tr>
		<td valign="top" bgcolor="#FF9999">
		&nbsp;&nbsp;&nbsp;
		</td>
		<td valign="top">
			&nbsp;&nbsp;
			<b>Edited Note</b>
		</td>
	</tr>
</table>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="30%">
			Note Date
		</td>
		<td valign="top" class="col_head" width="60%">
			Added by
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		$cur_bal = 0;
		while($myarray = mysql_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
			
			$user_sql = "SELECT * FROM dental_users where userid='".st($myarray["userid"])."'";
			$user_my = mysql_query($user_sql);
			$user_myarray = mysql_fetch_array($user_my);
		?>
			<tr class="<?=$tr_class;?>" <? if(st($myarray["edited"]) == 1) {?> style="" <? }?>>
				<td valign="top">
                	<?=date('M d, Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
				<td valign="top">
                	<?=st($user_myarray["name"]);?>
				</td>
				<td valign="top">
					<a href="Javascript:;" onclick="Javascript: loadPopup('view_notes.php?ed=<?=$myarray["notesid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="View Detail">
						<img src="admin/images/b_browse.png" alt="EDIT" width="16" height="16" border="0" align="View Detail"/>
					</a>
						
					<? if(date('m-d-Y') == date('m-d-Y',strtotime(st($myarray["adddate"]))))
					{?>
						<a href="Javascript:;" onclick="Javascript: loadPopup('add_notes.php?ed=<?=$myarray["notesid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="EDIT">
							Edit 
						</a>
					<? }?>
					
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["notesid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact" style="width:750px;height:450px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>

<? include "includes/bottom.htm";?>
