<?php namespace Ds3\Legacy; ?><? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from p_pages where p_pageid='".$_REQUEST["delid"]."'";
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

if($_REQUEST["p_page"] != "")
	$index_val = $_REQUEST["p_page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from p_pages order by title";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_p_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_p_pages=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Popup Pages
</span>
<br />
<br />

<div align="right">
	<button onclick="Javascript: loadPopup('add_p_page.php');" class="addButton">
		Add New Popup Pages
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Popup Pages:
			<?
				 paging($no_p_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="90%">
			Title
		</td>
		<td valign="top" class="col_head" width="10%">
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
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["title"]);?>
				</td>	
				<td valign="top">
					<a href="Javascript:;" onclick="Javascript: loadPopup('add_p_page.php?ed=<?=$myarray["p_pageid"];?>');" class="editlink">
						<img src="images/b_edit.png" width="16" height="16" border="0" align="Edit"/>
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["p_pageid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink">
						<img src="images/b_drop.png" width="16" height="16" border="0" align="Delete"/>
					</a>
				</td>
			</tr>
            <tr class="<?=$tr_class;?>">
				<td valign="top" colspan="2">
					<b><?=$base_path?>p_pages.php?pid=<?=$myarray["p_pageid"]?></b>
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
