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
  $sql = "SELECT i.*, du.username, du.first_name, du.last_name, c.name as company_name, du.cc_id,
		(SELECT COUNT(*) FROM dental_charge WHERE invoice_id = i.id) bill_attempts,
		(SELECT charge_date from dental_charge WHERE invoice_id = i.id order by charge_date DESC limit 1) bill_date
                FROM dental_percase_invoice i
		JOIN dental_users du ON du.userid = i.docid
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
		WHERE i.status=2
		";
}else{
  $sql = "SELECT du.*, c.name AS company_name,
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

$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Invoicing	
</span>
<br />
<div align="center" class="red" style="clear:both;">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
                <td class="col_head <?= ($_REQUEST['sort'] == 'username')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="14%">
			<a href="manage_payment_errors.php?sort=username&sort_dir=<?php echo ($_REQUEST['sort']=='username'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Username</a>		
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="20%">
                        <a href="manage_payment_errors.php?sort=company&sort_dir=<?php echo ($_REQUEST['sort']=='company'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_payment_errors.php?sort=name&sort_dir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Name</a>		
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'invoice')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_payment_errors.php?sort=invoice&sort_dir=<?php echo ($_REQUEST['sort']=='invoice'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Amount</a>
                </td>
		<td class="col_head">
			Invoice Date
		</td>
		<td class="col_head">
			Last Bill Date
		</td>
		<td class="col_head">
			Bill Attempts
		</td>
		<td valign="top" class="col_head" width="10%">
			History
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
$total_charge = $myarray['monthly_fee_amount'];
$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl                 JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$myarray['userid']."' AND
                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_percase_invoice_extra dl
         WHERE 
                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT CONCAT('Insurance Verification Services – ', patient_firstname, ' ', patient_lastname), invoice_date, '', invoice_amount, id FROM dental_insurance_preauth
        WHERE
                invoice_id='".$myarray['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_fax_invoice        WHERE
                invoice_id='".$myarray['id']."'";
$case_q = mysql_query($case_sql);
while($case_r = mysql_fetch_assoc($case_q)){
$total_charge += $case_r['percase_amount'];
}
                ?>

			<tr class="status_<?= $myarray["status"]; ?>">
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
                                <td valign="top">
                                        <?=st($myarray["company_name"]);?>
                                </td>
                                <td valign="top">
                                        <?=st($myarray["first_name"]." ".$myarray["last_name"]);?>
                                </td>
                                <td valign="top">
$<?php
                                            echo number_format($total_charge, 2); ?>
                                </td>
				<td valign="top">
					<?= ($myarray['adddate'])?date('m/d/y', strtotime($myarray['adddate'])):''; ?>
				</td>
				<td valign="top">
					<?= ($myarray['bill_date'])?date('m/d/y', strtotime($myarray['bill_date'])):''; ?>
				</td>
				<td valign="top">
					<?= $myarray['bill_attempts']; ?>
				</td>
				<td valign="top" align="center">
					<a href="manage_percase_invoice_history.php?docid=<?=$myarray["docid"];?>">History</a>
				</td>	
				<td valign="top">
                                        <?php if($myarray['cc_id']!=''){ ?>
                                        <a href="#" onclick="loadPopup('percase_bill.php?docid=<?=$myarray["docid"];?>&invoice=<?=$myarray["id"];?>'); return false;"  class="button" title="EDIT" style="padding:3px 5px;">
                                                Rebill 
                                        </a>
                                        <?php } ?>
				</td>			
			</tr>
	<? 	}

	}?>
</table>
</form>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
