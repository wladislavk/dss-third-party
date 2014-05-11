<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && is_admin($_SESSION['admin_access']))
{
	$del_sql = "delete from companies where id='".$_REQUEST["delid"]."'";
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
$sql = "select c.*, count(a.adminid) as num_admin, count(b.adminid) as num_users from companies c
	 LEFT JOIN admin_company ac ON ac.companyid = c.id
	 LEFT JOIN admin a ON a.adminid=ac.adminid AND (a.admin_access=".DSS_ADMIN_ACCESS_ADMIN." OR a.admin_access=".DSS_ADMIN_ACCESS_BILLING_ADMIN." OR a.admin_access=".DSS_ADMIN_ACCESS_HST_ADMIN.")
         LEFT JOIN admin b ON b.adminid=ac.adminid AND (b.admin_access=".DSS_ADMIN_ACCESS_BASIC." OR b.admin_access=".DSS_ADMIN_ACCESS_BILLING_BASIC." OR b.admin_access=".DSS_ADMIN_ACCESS_HST_BASIC.")
	 group by c.id
	 order by name ASC";
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
	<b><? echo $_GET['msg'];?></b>
</div>

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
		  	Type
		</td>
		<td valign="top" class="col_head">
			Logo
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="3" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{

		?>
			<tr <?= ($myarray['status']==2)?'class="warning"':''; ?>>
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				<td valign="top">
					<?= st($myarray["num_admin"]); ?>
				</td>	
				<td valign="top">
                                        <?= st($myarray["num_users"]); ?>
                                </td>	
				<td valign="top">
				  <?php 
					if($myarray['company_type']==DSS_COMPANY_TYPE_BILLING){
					$u_sql = "SELECT userid FROM dental_users WHERE billing_company_id='".mysql_real_escape_string($myarray["id"])."'";
					$u_q = mysql_query($u_sql);
					$num_users = mysql_num_rows($u_q);
					?>
					<a href="billing_company_users.php?id=<?= $myarray['id']; ?>"><?= $num_users; ?></a>
					<?php
					}elseif($myarray['company_type']==DSS_COMPANY_TYPE_HST){
                                        $u_sql = "SELECT u.userid FROM dental_users u join dental_user_hst_company uhc ON uhc.userid=u.userid WHERE uhc.companyid='".mysql_real_escape_string($myarray["id"])."'";
                                        $u_q = mysql_query($u_sql);
                                        $num_users = mysql_num_rows($u_q);
                                        ?>
                                        <a href="hst_company_users.php?id=<?= $myarray['id']; ?>"><?= $num_users; ?></a>
                                        <?php
                                        }else{
                                        $u_sql = "SELECT id FROM dental_user_company WHERE companyid='".mysql_real_escape_string($myarray["id"])."'";
                                        $u_q = mysql_query($u_sql);
                                        $num_users = mysql_num_rows($u_q);
                                        ?>
                                        <a href="software_company_users.php?id=<?= $myarray['id']; ?>"><?= $num_users; ?></a>
                                        <?php

					}
				  ?>
				</td>
				<td valign="top">
					<?= $dss_company_type_labels[$myarray["company_type"]];?>
				</td>
                                <td valign="top">
                                        <a href="Javascript:;"  onclick="Javascript: loadPopup('add_company_logo.php?ed=<?=$myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
                                                Edit
                                         <span class="glyphicon glyphicon-pencil"></span></a>

                                </td>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_company.php?ed=<?=$myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="percase_company_invoice.php?cid=<?=$myarray["id"];?>');" title="Edit" class="btn btn-primary btn-sm">
                                                Invoice
                                         <span class="glyphicon glyphicon-pencil"></span></a> 
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
