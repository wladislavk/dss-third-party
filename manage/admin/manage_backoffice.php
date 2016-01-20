<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

$isSuperAdmin = is_super($_SESSION['admin_access']);
$isAdmin = is_admin($_SESSION['admin_access']);
$isCompanyAdmin = is_billing_admin($_SESSION['admin_access']) || is_hst_admin($_SESSION['admin_access']);

$canCreate = $isSuperAdmin || $isAdmin || $isCompanyAdmin;

if(!empty($_REQUEST["delid"]) && is_admin($_SESSION['admin_access']))
{
	$del_sql = "delete from admin where adminid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);

	mysqli_query($con,"DELETE FROM admin_company WHERE adminid='".$_REQUEST["delid"]."'");
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
  $sql = "select a.*, c.id as company_id, c.name as company_name
	 from admin a
	LEFT join admin_company ac ON a.adminid=ac.adminid
	LEFT JOIN companies c ON ac.companyid=c.id";
  if(isset($_GET['cid'])){
    $sql .= " WHERE c.id=".mysqli_real_escape_string($con,$_GET['cid'])." ";
  }
}elseif(is_admin($_SESSION['admin_access'])){
  $sql = "select a.*, c.id as company_id, c.name as company_name
         from admin a
        LEFT join admin_company ac ON a.adminid=ac.adminid
        LEFT JOIN companies c ON ac.companyid=c.id";
    $sql .= " WHERE c.id=".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])." ";
}elseif(is_billing_admin($_SESSION['admin_access'])){
  $sql = "select a.*, c.id as company_id, c.name as company_name
         from admin a
        LEFT join admin_company ac ON a.adminid=ac.adminid
        LEFT JOIN companies c ON ac.companyid=c.id";
    $sql .= " WHERE c.id=".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])." ";

}elseif(is_hst_admin($_SESSION['admin_access'])){
  $sql = "select a.*, c.id as company_id, c.name as company_name
         from admin a
        LEFT join admin_company ac ON a.adminid=ac.adminid
        LEFT JOIN companies c ON ac.companyid=c.id";
    $sql .= " WHERE c.id=".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])." ";

} else {
    $sql = "select a.*, c.id as company_id, c.name as company_name
         from admin a
        LEFT join admin_company ac ON a.adminid=ac.adminid
        LEFT JOIN companies c ON ac.companyid=c.id";
    $sql .= " WHERE a.adminid=".mysqli_real_escape_string($con,$_SESSION['adminuserid'])." ";
}

$sql .= " order by admin_access ASC, username ASC";
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
	Manage Backoffice Users
</div>
<br />
<br />
<?php
  if(isset($_GET['cid'])){
?>
<div style="float:left; margin-left:20px;">
        <a href="manage_backoffice.php" class="btn btn-success">
                View All 
        </a>
        &nbsp;&nbsp;
</div>
<?php
  }
?>

<?php if ($canCreate) { ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_backoffice_users.php');" class="btn btn-success">
		Add New Backoffice User
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>

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
		<td valign="top" class="col_head" width="20%">
			Username	
		</td>
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
		<?php if(is_super($_SESSION['admin_access'])){ ?>
		<td valign="top" class="col_head" width="20%">
			Company
		</td>
		<?php } ?>
		<td valign="top" class="col_head" width="20%">
			Permissions
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
			if($myarray["admin_access"] == 1)
			{
				$tr_class = "tr_super";
			}
			elseif($myarray["admin_access"] == 2)
			{
				$tr_class = "tr_admin";
			}
                        else
                        {
                                $tr_class = "tr_basic";
                        }

		?>
			<tr  <?php echo  ($myarray['status']==2)?'class="warning"':''; ?>> 
				<td valign="top">
					<?php echo st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?php echo st($myarray["first_name"]. " " . $myarray["last_name"]);?>
				</td>
				                <?php if(is_super($_SESSION['admin_access'])){ ?>
				<td valign="top">
					<a href="manage_backoffice.php?cid=<?php echo  $myarray["company_id"]; ?>"><?php echo  $myarray["company_name"]; ?></a>
				</td>
						<?php } ?>
                                <td valign="top">               
					<?php echo  (!empty($dss_admin_access_labels[$myarray["admin_access"]]) ? $dss_admin_access_labels[$myarray["admin_access"]] : ''); ?>
                                </td>		
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_backoffice_users.php?ed=<?php echo $myarray["adminid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
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
