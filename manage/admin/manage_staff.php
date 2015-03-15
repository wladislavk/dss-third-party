<?php namespace Ds3\Libraries\Legacy; ?><? 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_users where userid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&docid=<?=$_GET['docid'];?>";
	</script>
	<?
	die();
}

$doc_sql = "select * from dental_users where userid = '".s_for($_GET['docid'])."'";
$doc_my = mysqli_query($con,$doc_sql);
$doc_myarray = mysqli_fetch_array($doc_my);

if(st($doc_myarray['username']) == '')
{
	?>
	<script type="text/javascript">
		// window.location = "manage_users.php?msg=Invalid Information.";
	</script>
	<?
	// die();
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_users where user_access=1 and docid='".$doc_myarray['userid']."' order by username";
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
	Manage Staff For <i><?=st($doc_myarray['username']);?></i>
</div>
<br />
<br />
&nbsp;
<a href="manage_users.php" class="btn btn-info pull-left" title="Back" >
	<b>&lt;&lt; Back</b></a>

	<button onclick="Javascript: loadPopup('add_staff.php?docid=<?=$_GET['docid'];?>');" class="btn btn-success pull-right">
		Add New Staff
		<span class="glyphicon glyphicon-plus">
	</button>
<div class="clearfix"></div>

<br />
<div align="center" class="red">
	<b><? echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
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
		<td valign="top" class="col_head" width="20%">
			Username
		</td>
		<td valign="top" class="col_head" width="60%">
			Name
		</td>
                <td valign="top" class="col_head" width="10%">
                        Producer
                </td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<? if(mysqli_num_rows($my) == 0)
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
		while($myarray = mysqli_fetch_array($my))
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
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["first_name"]);?>
					<?=st($myarray["last_name"]);?>
				</td>
			 	<td valign="top">
					<?= ($myarray["producer"]==1)?"X":''; ?>
  				</td>		
						
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_staff.php?ed=<?=$myarray["userid"];?>&docid=<?=$_GET['docid'];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
	<? 	}
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
