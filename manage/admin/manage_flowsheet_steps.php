<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";


if(isset($_REQUEST['order_submit'])){
  $parent_id = $_REQUEST['parent_id'];
  mysqli_query($con,"DELETE FROM dental_flowsheet_steps_next where parent_id='".mysqli_real_escape_string($con,$parent_id)."'");
  $steps = "SELECT id from dental_flowsheet_steps";
  $step_q = mysqli_query($con,$steps);
  while($r = mysqli_fetch_assoc($step_q)){
    $sort = $_REQUEST['next_'.$r['id']];
    if($sort != ''){
      $n = "INSERT INTO dental_flowsheet_steps_next 
	SET parent_id='".mysqli_real_escape_string($con,$parent_id)."',
	  child_id='".$r['id']."',
	  sort_by='".$sort."'";
      mysqli_query($con,$n);
    }
  }
}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Flowsheet Steps
</div>
<br />
<br />


<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

&nbsp;
<?php
  $sql = "SELECT * FROM dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
  $q = mysqli_query($con,$sql);
  $total_rec = mysqli_num_rows($q);
  ?>
<b>Total Records: <?php echo $total_rec;?></b>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<?php if(!empty($rec_disp) && $total_rec > $rec_disp) {?>
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
		<td valign="top" class="col_head" width="80%">
			Insurance Type		
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<?php if($total_rec == 0)
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
		while($myarray = mysqli_fetch_array($q))
		{
		?>
			<tr class="section_<?php echo  $myarray['section']; ?>">
				<td valign="top">
					<?php echo st($myarray["name"]);?>

					<div id="next_<?php echo $myarray['id'];?>" style="display:none;">
						<form method="post">
						<?php
							$next_sql = "select step.*, lookup.sort_by as next_order from dental_flowsheet_steps step
								LEFT JOIN dental_flowsheet_steps_next lookup on step.id=lookup.child_id AND lookup.parent_id='".$myarray['id']."'
								ORDER BY next_order ASC, step.section ASC, step.sort_by ASC";
							$next_q = mysqli_query($con,$next_sql);
							while($next = mysqli_fetch_assoc($next_q)){ ?>
								<?php if(is_super($_SESSION['admin_access'])){ ?>
								<input name="next_<?php echo  $next['id']; ?>" type="text" maxlength="2" style="width:20px;" value="<?php echo  $next['next_order']; ?>" />
								<?php echo  $next['name']; ?>
									<br />
								<?php }else{ ?>
									<?php if($next['next_order']){ ?>
									<?php echo  $next['next_order']; ?>
									<?php echo  $next['name']; ?>
									<br />
									<?php } ?>
								<?php } ?>
					<?php		}
						?>
						<?php if(is_super($_SESSION['admin_access'])){ ?>
						<input type="hidden" name="parent_id" value="<?php echo  $myarray['id']; ?>" />
						<input type="submit" name="order_submit" value="Save order" class="btn btn-primary">
						<?php } ?>
						</form>
					</div>

				</td>
						
				<td valign="top">
					<a href="Javascript:;"  onclick="$('#next_<?php echo  $myarray['id'];?>').toggle()" title="Edit" class="btn btn-primary btn-sm">
						<?php if(is_super($_SESSION['admin_access'])){ ?>
							Change Next	
						<?php }else{ ?>
							View Next
						<?php } ?>
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
			</tr>
	<?php 	}
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
