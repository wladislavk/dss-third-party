<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
require_once '../3rdParty/stripe/lib/Stripe.php';
$sql = "SELECT pi.* FROM dental_percase_invoice pi
	WHERE 
		pi.status != '".DSS_INVOICE_PENDING."'
		AND
		pi.docid=".mysqli_real_escape_string($con,$_GET['docid'])." ORDER BY adddate DESC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

if (!isset($rec_disp)) {
    $rec_disp = 1;
}

$no_pages = $total_rec/$rec_disp;

$my = mysqli_query($con,$sql);
$num_users = mysqli_num_rows($my);

$doc_sql = "SELECT * from dental_users WHERE userid=".mysqli_real_escape_string($con,$_GET['docid']);
$doc_q = mysqli_query($con,$doc_sql);
$doc = mysqli_fetch_assoc($doc_q);




    $key_sql = "SELECT stripe_secret_key FROM companies c
        JOIN dental_user_company uc
        ON c.id = uc.companyid
        WHERE uc.userid='".mysqli_real_escape_string($con,$_GET['docid'])."'";

    $key_q = mysqli_query($con,$key_sql);
    $key_r= mysqli_fetch_assoc($key_q);

    Stripe::setApiKey($key_r['stripe_secret_key']);
if($doc['cc_id']!=''){
$cards = Stripe_Customer::retrieve($doc['cc_id'])->cards->all();
$last4 = $cards['data'][0]['last4'];
}
?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>





<div class="page-header">
        <h2>Invoice History <small> - <?php echo  $doc['first_name']; ?> <?php echo  $doc['last_name']; ?>
	<?php if(!empty($last4)){
	?> - Current Card Ending <?php
		echo $last4;
	} ?>
        <a href="manage_percase_invoice.php" style="float:right; font-size:14px; color: #999; margin-right:10px;">Back to Invoices</a>
</small></h2></div>
<br />


<div align="center" class="red" style="clear:both;">
        <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<?php 
$sql = "SELECT * FROM dental_users where userid='".mysqli_real_escape_string($con,$_GET['docid'])."'";
$q = mysqli_query($con,$sql);
$myarray = mysqli_fetch_assoc($q);
?>
<div class="pull-right">
                                  <?php if($myarray["status"]==1){ ?>
                                        <a href="invoice_additional.php?show=1&docid=<?php echo $myarray["userid"];?>" class="btn btn-primary" title="Create Invoice" style="padding:3px 5px;">
                                                Create
                                        </a>
                                        <?php if($myarray['cc_id']!=''){ ?>
                                        <a href="#" onclick="loadPopup('percase_bill.php?docid=<?php echo $myarray["userid"];?>'); return false;" class="btn btn-primary" title="Charge Credit Card" style="padding:3px 5px;">
                                                Charge Card
                                        </a>
                                        <?php } ?>
                                  <?php }else{ ?>
                                        <a href="#" onclick="alert('Error! This user is INACTIVE. You can only bill and invoice invoice active users.'); return false;" class="btn btn-primary" title="Create Invoice" style="padding:3px 5px;">
                                                Create
                                        </a>
                                        <?php if($myarray['cc_id']!=''){ ?>
                                        <a href="#" onclick="alert('Error! This user is INACTIVE. You can only bill and invoice invoice active users.'); return false;" class="btn btn-primary" title="Charge Credit Card" style="padding:3px 5px;">
                                                Charge Card
                                        </a>
                                        <?php } ?>
                                  <?php } ?>
</div>
<div class="clearfix"></div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
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
$total_charge = $myarray['monthly_fee_amount'] + $myarray['producer_fee_amount'];
$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl                 JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$myarray['docid']."' AND                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_claim_electronic e 
        WHERE 
                e.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, insuranceid FROM dental_insurance i         WHERE 
                i.percase_invoice='".$myarray['id']."'
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
                invoice_id='".$myarray['id']."'
        UNION
SELECT new_fee_desc,
new_fee_date, '', new_fee_amount, patientid FROM dental_patients
        WHERE
                new_fee_invoice_id='".$myarray['id']."'
";
$case_q = mysqli_query($con,$case_sql);
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
$case_q = mysqli_query($con,$case_sql);
		$case = mysqli_fetch_assoc($case_q);
		?>
			<tr class="status_<?php echo  $myarray['status']; ?>">
				<td valign="top">
					<?php echo ($myarray['due_date']!='')?date('m/d/Y', strtotime($myarray["due_date"])):'';?>
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
					<a href="display_file.php?f=percase_invoice_<?php echo  $myarray['docid'];?>_<?php echo  $myarray['id']; ?>.pdf" class="btn btn-primary" title="EDIT" style="padding:3px 5px;" target="_blank">
						View
					</a>
				</td>
			</tr>
	<?php 	}

	}?>
</table>
</form>

<br><br>

<div class="page-header">
        <h2>Credit Card Billing History <small>- <?php echo  $doc['first_name']; ?> <?php echo  $doc['last_name']; ?>
        <a href="manage_percase_invoice.php" style="float:right; font-size:14px; color: #999; margin-right:10px;">Back to Invoices</a>
</small></h2></div>
<br />


<div align="center" class="red" style="clear:both;">
        <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<?php
  $charge_sql = "SELECT * FROM dental_charge
			WHERE userid='".mysqli_real_escape_string($con,$_GET['docid'])."'";
  $charge_q = mysqli_query($con,$charge_sql);
?>


<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                        Date
                </td>
                <td valign="top" class="col_head" width="20%">
                        Amount
                </td>
                <td valign="top" class="col_head" width="20%">
                        Refund
                </td>
                <td valign="top" class="col_head" width="30%">
                        Customer 
                </td>
                <td valign="top" class="col_head" width="30%">
                        Charge
                </td>
		<td valign="top" class="col_head" width="20%">
			Card
		</td>
		<td valign="top" class="col_head" width="20%">
			Refund
		</td>
        </tr>
        <?php if(mysqli_num_rows($charge_q) == 0)
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
                while($charge_r = mysqli_fetch_array($charge_q))
                {
	
                ?>
                        <tr>
                                <td valign="top">
                                        <?php echo st(date('m/d/Y g:i a', strtotime($charge_r["charge_date"])));?>
                                </td>
                                <td valign="top" style="font-weight:bold;">
                                        $<?php
                                            echo st($charge_r["amount"]); ?>
                                </td>
                                <td valign="top" style="font-weight:bold;">
					<?php $r_sql = "SELECT SUM(amount) refund FROM dental_refund WHERE charge_id='".mysqli_real_escape_string($con,$charge_r['id'])."'";
						$r_q = mysqli_query($con,$r_sql);
						$refund = mysqli_fetch_assoc($r_q);
						?>
                                        $<?php
                                            echo number_format($refund["refund"], 2); ?>
                                </td>
                                <td valign="top" style="font-weight:bold;">
                                        <a href="https://manage.stripe.com/customers/<?php
                                           echo st($charge_r["stripe_customer"]); ?>" target="_blank">
						<?php
                                           echo st($charge_r["stripe_customer"]); ?>
					</a>
                                </td>

                                <td valign="top" style="font-weight:bold;">
                                        <a href="https://manage.stripe.com/payments/<?php
                                           echo st($charge_r["stripe_charge"]); ?>" target="_blank">
                                                <?php
                                           echo st($charge_r["stripe_charge"]); ?>
                                        </a>

                                </td>
				<td valign="top">
	                                <?php
if($charge_r['stripe_charge']!=''){
$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysqli_real_escape_string($con,$_GET['docid'])."'";
$key_q = mysqli_query($con,$key_sql);
$key_r= mysqli_fetch_assoc($key_q);

Stripe::setApiKey($key_r['stripe_secret_key']);

try{
  $charge = Stripe_Charge::retrieve($charge_r["stripe_charge"]);
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $body = $e->getJsonBody();
  $err  = $body['error'];       
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
  //trigger_error("Die called", E_USER_ERROR);

}
echo $charge->card->last4;
}
?>
				</td>
				<td>
				        <a href="#" onclick="loadPopup('percase_refund.php?docid=<?php echo $_GET["docid"];?>&cid=<?php echo  $charge_r["id"];?>'); return false;" class="btn btn-primary" title="Refund" style="padding:3px 5px;">
                                                Refund
                                        </a>
				</td>

                        </tr>	
        <?php      }

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
