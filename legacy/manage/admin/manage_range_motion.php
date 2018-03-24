<?php namespace Ds3\Libraries\Legacy; ?><? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_range_motion where range_motionid='".$_REQUEST["delid"]."'";
	mysqli_query($con, $del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_range_motion order by sortby";
$my = mysqli_query($con, $sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con, $sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
$num_users=mysqli_num_rows($my);

if($_POST['sortsub'] == 1)
{
	foreach($_POST['sortby'] as $val)
	{
		$smyarray = mysqli_fetch_array($my);
		
		if($val == '' || is_numeric($val) === false)
		{
			$val = 999;
		}
		
		$up_sort_sql = "update dental_range_motion set sortby='".s_for($val)."' where range_motionid='".$smyarray["range_motionid"]."'";
		mysqli_query($con, $up_sort_sql);
	}
	$msg = "Sort By Changed Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		window.location.replace("<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>");
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Range Motion
</div>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_range_motion.php');" class="btn btn-success">
		Add New Range Motion
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
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
		<td valign="top" class="col_head" width="80%">
			Range Motion		
		</td>
		<td valign="top" class="col_head" width="10%">
			Sort By 
		</td>
		<td valign="top" class="col_head" width="20%">
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
			if($myarray["status"] == 1)
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
					<?=st($myarray["range_motion"]);?>
				</td>
				
				<td valign="top" align="center">
					<input type="text" name="sortby[]" value="<?=st($myarray['sortby'])?>" class="form-control text-center" style="width:5em"/>
				</td>	
						
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_range_motion.php?ed=<?=$myarray["range_motionid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["range_motionid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="btn btn-danger pull-right" title="DELETE">
						Delete
					</a>
				</td>
			</tr>
	<? 	}
		?>
		<tr>
			<td valign="top" class="col_head" colspan="1">&nbsp;
				
			</td>
			<td valign="top" class="col_head" colspan="4">
				<input type="hidden" name="sortsub" value="1" />
				<input type="submit" value=" Change " class="btn btn-warning">
			</td>
		</tr>
		<?
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
