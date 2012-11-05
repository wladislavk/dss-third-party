<? 
include "includes/top.htm";

if($_POST['plansub'] == 1)
{
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_plan_text set plan_text = '".s_for($_POST["plan_text"])."' where plan_textid='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='<?=$_SERVER['PHP_SELF'];?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ins_sql = "insert into dental_plan_text set plan_text = '".s_for($_POST["plan_text"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='<?=$_SERVER['PHP_SELF'];?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}

$sql = "select * from dental_plan_text";
$my = mysql_query($sql) or die(mysql_error());
$myarray = mysql_fetch_array($my);
?>

<span class="admin_head">
	Manage Plan/Progress Text
</span>
<br /><br /><br />

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<br />

&nbsp;&nbsp;
Use <b>*DD*</b> for Dropdown of Device and <b>*PAT*</b> for Patient Name
<form name="planfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<?php if(is_super($_SESSION['admin_access'])){ ?>
		<td valign="top" class="col_head">
			Enter Plan/Progress Text:
			<textarea name="plan_text" style="width:99%; height:200px;"><?=st($myarray['plan_text']);?></textarea>
		</td>
			
                        <?php }else{ ?>
				                <td valign="top" class="col_head">
                        Enter Plan/Progress Text:
				</td></tr>
				<tr><td valign="top">
                                <?= $myarray['plan_text']; ?>
			</td>
                        <?php } ?>

	</tr>
	<tr>
		<td valign="top" align="center">
			<?php if(is_super($_SESSION['admin_access'])){ ?>
			<input type="hidden" name="ed" value="<?=st($myarray['plan_textid']);?>" />
			<input type="hidden" name="plansub" value="1" />
			<input type="submit" name="planbtn" value="Submit" />
			<?php } ?>
		</td>
	</tr>
</table>
</form>


<br /><br />	
<? include "includes/bottom.htm";?>
