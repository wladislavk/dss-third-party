<?php namespace Ds3\Libraries\Legacy; ?><? 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_locations where id='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&docid=<?=$_GET['docid']?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

if(isset($_REQUEST['did'])){
  $d_sql = "UPDATE dental_locations set default_location=0 where docid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
  mysqli_query($con,$d_sql);
  $d_sql = "UPDATE dental_locations set default_location=1 where id='".mysqli_real_escape_string($con,$_REQUEST['did'])."' AND docid='".mysqli_real_escape_string($con,$_REQUEST['docid'])."'";
  mysqli_query($con,$d_sql);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_locations where docid='".$_GET['docid']."' order by location";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = mysqli_query($con,$sql);
$num_contact = mysqli_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Contact
</div>
<br />
<br />
&nbsp;
<a href="manage_users.php" class="btn btn-danger pull-right" title="DELETE" >
	<b>&lt;&lt; Back</b></a>

<div align="right">
	<button onclick="Javascript: loadPopup('add_location.php?docid=<?=$_GET['docid']?>');" class="btn btn-success">
		Add New Location
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

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
		<td valign="top" class="col_head" width="60%">
			Location
		</td>
		<td valign="top" class="col_head" width="10%">
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
			if(!empty($myarray["status"]) && $myarray["status"] == 1)
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
					<?=st($myarray["location"]);?>
				</td>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_location.php?ed=<?=$myarray["id"];?>&docid=<?=$_GET['docid']?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
					|
					<?php if($myarray['default_location']==1){ ?>
						Default Location
					<?php }else{ ?>
					   <a href="manage_locations.php?docid=<?= $_GET['docid']; ?>&did=<?= $myarray['id']; ?>"  class="editlink" title="MAKE DEFAULT">
                                                Make Default 
                                          </a>
                    			<?php } ?>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
