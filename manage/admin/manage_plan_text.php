<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";

if(!empty($_POST['plansub']) && $_POST['plansub'] == 1)
{
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_plan_text set plan_text = '".s_for($_POST["plan_text"])."' where plan_textid='".$_POST["ed"]."'";
		mysqli_query($con,$ed_sql);

		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='<?php echo $_SERVER['PHP_SELF'];?>?msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ins_sql = "insert into dental_plan_text set plan_text = '".s_for($_POST["plan_text"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($con,$ins_sql);
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='<?php echo $_SERVER['PHP_SELF'];?>?msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	}
}

$sql = "select * from dental_plan_text";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);
?>

<div class="page-header">
	Manage Plan/Progress Text
</div>
<br /><br /><br />

<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<br />

&nbsp;&nbsp;
Use <b>*DD*</b> for Dropdown of Device and <b>*PAT*</b> for Patient Name
<form name="planfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<tr class="tr_bg_h">
		<?php if(is_super($_SESSION['admin_access'])){ ?>
		<td valign="top" class="col_head">
			Enter Plan/Progress Text:
			<textarea name="plan_text" style="width:99%; height:200px;"><?php echo st($myarray['plan_text']);?></textarea>
		</td>
			
                        <?php }else{ ?>
				                <td valign="top" class="col_head">
                        Enter Plan/Progress Text:
				</td></tr>
				<tr><td valign="top">
                                <?php echo  $myarray['plan_text']; ?>
			</td>
                        <?php } ?>

	</tr>
	<tr>
		<td valign="top" align="center">
			<?php if(is_super($_SESSION['admin_access'])){ ?>
			<input type="hidden" name="ed" value="<?php echo st($myarray['plan_textid']);?>" />
			<input type="hidden" name="plansub" value="1" />
			<input type="submit" name="planbtn" value="Submit" class="btn btn-primary">
			<?php } ?>
		</td>
	</tr>
</table>
</form>


<br /><br />	
<?php include "includes/bottom.htm";?>
