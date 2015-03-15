<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access']))
{
	$del_sql = "delete from dental_fcontact where contactid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select c.*, ct.contacttype  from dental_contact c
	LEFT JOIN dental_contacttype ct ON c.contacttypeid=ct.contacttypeid
	 where c.corporate=1 order by c.company";
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
	<h1>Manage Franchise and Corporate Contacts</h1>
</div>
<br />
<br />
&nbsp;
<?php if(is_super($_SESSION['admin_access'])){ ?>
<div align="right">
	<button onclick="loadPopup('add_contact.php?corp=1');" class="btn btn-success">
		Add Corporate Contact
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<div style="overflow:auto; height:400px;">
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
			Company
		</td>
		<td valign="top" class="col_head" width="20%">
			Type	
		</td>
		<td valign="top" class="col_head" width="30%">
			Name
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
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			
			$name = st($myarray['lastname'])." ".st($myarray['middlename']).", ".st($myarray['firstname']);
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($myarray["company"]);?>
				</td>
				<td valign="top">
					<?php echo st($myarray["contacttype"]);?>
				</td>
				<td valign="top">
					<?php echo $name;?>
				</td>
				<td valign="top">
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					<a href="Javascript:;"  onclick="Javascript: loadPopup('view_contact.php?ed=<?php echo $myarray["contactid"];?>&corp=1');" title="Quick View" class="btn btn-primary btn-sm">
                                                Quick View
                                         <span class="glyphicon glyphicon-pencil"></span></a>
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_contact.php?ed=<?php echo $myarray["contactid"];?>&corp=1');" title="View Full" class="btn btn-primary btn-sm">
						View Full 
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    			<?php } ?>
				</td>
			</tr>
	<?php 	}
	}?>
</table>
</div>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
