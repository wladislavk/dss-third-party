<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";

$rec_disp = 20;

if($_REQUEST["page"] != "") {
    $index_val = $_REQUEST["page"];
} else {
    $index_val = 0;
}
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_login order by login_date desc";
$my = mysqli_query($con, $sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con, $sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Login
</div>
<br />
<br />

<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered table-hover">
	<?php if($total_rec > $rec_disp) {?>
	<tr bgcolor="#ffffff">
		<td align="right" colspan="15" class="bp">
			Pages:
			<?php
            paging($no_pages,$index_val,"");
			?>
		</td>
	</tr>
	<?php } ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="30%">
			Username	
		</td>
		<td valign="top" class="col_head" width="20%">
			Login On
		</td>
		<td valign="top" class="col_head" width="40%">
			Logout On
		</td>
		<td valign="top" class="col_head" width="10%">
			View Detail
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
			$user_sql = "select * from dental_users where userid='".st($myarray['userid'])."'";
			$user_my = mysqli_query($con, $user_sql) or trigger_error(mysqli_error($con)." | ".$user_sql, E_USER_ERROR);
			$user_myarray = mysqli_fetch_array($user_my);
						
			$tr_class = "tr_active";
			
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($user_myarray["username"]);?>
				</td>
				<td valign="top">
					<?=date('M d, Y H:i',strtotime(st($myarray["login_date"])));?>
				</td>
				<td valign="top">
					<?php if(st($myarray["logout_date"]) != '') {?>
						<?=date('M d, Y H:i',strtotime(st($myarray["logout_date"])));?>
					<?php } ?>
				</td>
				
				<td valign="top" align="center">
                    <a href="login_detail.php?logid=<?=$myarray["loginid"];?>" class="btn btn-danger pull-right" title="DELETE">
                    	View Detail</a>
				</td>	
			</tr>
	<?php }
	}?>
</table>

<br /><br />	
<?php include "includes/bottom.htm";?>
