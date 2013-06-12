<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && is_admin($_SESSION['admin_access']))
{
	$del_sql = "UPDATE dental_support_categories SET status=1 WHERE id='".mysql_real_escape_string($_REQUEST["delid"])."'";
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

$sql = "select * FROM dental_support_tickets ";
if(isset($_REQUEST['catid'])){
  $sql .= " WHERE category_id = ".mysql_real_escape_string($_REQUEST['catid']);
}
$sql .= " order by status ASC, adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Support Tickets
</span>
<br />
<br />


<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="60%">
			Title
		</td>
		<td valign="top" class="col_head">
 			Body
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
					<?=st($myarray["title"]);?>
				</td>
				<td valign="top">
					<?= st(substr($myarray["body"], 0 , 50)); ?>
				</td>		
				<td valign="top">
					<a href="view_support_ticket.php?ed=<?=$myarray["id"];?>" class="editlink" title="EDIT">
						View
					</a>
                   		<?php if($myarray['attachment']!=''){ ?>
					| <a href="../q_file/<?= $myarray['attachment']; ?>">Attachment</a>
				<?php } ?> 
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
