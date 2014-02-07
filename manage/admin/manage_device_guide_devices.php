<? 
include "includes/top.htm";


if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select d.*
	 from dental_device_guide_devices d 
	 order by name ASC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Devices 
</span>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_device_guide_device.php');" class="btn btn-success">
		Add New Device
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

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
		<td valign="top" class="col_head" width="60%">
			Name
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="3" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{

		?>
			<tr>
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_device_guide_device.php?ed=<?=$myarray["id"];?>');" class="editlink" title="EDIT">
						Edit
					</a>
                    
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
