<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_appt_types where docid='".mysql_real_escape_string($_SESSION['docid'])."' AND id='".$_REQUEST["delid"]."'";
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
$sql = "select * from dental_appt_types WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."' order by name";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Appointment Types
</span>
<br />
<br />
&nbsp;
<?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff'] == 1){
?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_appt.php');" class="addButton">
		Add New Appointment Type
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
 <style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
		<td valign="top" class="col_head" width="20%">
			Appointment Type Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Appointment Type Color
		</td>
<?php /*		<td valign="top" class="col_head" width="60%">
			Name
		</td>
                <td valign="top" class="col_head" width="10%">
                        Producer
                </td>
*/
?>
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
		while($myarray = mysql_fetch_array($my))
		{
			$tr_class = "tr_active";
/*			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
*/
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				<td style="background-color: #<?php print $myarray['color']; ?>" valign="top">
					<?=st($myarray["color"]);?>
				</td>
<?php /*
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
                                <td valign="top">
                                        <?= ($myarray["producer"]==1)?"X":''; ?>
                                </td>
*/ ?>
				<td valign="top">
<?php
$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$q = mysql_query($sql);
$r = mysql_fetch_assoc($q);
if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff'] == 1){
?>

					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_appt.php?ed=<?=$myarray["id"];?>');" class="editlink" title="EDIT">
						Edit 
					</a>
<?php } ?>                    
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
