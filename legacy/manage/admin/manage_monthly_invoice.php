<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

    if(is_billing($_SESSION['admin_access'])){
?>
        <h2>You are not authorized to view this page.</h2>
<?php
        trigger_error("Die called", E_USER_ERROR);
    }


$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
  $sql = "SELECT du.*, c.name AS company_name, c.id AS company_id, p.name as plan_name,
		(SELECT COUNT(i.id) FROM dental_percase_invoice i WHERE i.docid=du.userid) AS num_invoices,
		(SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                	JOIN dental_patients dp ON dl.patientid=dp.patientid
        		WHERE 
                		dl.transaction_code='E0486' AND
                		dl.docid=du.userid AND
                		dl.percase_status = '".DSS_PERCASE_PENDING."') AS num_case, 
		(SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                	JOIN dental_patients dp ON dl.patientid=dp.patientid
        		WHERE 
                		dl.transaction_code='E0486' AND
                		dl.docid=du.userid AND
                		dl.service_date > DATE_SUB(now(), INTERVAL 30 DAY)) as num_case30,
		(SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
		JOIN dental_plans p ON p.id=du.plan_id
                WHERE du.status=1 AND du.docid=0 AND ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
		((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.docid=du.userid AND i2.invoice_type='".mysqli_real_escape_string($con,DSS_INVOICE_TYPE_SU_FO)."' ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND DATE_ADD(du.adddate, INTERVAL p.trial_period DAY) < now()))
		";
  if(isset($_GET['company']) && $_GET['company'] != ""){
        $sql .= " AND c.id='".mysqli_real_escape_string($con,$_GET['company'])."' ";
  }

}else{
  $sql = "SELECT du.*, c.name AS company_name, p.name as plan_name,
                (SELECT COUNT(i.id) FROM dental_percase_invoice i WHERE i.docid=du.userid) AS num_invoices,
                (SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.percase_status = '".DSS_PERCASE_PENDING."') AS num_case, 
                (SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                        JOIN dental_patients dp ON dl.patientid=dp.patientid
                        WHERE 
                                dl.transaction_code='E0486' AND
                                dl.docid=du.userid AND
                                dl.service_date > DATE_SUB(now(), INTERVAL 30 DAY)) as num_case30 
		FROM dental_users du 
		JOIN dental_user_company uc ON uc.userid = du.userid
		JOIN companies c ON c.id=uc.companyid
		LEFT JOIN dental_plans p ON p.id = du.plan_id
		WHERE du.docid=0 AND uc.companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'";
}

$sort_dir = (isset($_REQUEST['sort_dir']))?strtolower($_REQUEST['sort_dir']):'';
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : '';
$sort_by_sql = '';
switch ($sort_by) {
  case "company":
    $sort_by_sql = "company_name $sort_dir";
    break;
  case "plan":
    $sort_by_sql = "plan_name $sort_dir";
    break;
  case "name":
    $sort_by_sql = "du.name $sort_dir";
    break;
  case "case30":
    $sort_by_sql = "num_case30 $sort_dir";
    break;
  case "case":
    $sort_by_sql = "num_case $sort_dir";
    break;
  case "invoice":
    $sort_by_sql = "num_invoices $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "du.username $sort_dir";
    break;
}

$sql .= " ORDER BY ".$sort_by_sql;

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
	Invoicing	
</div>
<br />
<div class="row text-center">
    <div class="col-md-4">
        <a class="btn btn-sm btn-info" href="invoice_monthly.php?bill=0<?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice Monthly Only
            <span class="glyphicon glyphicon-envelope"></span>
        </a>
        <a class="btn btn-sm btn-primary" href="invoice_monthly.php?bill=1<?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice And Bill Monthly Only
            <span class="glyphicon glyphicon-usd"></span>
        </a>
    </div>
    <div class="col-md-4 text-center">
        <a class="btn btn-sm btn-info" href="invoice_additional.php?show=all&bill=0<?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice All
            <span class="glyphicon glyphicon-envelope"></span>
        </a>
        <a class="btn btn-sm btn-primary" href="invoice_additional.php?show=all&bill=1<?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice And Bill All
            <span class="glyphicon glyphicon-usd"></span>
        </a>
    </div>
    <div class="col-md-4 text-right">
        <a class="btn btn-sm btn-info" href="invoice_additional.php?bill=0<?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice Additional
            <span class="glyphicon glyphicon-envelope"></span>
        </a>
        <a class="btn btn-sm btn-primary" href="invoice_additional.php?bill=1<?php echo  (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice And Bill Additional
            <span class="glyphicon glyphicon-usd"></span>
        </a>
    </div>
</div>
<div align="center" class="red" style="clear:both;">
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
				 paging($no_pages,$index_val,"sort=".$_GET['sort']."&sort_dir=".$_GET['sort_dir']);
			?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'username')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="14%">
			<a href="manage_percase_invoice.php?sort=username&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='username'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Username</a>		
		</td>
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="20%">
                        <a href="manage_percase_invoice.php?sort=company&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='company'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
                </td>
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'plan')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="20%">
                        <a href="manage_percase_invoice.php?sort=plan&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='plan'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Plan</a>
                </td>
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=name&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='name'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Name</a>		
		</td>
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'case30')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=case30&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='case30'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">E0486 (Last 30 days)</a>
                </td>
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'case')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=case&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='case'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Unbilled E0486</a>		
		</td>
                <td class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'invoice')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=invoice&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='invoice'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>"># Invoices</a>
                </td>
		<td valign="top" class="col_head" width="10%">
			History
		</td>
		<td valign="top" class="col_head" width="8%">
			Created Date
		</td>
		<td valign="top" class="col_head" width="8%">
                        Last Monthly Bill Date
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
		?>
			<tr class="status_<?php echo  $myarray["status"]; ?>">
				<td valign="top">
					<?php echo st($myarray["username"]);?>
				</td>
                                <td valign="top">
                                        <a href="manage_monthly_invoice.php?company=<?php echo $myarray["company_id"]; ?>"><?php echo st($myarray["company_name"]);?></a>
                                </td>
				<td valign="top">
					<?php echo  $myarray['plan_name']; ?>
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["first_name"]." ".$myarray['last_name']);?>
                                </td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php echo st($myarray['num_case30']);?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php
         				    echo st($myarray["num_case"]); ?>
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["num_invoices"]);?>
                                </td>
				<td valign="top" align="center">
					<a href="manage_percase_invoice_history.php?docid=<?php echo $myarray["userid"];?>">History</a>
				</td>	
						
				<td valign="top">
					<?php echo  ($myarray['adddate'])?date('m/d/y', strtotime($myarray['adddate'])):''; ?>
				</td>
                                <td valign="top">
                                        <?php echo  ($myarray['last_monthly_fee_date'])?date('m/d/y', strtotime($myarray['last_monthly_fee_date'])):''; ?>
                                </td>
			</tr>
	<?php 	}

	}?>
</table>
</form>

<br /><br />
<table class="table table-bordered table-hover">
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                        Company
                </td>
                <td valign="top" class="col_head" width="15%">
                        Monthly Fee
                </td>
                <td valign="top" class="col_head" width="15%">
                        Fax Fee
                </td>
                <td valign="top" class="col_head" width="15%">
                        Free Fax
                </td>
                <td valign="top" class="col_head" width="16%">
                        Edit
                </td>
        </tr>
<?php
  $mf_sql = "SELECT id, name, monthly_fee, fax_fee, free_fax FROM companies ORDER BY name ASC";
  $mf_q = mysqli_query($con,$mf_sql);
  while($mf_r = mysqli_fetch_assoc($mf_q)){
  ?>
  <tr>
    <td><?php echo  $mf_r['name']; ?></td>
    <td><?php echo  $mf_r['monthly_fee']; ?></td>
    <td><?php echo  $mf_r['fax_fee']; ?></td>
    <td><?php echo  $mf_r['free_fax']; ?></td>
    <td><a href="#" onclick="loadPopup('monthly_fee_edit.php?ed=<?php echo $mf_r['id']; ?>'); return false;" class="btn btn-primary" style="padding:3px 5px;">Edit</a></td>
  </tr>







  <?php } ?>



</table>
<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
