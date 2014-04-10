<? 
include "includes/top.htm";
include_once 'includes/edx_functions.php';
if($_REQUEST["delid"] != "" && is_super($_SESSION['admin_access']))
{

	$sql = "SELECT cc_id, edx_id FROM dental_users where userid='".$_REQUEST["delid"]."'";
	$q = mysql_query($sql);
	$r = mysql_fetch_assoc($q);

	$del_sql = "delete from dental_users where userid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
        edx_user_delete($r['edx_id']);

	if($r['cc_id']!=''){
	require_once '../3rdParty/stripe/lib/Stripe.php';
	$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysql_real_escape_string($_REQUEST['delid'])."'";
	$key_q = mysql_query($key_sql);
	$key_r= mysql_fetch_assoc($key_q);

	Stripe::setApiKey($key_r['stripe_secret_key']);

        try{
	  $cu = Stripe_Customer::retrieve($r['cc_id']);
	  $cu->delete();
        } catch(Stripe_CardError $e) {
	  // Since it's a decline, Stripe_CardError will be caught
	  $body = $e->getJsonBody();
	  $err  = $body['error'];
	  echo $err['message'];
	} catch (Stripe_InvalidRequestError $e) {
	  // Invalid parameters were supplied to Stripe's API
	  $body = $e->getJsonBody();
	  $err  = $body['error'];
	  echo $err['message'];
	} 
	}
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
if(is_super($_SESSION['admin_access'])){
$sql = "select u.*, c.id as company_id, c.name as company_name, p.name as plan_name from dental_users u
	LEFT JOIN dental_user_company uc ON uc.userid = u.userid
        LEFT JOIN companies c ON c.id=uc.companyid
	LEFT JOIN dental_plans p ON p.id=u.plan_id
		 where u.user_access=2 ";
if(isset($_GET['cid'])){
  $sql .= " AND c.id='".mysql_real_escape_string($_GET['cid'])."' ";
}
	 $sql .= " order by u.last_name, u.first_name";
}elseif(is_admin($_SESSION['admin_access'])){
  $sql = "SELECT u.*, c.id as company_id, c.name AS company_name, p.name as plan_name FROM dental_users u 
		INNER JOIN dental_user_company uc ON uc.userid = u.userid
		INNER JOIN companies c ON c.id=uc.companyid
		LEFT JOIN dental_plans p ON p.id=u.plan_id
		WHERE u.user_access=2 AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'
		ORDER BY u.last_name, u.first_name";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
			JOIN admin a ON a.adminid = ac.adminid
			WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $sql = "SELECT u.*, c.id as company_id, c.name AS company_name, p.name as plan_name FROM dental_users u 
                INNER JOIN dental_user_company uc ON uc.userid = u.userid
                INNER JOIN companies c ON c.id=uc.companyid
        	LEFT JOIN dental_plans p ON p.id=u.plan_id
                WHERE u.user_access=2 AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."'
                ORDER BY u.last_name, u.first_name";
}
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

//$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Users
</div>
<br />
<br />

<?php
  if(isset($_GET['cid'])){
?>
<div style="float:left; margin-left:20px;">
        <a href="manage_users.php" class="btn btn-success">
                View All 
        </a>
        &nbsp;&nbsp;
</div>
<?php
  }
?>

<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
<!--<div align="right">
        <button onclick="Javascript: loadPopup('add_users_reg.php');" class="btn btn-success">
                Add New Registration User
                <span class="glyphicon glyphicon-plus">
        </button>
        &nbsp;&nbsp;
</div>
-->
<div align="right">
	<button onclick="Javascript: loadPopup('add_users.php');" class="btn btn-success">
		Add New User
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
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
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Username	
		</td>
		<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
		<td valign="top" class="col_head" width="20%">
			Letterhead
		</td>       
		<td valign="top" class="col_head" width="10%">
			Login As
		</td>
		<?php } ?>
		<td valign="top" class="col_head" width="8%">
			Locations
		</td>
		<td valign="top" class="col_head" width="8%">
			Contact
		</td>
		<td valign="top" class="col_head" width="8%">
			Staff
		</td>
		<td valign="top" class="col_head" width="8%">
		 	Patients	
		</td>
		<td valign="top" class="col_head" width="8%">
		 	Invoices	
		</td>
		<?php if(is_super($_SESSION['admin_access'])){ ?>
		<td valign="top" class="col_head" width="10%">
                        Company 
                </td>
		<?php } ?>
                <td valign="top" class="col_head" width="10%">
                        Plan
                </td>
		<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
		<?php } ?>
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
			$staff_sql = "select count(userid) as staff_count from dental_users where docid='".st($myarray['userid'])."' and user_access=1";
			$staff_my = mysql_query($staff_sql) or die(mysql_error()." | ".$staff_sql);
			$staff_myarray = mysql_fetch_array($staff_my);
			
			$con_sql = "select count(contactid) as con_count from dental_contact where docid='".st($myarray['userid'])."'";
			$con_my = mysql_query($con_sql) or die(mysql_error()." | ".$con_sql);
			$con_myarray = mysql_fetch_array($con_my);

                        $loc_sql = "select count(id) as loc_count from dental_locations where docid='".st($myarray['userid'])."'";
                        $loc_my = mysql_query($loc_sql) or die(mysql_error()." | ".$loc_sql);
                        $loc_myarray = mysql_fetch_array($loc_my);

                        $pat_sql = "select count(patientid) as pat_count from dental_patients where docid='".st($myarray['userid'])."' ";
                        $pat_my = mysql_query($pat_sql) or die(mysql_error()." | ".$pat_sql);
                        $pat_myarray = mysql_fetch_array($pat_my);

                        $inv_sql = "select count(id) as inv_count from dental_percase_invoice where docid='".st($myarray['userid'])."' ";
                        $inv_my = mysql_query($inv_sql) or die(mysql_error()." | ".$inv_sql);
                        $inv_myarray = mysql_fetch_array($inv_my);
			
			if($myarray["status"] == 1)
			{
				$tr_class = "";
			}
			elseif($myarray["status"] == 2)
			{
				$tr_class = "info";
			}
                        elseif($myarray["status"] == 3)
                        {
                                $tr_class = "warning";
                        }
			else
			{
				$tr_class = "info";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["first_name"]. " " .$myarray["last_name"]);?>
				</td>
				<td valign="top">
					<?php if($myarray["status"] == 2){
					  echo "Registration emailed: ".(($myarray["registration_email_date"]!='')?date('m/d/Y H:i a', strtotime($myarray["registration_email_date"])):'');
					}else{ ?>
					  <?=st($myarray["username"]);?>
					<?php } ?>
				<?php if($myarray["status"] == 3){ ?>
					<br />
					Activated on: <?= ($myarray['adddate'])?date('m/d/Y',strtotime($myarray['adddate'])):''; ?>
					<br />
					Suspended on: <?= ($myarray['suspended_date'])?date('m/d/Y',strtotime($myarray['suspended_date'])):''; ?>
					<br />
					Suspended Reason: <?= $myarray['suspended_reason']; ?>
				<?php } ?>
				</td>
				<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
				<td valign="top">
					<a href="/manage/admin/letterhead.php?uid=<?=st($myarray["userid"]);?>">Update Images</a>
				</td>
				
				<td valign="top">
					<?php if($myarray['status']!=2){ ?>
					<form action="login_as.php" method="post" target="Doctor_Login">
						<input type="hidden" name="username" value="<?=st($myarray["username"]);?>">
						<input type="hidden" name="password" value="<?=st($myarray["password"]);?>">
			            <input type="hidden" name="loginsub" value="1">
			            <input type="submit" name="btnsubmit" value=" Login " class="btn btn-success">			
					</form>
					<?php } ?>
				</td>
				<?php } ?>
			           <td valign="top" align="center">
                    <a href="manage_locations.php?docid=<?=$myarray["userid"];?>" class="btn btn-danger pull-right" title="locations">
                        <?=st($loc_myarray['loc_count']);?></a>
                                </td>	
                
				<td valign="top" align="center">
                    <a href="manage_contact.php?docid=<?=$myarray["userid"];?>" class="btn btn-danger pull-right" title="contacts">
                    	<?=st($con_myarray['con_count']);?></a>
				</td>	
                
				<td valign="top" align="center">
					<a href="manage_staff.php?docid=<?=$myarray["userid"];?>" class="btn btn-danger pull-right" title="staff">
                    	<?=st($staff_myarray['staff_count']);?></a>
				</td>	
                                <td valign="top" align="center">
                        <?=st($pat_myarray['pat_count']);?>
                                </td>
                                <td valign="top" align="center">
                        <a href="manage_percase_invoice_history.php?docid=<?= $myarray["userid"]; ?>"><?=st($inv_myarray['inv_count']);?></a>
                                </td>

				<?php if(is_super($_SESSION['admin_access'])){ ?>
			 	<td valign="top" align="center">
                                        	<a href="manage_users.php?cid=<?= $myarray["company_id"]; ?>"><?= $myarray["company_name"]; ?></a>
				</td>			
				<?php } ?>
                                <td valign="top" align="center">
                                                <?= $myarray["plan_name"]; ?>
                                </td>
				<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_users.php?ed=<?=$myarray["userid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
				<?php } ?>
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
