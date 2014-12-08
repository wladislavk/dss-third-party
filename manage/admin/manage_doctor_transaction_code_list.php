<?php 
include "includes/top.htm";

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){ 
$sql = "select * from dental_users where user_access=2 order by username";
}else{
  $sql = "select u.* from dental_users u 
	where u.billing_company_id = '".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."' AND u.user_access=2 order by u.username";
}
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
	Manage Doctor Transaction Codes 
</div>
<br />
<br />


<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

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
		<td valign="top" class="col_head" width="20%">
			Username	
		</td>
		<td valign="top" class="col_head" width="40%">
			Name
		</td>
        
		<td valign="top" class="col_head" width="10%">
			Codes	
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
			$staff_sql = "select count(userid) as staff_count from dental_users where docid='".st($myarray['userid'])."' and user_access=1";
			$staff_my = mysqli_query($con,$staff_sql);
			$staff_myarray = mysqli_fetch_array($staff_my);
			
			$con_sql = "select count(transaction_codeid) as tc_count from dental_transaction_code where docid=".$myarray['userid'];
			$con_my = mysqli_query($con,$con_sql);
			$con_myarray = mysqli_fetch_array($con_my);

			if($myarray["status"] == 1)
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
					<?php echo st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?php echo st($myarray["name"]);?>
				</td>
				<td valign="top" align="center">
         				<?php echo  $con_myarray['tc_count']; ?> 
				</td>	
						
				<td valign="top">
					<a href="manage_doctor_transaction_code.php?docid=<?php echo  st($myarray['userid']); ?>">
					        View Codes
					</a>
				</td>
			</tr>
	<?php 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
