<? 
include "includes/top.htm";


$sql = "select s.*
	 FROM dental_device_guide_settings s
	 order by name ASC";
$my = mysql_query($sql);
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Device Settings
</div>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_device_guide_setting.php');" class="btn btn-success">
		Add Setting
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered table-hover">
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
		<td valign="top" class="col_head">
 			Type
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
					<?= st($dss_device_setting_type_labels[$myarray["setting_type"]]); ?>
					<?php if($myarray["setting_type"] == DSS_DEVICE_SETTING_TYPE_RANGE){ ?>
						(<?= $myarray['range_start']; ?> - <?= $myarray['range_end']; ?>)
					<?php } ?>
				</td>		
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_device_guide_setting.php?ed=<?=$myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
