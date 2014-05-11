<? 
include "includes/top.htm";

if(is_billing($_SESSION['admin_access'])){
  ?><h2>You are not authorized to view this page.</h2><?php
  die();
}


$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
  $sql = "SELECT c.*, p.name as plan_name,
		(SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.companyid=c.id ORDER BY i2.monthly_fee_date DESC LIMIT 1) as last_monthly_fee_date
                FROM companies c
		JOIN dental_plans p ON p.id=c.plan_id
                WHERE c.status=1 AND ((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.companyid=c.id ORDER BY i2.monthly_fee_date DESC LIMIT 1) < DATE_SUB(now(), INTERVAL 1 MONTH) OR 
		((SELECT i2.monthly_fee_date FROM dental_percase_invoice i2 WHERE i2.companyid=c.id ORDER BY i2.monthly_fee_date DESC LIMIT 1) IS NULL AND DATE_ADD(c.adddate, INTERVAL p.trial_period DAY) < now()))
		";
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
		WHERE du.docid=0 AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'";
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
    $sort_by_sql = "c.name $sort_dir";
    break;
}

$sql .= " ORDER BY ".$sort_by_sql;

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
	Invoicing	
</div>
<br />
<div class="row text-center">
    <div class="col-md-4">
        <a class="btn btn-sm btn-info" href="invoice_monthly.php?bill=0<?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice Monthly Only
            <span class="glyphicon glyphicon-envelope"></span>
        </a>
        <a class="btn btn-sm btn-primary" href="invoice_monthly.php?bill=1<?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice And Bill Monthly Only
            <span class="glyphicon glyphicon-usd"></span>
        </a>
    </div>
    <div class="col-md-4 text-center">
        <a class="btn btn-sm btn-info" href="invoice_bo_additional.php?show=all&bill=0<?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice All
            <span class="glyphicon glyphicon-envelope"></span>
        </a>
        <a class="btn btn-sm btn-primary" href="invoice_bo_additional.php?show=all&bill=1<?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice And Bill All
            <span class="glyphicon glyphicon-usd"></span>
        </a>
    </div>
    <div class="col-md-4 text-right">
        <a class="btn btn-sm btn-info" href="invoice_bo_additional.php?bill=0<?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice Additional
            <span class="glyphicon glyphicon-envelope"></span>
        </a>
        <a class="btn btn-sm btn-primary" href="invoice_bo_additional.php?bill=1<?= (isset($_GET['company']) && $_GET['company'] != "")?"&company=".$_GET['company']:""; ?>">
            Invoice And Bill Additional
            <span class="glyphicon glyphicon-usd"></span>
        </a>
    </div>
</div>
<div align="center" class="red" style="clear:both;">
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
				 paging($no_pages,$index_val,"sort=".$_GET['sort']."&sort_dir=".$_GET['sort_dir']);
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
                <td class="col_head <?= ($_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="20%">
                        <a href="manage_percase_invoice.php?sort=company&sort_dir=<?php echo ($_REQUEST['sort']=='company'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'plan')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="20%">
                        <a href="manage_percase_invoice.php?sort=plan&sort_dir=<?php echo ($_REQUEST['sort']=='plan'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Plan</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'case30')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=case30&sort_dir=<?php echo ($_REQUEST['sort']=='case30'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">E0486 (Last 30 days)</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'case')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=case&sort_dir=<?php echo ($_REQUEST['sort']=='case'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Unbilled E0486</a>		
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'invoice')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_percase_invoice.php?sort=invoice&sort_dir=<?php echo ($_REQUEST['sort']=='invoice'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>"># Invoices</a>
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
		?>
			<tr class="status_<?= $myarray["status"]; ?>">
                                <td valign="top">
                                        <a href="manage_monthly_invoice.php?company=<?=$myarray["id"]; ?>"><?=st($myarray["name"]);?></a>
                                </td>
				<td valign="top">
					<?= $myarray['plan_name']; ?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?=st($myarray['num_case30']);?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php
         				    echo st($myarray["num_case"]); ?>
				</td>
                                <td valign="top">
                                        <?=st($myarray["num_invoices"]);?>
                                </td>
				<td valign="top" align="center">
					<a href="manage_percase_bo_invoice_history.php?companyid=<?=$myarray["id"];?>">History</a>
				</td>	
						
				<td valign="top">
					<?= ($myarray['adddate'])?date('m/d/y', strtotime($myarray['adddate'])):''; ?>
				</td>
                                <td valign="top">
                                        <?= ($myarray['last_monthly_fee_date'])?date('m/d/y', strtotime($myarray['last_monthly_fee_date'])):''; ?>
                                </td>
			</tr>
	<? 	}

	}?>
</table>
</form>

<br /><br />
<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
