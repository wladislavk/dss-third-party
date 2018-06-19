<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";

if(!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access']))
{
	$del_sql = "delete from dental_exam_teeth where exam_teethid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"])) {
    $index_val = $_REQUEST["page"];
} else {
    $index_val = 0;
}
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_exam_teeth order by sortby";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = mysqli_query($con,$sql);

if(!empty($_POST['sortsub']) && $_POST['sortsub'] == 1)
{
	foreach($_POST['sortby'] as $val)
	{
		$smyarray = mysqli_fetch_array($my);
		
		if($val == '' || is_numeric($val) === false)
		{
			$val = 999;
		}
		
		$up_sort_sql = "update dental_exam_teeth set sortby='".s_for($val)."' where exam_teethid='".$smyarray["exam_teethid"]."'";
		mysqli_query($con,$up_sort_sql);
	}
	$msg = "Sort By Changed Successfully";
	?>
	<script type="text/javascript">
		window.location.replace("<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>");
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Teeth Examination
</div>
<br />
<br />

<?php if(is_super($_SESSION['admin_access'])){ ?>
<div align="right">
	<button onclick="loadPopup('add_exam_teeth.php');" class="btn btn-success">
		Add New Teeth Examination
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
&nbsp;
<b>Total Records: <?php echo $total_rec;?></b>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
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
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="80%">
			Teeth Examination		
		</td>
		<td valign="top" class="col_head" width="10%">
			Sort By 
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
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($myarray["exam_teeth"]);?>
				</td>
				
				<td valign="top" align="center">
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					<input type="text" name="sortby[]" value="<?php echo st($myarray['sortby'])?>" class="form-control text-center" style="width:5em"/>
					<?php }else{ ?>
						<?php echo  $myarray['sortby']; ?>
					<?php } ?>
				</td>	
						
				<td valign="top">
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					<a href="Javascript:;"  onclick="loadPopup('add_exam_teeth.php?ed=<?php echo $myarray["exam_teethid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    			<?php } ?>
				</td>
			</tr>
	<?php 	}
		?>
		<tr>
			<td valign="top" class="col_head" colspan="1">&nbsp;</td>
			<td valign="top" class="col_head" colspan="4">
				<?php if(is_super($_SESSION['admin_access'])){ ?>
				<input type="hidden" name="sortsub" value="1" />
				<input type="submit" value=" Change " class="btn btn-warning">
				<?php } ?>
			</td>
		</tr>
		<?php
	} ?>
</table>
</form>

<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
