<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && is_super($_SESSION['admin_access']))
{
	$del_sql = "update dental_plans SET status='0' where id='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_plans order by name ASC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Plans
</div>
<br />
<br />

<?php if(is_super($_SESSION['admin_access'])){ ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_plan.php');" class="btn btn-success">
		Add New Plan
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
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
		<td valign="top" class="col_head" width="20%">
			Name		
		</td>
                <td valign="top" class="col_head" width="10%">
                        Monthly Fee     
                </td>
                <td valign="top" class="col_head" width="10%">
                        Trial Period  
                </td>
                <td valign="top" class="col_head" width="10%">
                        Fax Fee    
                </td>
                <td valign="top" class="col_head" width="10%">
                        Free Fax   
                </td>
		<td valign="top" class="col_head" width="10%">
                        Users 
                </td>
		<td valign="top" class="col_head" width="10%">
			Action
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
			if($myarray["status"] == 1)
			{
				$tr_class = "";
			}
			else
			{
				$tr_class = "warning";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
                                <td valign="top">
                                        $<?=number_format($myarray["monthly_fee"], 2);?>
                                </td>
                                <td valign="top">
                                        <?=st($myarray["trial_period"]);?>
                                </td>
                                <td valign="top">
                                        <?=number_format($myarray["fax_fee"], 2);?>
                                </td>
                                <td valign="top">
                                        <?=st($myarray["free_fax"]);?>
                                </td>
                                <td valign="top">
                                <?php $u_sql = "SELECT * FROM dental_users WHERE plan_id='".mysql_real_escape_string($myarray['id'])."'";
                                        $u_q = mysql_query($u_sql);
                                        $num_u = mysql_num_rows($u_q);
                                ?>
                                        <?= ($num_u > 0)?'<a href="#" onclick="$(\'#pat_'.$myarray['id'].'\').toggle();return false;">'.$num_u.'</a>':$num_u; ?>
                                </td>
				<td valign="top">
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_plan.php?ed=<?=$myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                   			<?php } ?> 
				</td>
			</tr>
			<tr id="pat_<?= $myarray['id']; ?>" style="display:none;">
				<td colspan="7">
				<?php
				while($u = mysql_fetch_assoc($u_q)){
				  echo $u['first_name']." ".$u['last_name']."<br />"; 
				}		
				?>
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
