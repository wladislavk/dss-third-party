<? 
include "includes/top.htm";

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_login order by login_date desc";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Login
</span>
<br />
<br />

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered">
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
	<? if(mysql_num_rows($my) == 0)
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
		while($myarray = mysql_fetch_array($my))
		{
			$user_sql = "select * from dental_users where userid='".st($myarray['userid'])."'";
			$user_my = mysql_query($user_sql) or die(mysql_error()." | ".$user_sql);
			$user_myarray = mysql_fetch_array($user_my);
						
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
					<? if(st($myarray["logout_date"]) <> '') {?>
						<?=date('M d, Y H:i',strtotime(st($myarray["logout_date"])));?>
					<? }?>
				</td>
				
				<td valign="top" align="center">
                    <a href="login_detail.php?logid=<?=$myarray["loginid"];?>" class="dellink" title="DELETE">
                    	View Detail</a>
				</td>	
			</tr>
	<? 	}
	}?>
</table>

<br /><br />	
<? include "includes/bottom.htm";?>