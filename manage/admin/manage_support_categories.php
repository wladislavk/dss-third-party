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

$sql = "select c.*, 
		(SELECT COUNT(t.id) FROM dental_support_tickets t WHERE t.category_id=c.id AND t.status=0) AS num_tickets,
                (SELECT COUNT(a.id) FROM dental_support_category_admin a WHERE a.category_id=c.id) AS num_admins
	FROM dental_support_categories c
	WHERE c.status=0
	 order by c.title ASC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Support Categories
</div>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_support_category.php');" class="btn btn-success">
		Add New Category
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered table-hover">
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="60%">
			Title
		</td>
		<td valign="top" class="col_head">
 			Number of Open Tickets
		</td>
		<td valign="top" class="col_head">
			Number of Admins
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
					<a href="manage_support_tickets.php?catid=<?= $myarray['id'];?>"><?= st($myarray["num_tickets"]); ?></a>
				</td>	
                                <td valign="top">
                                        <a href="manage_support_category_admins.php?catid=<?= $myarray['id'];?>"><?= st($myarray["num_admins"]); ?></a>
                                </td>	
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_support_category.php?ed=<?=$myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
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
