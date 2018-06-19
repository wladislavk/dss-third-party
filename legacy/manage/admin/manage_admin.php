<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";

if($_REQUEST["delid"] != "") {
	$del_sql = "delete from dental_users where userid='".$_REQUEST["delid"]."'";
	mysqli_query($con, $del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if($_REQUEST["page"] != "") {
    $index_val = $_REQUEST["page"];
} else {
    $index_val = 0;
}
$i_val = $index_val * $rec_disp;
$sql = "select * from admin order by username";
$my = mysqli_query($con, $sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = mysqli_query($con, $sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Admins
</div>
<br />
<br />

<?php if($_SESSION["admin_access"]==1){ ?>
<div align="right">
	<button onclick="loadPopup('add_admin.php');" class="btn btn-success">
		Add New Admin 
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>

<br />
<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered table-hover">
	<?php if($total_rec > $rec_disp) {?>
	<tr bgColor="#ffffff">
		<td align="right" colspan="15" class="bp">
			Pages:
			<?php
            paging($no_pages,$index_val,"");
			?>
		</td>
	</tr>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Username	
		</td>
		<td valign="top" class="col_head" width="40%">
			Name
		</td>
		<td valign="top" class="col_head" width="40%">
			User Level
		</td>       
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<?php if(mysqli_num_rows($my) == 0) { ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php
	} else {
		while($myarray = mysqli_fetch_array($my)) {
			if($myarray["status"] == 1) {
				$tr_class = "tr_active";
			} else {
				$tr_class = "tr_inactive";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["admin_access"]); ?> -
					<?= $dss_admin_access_labels[$myarray["admin_access"]]; ?>
				</td>
				
				<td valign="top">
					<?php if($_SESSION["admin_access"]==1){ ?>
					<a href="Javascript:;"  onclick="loadPopup('add_admin.php?ed=<?=$myarray["adminid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    			<?php } ?>
				</td>
			</tr>
	<?php }
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
