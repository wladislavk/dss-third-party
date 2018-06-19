<?php namespace Ds3\Libraries\Legacy;

include "includes/top.htm";

$sql = "SELECT pi.* FROM dental_percase_invoice pi
	WHERE pi.companyid='".$db->escape( $_GET['companyid'])."' AND pi.invoice_type='".$db->escape( DSS_INVOICE_TYPE_SU_BC)."' ORDER BY adddate DESC";
$my=mysqli_query($con, $sql) or trigger_error(mysqli_error($con), E_USER_ERROR);

$c_sql = "SELECT * from companies WHERE id=".$db->escape( $_GET['companyid']);
$c_q = mysqli_query($con, $c_sql);
$company = mysqli_fetch_assoc($c_q);
?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
        <h2>Invoice History <small> - <?= $company['name']; ?> 
        <a href="manage_percase_bo_invoice.php" style="float:right; font-size:14px; color: #999; margin-right:10px;">Back to Invoices</a>
</small></h2></div>
<br />
<div align="center" class="red" style="clear:both;">
        <b><? echo $_GET['msg'];?></b>
</div>
<?php 
$sql = "SELECT * FROM companies where id='".$db->escape( $_GET['companyid'])."'";
$q = mysqli_query($con, $sql);
$myarray = mysqli_fetch_assoc($q);
?>
<div class="pull-right">
                                  <?php if($myarray["status"]==1){ ?>
                                        <a href="invoice_bo_additional.php?show=1&coid=<?=$myarray["id"];?>" class="btn btn-primary" title="Create Invoice" style="padding:3px 5px;">
                                                Create
                                        </a>
                                        <?php if($myarray['cc_id']!=''){ ?>
                                        <a href="#" onclick="loadPopup('percase_bill.php?docid=<?=$myarray["userid"];?>'); return false;" class="btn btn-primary" title="Bill Credit Card" style="padding:3px 5px;">
                                                Bill Card
                                        </a>
                                        <?php } ?>
                                  <?php }else{ ?>
                                        <a href="#" onclick="alert('Error! This user is INACTIVE. You can only bill and invoice invoice active users.'); return false;" class="btn btn-primary" title="Create Invoice" style="padding:3px 5px;">
                                                Create
                                        </a>
                                        <?php if($myarray['cc_id']!=''){ ?>
                                        <a href="#" onclick="alert('Error! This user is INACTIVE. You can only bill and invoice invoice active users.'); return false;" class="btn btn-primary" title="Bill Credit Card" style="padding:3px 5px;">
                                                Bill Card
                                        </a>
                                        <?php } ?>
                                  <?php } ?>
</div>
<div class="clearfix"></div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="40%">
			Date		
		</td>
		<td valign="top" class="col_head" width="20%">
			E0486		
		</td>
                <td valign="top" class="col_head" width="20%">
                        Amount
                </td>
		<td valign="top" class="col_head" width="10%">
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
$total_charge = $myarray['monthly_fee_amount'] + $myarray['user_fee_amount'];
$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl                 JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$myarray['docid']."' AND                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_claim_electronic e 
        WHERE 
                e.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_percase_invoice_extra dl         WHERE 
                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT CONCAT('Insurance Verification Services – ', patient_firstname, ' ', patient_lastname), invoice_date, '', invoice_amount, id FROM dental_insurance_preauth
        WHERE
                invoice_id='".$myarray['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_eligibility_invoice
        WHERE
                invoice_id='".$myarray['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_enrollment_invoice
        WHERE
                invoice_id='".$myarray['id']."'

        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_fax_invoice        WHERE
                invoice_id='".$myarray['id']."'";
$case_q = mysqli_query($con, $case_sql);
while($case_r = mysqli_fetch_assoc($case_q)){
$total_charge += $case_r['percase_amount'];
}
		$case_sql = "SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
        WHERE 
                dl.percase_invoice='".$myarray['id']."'
";
?>
  <style type="text/css">
    tr.status_2 td{
      color:#f33;
    }
  </style>
<?php
$case_q = mysqli_query($con, $case_sql);
		$case = mysqli_fetch_assoc($case_q);
		?>
			<tr class="status_<?= $myarray['status']; ?>">
				<td valign="top">
					<?=($myarray['due_date']!='')?date('m/d/Y', strtotime($myarray["due_date"])):'';?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php
         				    echo st($case["num_trxn"]); ?>
				</td>
                                <td valign="top">
                                        $<?php
                                            echo number_format($total_charge, 2); ?>
                                </td>
				<td valign="top">
					<a href="display_file.php?f=percase_invoice_<?= $myarray['companyid'];?>_<?= $myarray['id']; ?>.pdf" class="btn btn-primary" title="EDIT" style="padding:3px 5px;" target="_blank">
						View
					</a>
                    
				</td>
			</tr>
	<?php 	}
	}?>
</table>
</form>

<br><br>
<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
