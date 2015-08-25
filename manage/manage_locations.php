<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_locations where id='".$_REQUEST["delid"]."' AND docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}

if(isset($_REQUEST['did'])){
	$d_sql = "UPDATE dental_locations set default_location=0 where docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
	$db->query($d_sql);
	$d_sql = "UPDATE dental_locations set default_location=1 where id='".mysqli_real_escape_string($con,$_REQUEST['did'])."' AND docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
	$db->query($d_sql);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_locations where docid='".$_SESSION['docid']."' order by location";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_contact = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Locations
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('add_location.php');" class="addButton">
		Add New Location
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<?php if($total_rec > $rec_disp) {?>
		<TR bgColor="#ffffff">
			<TD  align="right" colspan="15" class="bp">
				Pages:
				<?php
					 paging($no_pages,$index_val,"");
				?>
			</TD>
		</TR>
		<?php }?>
		<tr class="tr_bg_h">
			<td valign="top" class="col_head" width="60%">
				Location
			</td>
			<td valign="top" class="col_head" width="10%">
				Action
			</td>
		</tr>
		<?php if($num_contact == 0){ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
		<?php 
		}
		else
		{
			foreach ($my as $myarray) {

				if(!empty($myarray["status"]) && $myarray["status"] == 1)
				{
					$tr_class = "tr_active";
				}
				else
				{
					$tr_class = "tr_inactive";
				}
			?>
		<tr class="<?php echo $tr_class;?>">
			<td valign="top">
				<?php echo st($myarray["location"]);?>
			</td>
			<td valign="top">
				<a href="Javascript:;"  onclick="Javascript: loadPopup('add_location.php?ed=<?php echo $myarray["id"];?>');" class="editlink" title="EDIT">
					Edit
				</a>
				|
				<?php if($myarray['default_location']==1){ ?>
					Default Location
				<?php }else{ ?>
				<a href="manage_locations.php?did=<?php echo $myarray['id']; ?>"  class="editlink" title="MAKE DEFAULT">
					Make Default 
				</a>
				<?php } ?>
			</td>
		</tr>
		<?php 	}
		} ?>
	</table>
</form>

<div id="popupContact" style="width:750px;">
	<a id="popupContactClose"><button>X</button></a>
	<iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
