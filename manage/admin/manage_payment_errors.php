<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

if(is_billing($_SESSION['admin_access'])){
  ?><h2>You are not authorized to view this page.</h2><?php
  die();
}


if(isset($_GET['did']) && $_GET['did']!=''){
  $s = "UPDATE dental_percase_invoice SET status=3 WHERE id='".mysqli_real_escape_string($con,$_GET['did'])."'";
  mysqli_query($con,$s);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
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
<div align="center" class="red" style="clear:both;">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : ''); ?></b>
</div>

&nbsp;
<b>Total Records: <?php echo $total_rec;?></b>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class=" sort_table table table-bordered table-hover">
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
<thead>
	<tr class="tr_bg_h">
                <th class="col_head" width="14%">
			Username
		</th>
                <th class="col_head" width="20%">
			Company
                </th>
                <th class="col_head" width="10%">
			Name
		</th>
                <th class="col_head" width="10%">
			Amount
                </th>
		<th class="col_head">
			Invoice Date
		</th>
		<th class="col_head">
			Last Bill Date
		</th>
		<th class="col_head">
			Bill Attempts
		</th>
		<td valign="top" class="col_head" width="10%">
			History
		</td>
                <td valign="top" class="col_head" width="10%">
                        Action
                </td>

	</tr>
</thead>
<tbody>
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
$total_charge = $myarray['monthly_fee_amount'];
$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl                 JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".(!empty($myarray['userid']) ? $myarray['userid'] : '')."' AND
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
$case_q = mysqli_query($con,$case_sql);
while($case_r = mysqli_fetch_assoc($case_q)){
$total_charge += $case_r['percase_amount'];
}
                ?>

			<tr class="status_<?php echo  $myarray["status"]; ?>">
				<td valign="top">
					<?php echo st($myarray["username"]);?>
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["company_name"]);?>
                                </td>
                                <td valign="top">
                                        <?php echo st($myarray["first_name"]." ".$myarray["last_name"]);?>
                                </td>
                                <td valign="top">
$<?php
                                            echo number_format($total_charge, 2); ?>
                                </td>
				<td valign="top">
					<?php echo  ($myarray['adddate'])?date('m/d/y', strtotime($myarray['adddate'])):''; ?>
				</td>
				<td valign="top">
					<?php echo  ($myarray['bill_date'])?date('m/d/y', strtotime($myarray['bill_date'])):''; ?>
				</td>
				<td valign="top">
					<?php echo  $myarray['bill_attempts']; ?>
				</td>
				<td valign="top" align="center">
					<a href="manage_percase_invoice_history.php?docid=<?php echo $myarray["docid"];?>">History</a>
				</td>	
				<td valign="top">
                                        <?php if($myarray['cc_id']!=''){ ?>
                                        <a href="#" onclick="loadPopup('percase_bill.php?docid=<?php echo $myarray["docid"];?>&invoice=<?php echo $myarray["id"];?>'); return false;" class="btn btn-primary" title="Rebill user" style="padding:3px 5px;">
                                                Rebill 
                                        </a><br /><br />
                                        <?php } ?>
					<?php if(is_admin($_SESSION['admin_access'])){ ?>
					  <a href="manage_payment_errors.php?did=<?php echo $myarray["id"];?>" class="btn btn-warning" title="Delete Charge" onclick="return confirm('This will remove the failed charge from this list and you will no longer be able to access it. Are you sure?');" style="padding:3px 5px;">Delete</a>
					<?php } ?>
				</td>			
			</tr>
	<?php 	}

	}?>
</tbody>
</table>
</form>

<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
