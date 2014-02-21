<? 
include "includes/top.htm";


if(isset($_REQUEST['order_submit'])){
  $parent_id = $_REQUEST['parent_id'];
  mysql_query("DELETE FROM dental_flowsheet_steps_next where parent_id='".mysql_real_escape_string($parent_id)."'");
  $steps = "SELECT id from dental_flowsheet_steps";
  $step_q = mysql_query($steps);
  while($r = mysql_fetch_assoc($step_q)){
    $sort = $_REQUEST['next_'.$r['id']];
    if($sort != ''){
      $n = "INSERT INTO dental_flowsheet_steps_next 
	SET parent_id='".mysql_real_escape_string($parent_id)."',
	  child_id='".$r['id']."',
	  sort_by='".$sort."'";
      mysql_query($n);
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
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<?php
  $sql = "SELECT * FROM dental_flowsheet_steps ORDER BY section ASC, sort_by ASC";
  $q = mysql_query($sql);
  $total_rec = mysql_num_rows($q);
  ?>
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
			Insurance Type		
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<? if($total_rec == 0)
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
		while($myarray = mysql_fetch_array($q))
		{
		?>
			<tr class="section_<?= $myarray['section']; ?>">
				<td valign="top">
					<?=st($myarray["name"]);?>

					<div id="next_<?=$myarray['id'];?>" style="display:none;">
						<form method="post">
						<?php
							$next_sql = "select step.*, lookup.sort_by as next_order from dental_flowsheet_steps step
								LEFT JOIN dental_flowsheet_steps_next lookup on step.id=lookup.child_id AND lookup.parent_id='".$myarray['id']."'
								ORDER BY next_order ASC, step.section ASC, step.sort_by ASC";
							$next_q = mysql_query($next_sql);
							while($next = mysql_fetch_assoc($next_q)){ ?>
								<?php if(is_super($_SESSION['admin_access'])){ ?>
								<input name="next_<?= $next['id']; ?>" type="text" maxlength="2" style="width:20px;" value="<?= $next['next_order']; ?>" />
								<?= $next['name']; ?>
									<br />
								<?php }else{ ?>
									<?php if($next['next_order']){ ?>
									<?= $next['next_order']; ?>
									<?= $next['name']; ?>
									<br />
									<?php } ?>
								<?php } ?>
					<?php		}
						?>
						<?php if(is_super($_SESSION['admin_access'])){ ?>
						<input type="hidden" name="parent_id" value="<?= $myarray['id']; ?>" />
						<input type="submit" name="order_submit" value="Save order" />
						<?php } ?>
						</form>
					</div>

				</td>
						
				<td valign="top">
					<a href="Javascript:;"  onclick="$('#next_<?= $myarray['id'];?>').toggle()" title="Edit" class="btn btn-primary btn-sm">
						<?php if(is_super($_SESSION['admin_access'])){ ?>
							Change Next	
						<?php }else{ ?>
							View Next
						<?php } ?>
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
			</tr>
	<? 	}
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
