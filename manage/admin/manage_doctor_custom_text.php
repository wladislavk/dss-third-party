<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]) && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_custom where customid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&docid=<?php echo  $_GET['docid']; ?>";
	</script>
	<?
	die();
}

$rec_disp = 50;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_custom where docid=".$_GET['docid'];
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = mysqli_query($con,$sql);
$num_users = mysqli_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Custom Progress Note Text
</div>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_doctor_custom_text.php?docid=<?php echo  $_GET['docid']; ?>');" class="btn btn-success">
		Add New Custom Text
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

&nbsp;
<b>Total Records: <?php echo $total_rec;?></b>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>?docid=<?php echo  $_GET['docid']; ?>" method="post">
<table class="table table-bordered table-hover">
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="30%">
			Title		
		</td>
		<td valign="top" class="col_head" width="50%">
			Description		
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<?php if(mysqli_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
		while($myarray = mysqli_fetch_array($my))
		{
				$tr_class = "tr_active";
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($myarray["title"]);?>
				</td>
				<td valign="top">
					<?php echo st(substr($myarray["description"], 0, 50));?>
				</td>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_doctor_custom_text.php?docid=<?php echo  $_GET['docid']; ?>&ed=<?php echo $myarray["customid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
			</tr>
	<?php 	}
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
<?php include "includes/bottom.htm";?>
