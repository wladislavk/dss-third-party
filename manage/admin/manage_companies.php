<?php 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]) && is_admin($_SESSION['admin_access']))
{
	$del_sql = "delete from companies where id='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]) ? $_REQUEST["page"] : '')
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select c.*, count(a.adminid) as num_admin, count(b.adminid) as num_users, p.name as plan_name from companies c
	 LEFT JOIN admin_company ac ON ac.companyid = c.id
	 LEFT JOIN admin a ON a.adminid=ac.adminid AND (a.admin_access=".DSS_ADMIN_ACCESS_ADMIN." OR a.admin_access=".DSS_ADMIN_ACCESS_BILLING_ADMIN." OR a.admin_access=".DSS_ADMIN_ACCESS_HST_ADMIN.")
         LEFT JOIN admin b ON b.adminid=ac.adminid AND (b.admin_access=".DSS_ADMIN_ACCESS_BASIC." OR b.admin_access=".DSS_ADMIN_ACCESS_BILLING_BASIC." OR b.admin_access=".DSS_ADMIN_ACCESS_HST_BASIC.")
	 LEFT JOIN dental_plans p ON p.id = c.plan_id
	 group by c.id
	 order by name ASC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con,$sql);
$num_users=mysqli_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Companies 
</div>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_company.php');" class="btn btn-success">
		Add New Company
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

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
		<td valign="top" class="col_head" width="40%">
			Name
		</td>
		<td valign="top" class="col_head">
 			Number of Admins
		</td>
		<td valign="top" class="col_head">
			Number of Users
		</td>
                <td valign="top" class="col_head">
                        Number of Clients
                </td>
                <td valign="top" class="col_head">
                        Billing Plan
                </td>

		<td valign="top" class="col_head">
		  	Type
		</td>
		<td valign="top" class="col_head">
			Logo
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<?php if(mysqli_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="3" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
		while($myarray = mysqli_fetch_array($my))
		{

		?>
			<tr <?php echo  ($myarray['status']==2)?'class="warning"':''; ?>>
				<td valign="top">
					<?php echo st($myarray["name"]);?>
				</td>
				<td valign="top">
					<a href="manage_backoffice.php?cid=<?php echo $myarray['id'];?>"><?php echo  st($myarray["num_admin"]); ?></a>
				</td>	
				<td valign="top">
                                        <a href="manage_backoffice.php?cid=<?php echo $myarray['id'];?>"><?php echo  st($myarray["num_users"]); ?></a>
                                </td>	
				<td valign="top">
				  <?php 
					if($myarray['company_type']==DSS_COMPANY_TYPE_BILLING){
					$u_sql = "SELECT userid FROM dental_users WHERE billing_company_id='".mysqli_real_escape_string($con,$myarray["id"])."'";
					$u_q = mysqli_query($con,$u_sql);
					$num_users = mysqli_num_rows($u_q);
					?>
					<a href="billing_company_users.php?id=<?php echo  $myarray['id']; ?>"><?php echo  $num_users; ?></a>
					<?php
					}elseif($myarray['company_type']==DSS_COMPANY_TYPE_HST){
                                        $u_sql = "SELECT u.userid FROM dental_users u join dental_user_hst_company uhc ON uhc.userid=u.userid WHERE uhc.companyid='".mysqli_real_escape_string($con,$myarray["id"])."'";
                                        $u_q = mysqli_query($con,$u_sql);
                                        $num_users = mysqli_num_rows($u_q);
                                        ?>
                                        <a href="hst_company_users.php?id=<?php echo  $myarray['id']; ?>"><?php echo  $num_users; ?></a>
                                        <?php
                                        }else{
                                        $u_sql = "SELECT id FROM dental_user_company WHERE companyid='".mysqli_real_escape_string($con,$myarray["id"])."'";
                                        $u_q = mysqli_query($con,$u_sql);
                                        $num_users = mysqli_num_rows($u_q);
                                        ?>
                                        <a href="software_company_users.php?id=<?php echo  $myarray['id']; ?>"><?php echo  $num_users; ?></a>
                                        <?php

					}
				  ?>
				</td>
				<td valign="top">
					<?php echo  $myarray["plan_name"];?>
				</td>
				<td valign="top">
					<?php echo  $dss_company_type_labels[$myarray["company_type"]];?>
				</td>
                                <td valign="top">
                                        <a href="Javascript:;"  onclick="Javascript: loadPopup('add_company_logo.php?ed=<?php echo $myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
                                                Edit
                                         <span class="glyphicon glyphicon-pencil"></span></a>

                                </td>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_company.php?ed=<?php echo $myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="invoice_bo_additional.php?show=1&coid=<?php echo $myarray["id"];?>" title="Edit" class="btn btn-primary btn-sm">
                                                Invoice
                                         <span class="glyphicon glyphicon-pencil"></span></a> 
				</td>
			</tr>
	<?php 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
