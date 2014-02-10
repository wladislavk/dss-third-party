<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_custom where customid='".$_REQUEST["delid"]."'";
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
$sql = "select * from dental_custom where default_text=1 ";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Custom Progress Note Text
</span>
<br />
<br />

<?php if(is_super($_SESSION['admin_access'])){ ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_custom_text.php');" class="btn btn-success">
		Add New Custom Text
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered">
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
		<td valign="top" class="col_head" width="10%">
			Title		
		</td>
		<td valign="top" class="col_head" width="40%">
			Text		
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
					<?=st(substr($myarray["description"], 0, 50));?>
				</td>
						
				<td valign="top">
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_custom_text.php?ed=<?=$myarray["customid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                   			<?php } ?> 
				</td>
			</tr>
	<? 	}
		?>
		<tr>
			<td valign="top" class="col_head" colspan="3">&nbsp;
				
			</td>
		</tr>
		<?
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
