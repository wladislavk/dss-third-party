<? 
include "includes/top.htm";

$log_sql = "select * from dental_login where loginid='".s_for($_GET['logid'])."'";
$log_my = mysqli_query($con, $log_sql);
$log_myarray = mysqli_fetch_array($log_my);

if(st($log_myarray['userid']) == '')
{
	?>
	<script type="text/javascript">
		window.location = "manage_login.php?msg=Invalid Information.";
	</script>
	<?
	die();
}

$user_sql = "select * from dental_users where userid='".st($log_myarray['userid'])."'";
$user_my = mysqli_query($con, $user_sql) or die(mysqli_error($con)." | ".$user_sql);
$user_myarray = mysqli_fetch_array($user_my);

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_login_detail where loginid='".$log_myarray['loginid']."' order by adddate";
$my = mysqli_query($con, $sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con, $sql) or die(mysqli_error($con));
$num_users=mysqli_num_rows($my);
?>

<div class="page-header">
	Login Detail 
	-
	<?=st($user_myarray['username']);?>
	-
	<?=date('M d, Y H:i',strtotime(st($log_myarray["login_date"])));?>
</div>
<br />
<br />
&nbsp;
<a href="manage_login.php" class="btn btn-danger pull-right" title="DELETE" >
	<b>&lt;&lt; Back</b></a>


<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered table-hover">
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"&logid=".$_GET['logid']);
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="30%">
			Visit Date
		</td>
		<td valign="top" class="col_head" width="70%">
			Visited Page
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
			$tr_class = "tr_active";	
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=date('M d, Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
				<td valign="top">
					http://<?=$_SERVER['HTTP_HOST'];?><?=st($myarray["cur_page"]);?>
				</td>
			</tr>
	<? 	}
	}?>
</table>

<br /><br />	
<? include "includes/bottom.htm";?>