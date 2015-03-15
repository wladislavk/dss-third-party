<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include "includes/top.htm";

	if(is_billing($_SESSION['admin_access'])){
?>
		<h2>You are not authorized to view this page.</h2>
<?php
  		die();
	}


$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select ac.*, p.name, (SELECT count(u.userid) FROM dental_users u WHERE u.access_code_id=ac.id) as num_users from dental_access_codes ac 
	LEFT JOIN dental_plans p ON p.id=ac.plan_id";
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
	Manage Access Codes
</div>
<br />
<br />

<?php if(is_super($_SESSION['admin_access'])){ ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_access_code.php');" class="btn btn-success">
		Add New Access Code
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
			Access Code		
		</td>
		<td valign="top" class="col_head" width="60%">
			Notes
		</td>
		<td valign="top" class="col_head" width="10%">
			# Users
		</td>
		<td valign="top" class="col_head" width="10%">
                        Plan
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
				$tr_class = "";
			}
			else
			{
				$tr_class = "warning";
			}
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($myarray["access_code"]);?>
				</td>
				<td valign="top">
					<?php echo  $myarray['notes']; ?>
				</td>		
				<td valign="top" align="center">
						<a href="#" onclick="$('.users_<?php echo $myarray['id'];?>').toggle();"><?php echo  $myarray['num_users']; ?></a>
				</td>
                                <td valign="top">
                                        <?php echo  $myarray['name']; ?>
                                </td>	
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_access_code.php?ed=<?php echo $myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
			<?php
				$u_sql = "SELECT * FROM dental_users WHERE access_code_id='".mysqli_real_escape_string($con,$myarray["id"])."'";
				$u_q = mysqli_query($con,$u_sql);
				while($u_r = mysqli_fetch_assoc($u_q)){
			?>
			<tr class="users_<?php echo $myarray['id'];?>" style="display:none;">
			  <td><?php echo  $u_r['first_name']." ".$u_r['last_name']; ?></td>
			  <td><?php echo  $u_r['username']; ?></td>
			  <td><?php echo  ($u_r['adddate'])?date('m/d/Y h:m a', strtotime($u_r['adddate'])):""; ?></td>
			  <td></td>
			</tr>
			<?php } ?>
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
