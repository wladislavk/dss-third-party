<? 
include "includes/top.htm";
require_once '../3rdParty/stripe/lib/Stripe.php';
$sql = "SELECT pi.* FROM dental_percase_invoice pi
	WHERE pi.docid=".mysql_real_escape_string($_GET['docid'])." ORDER BY adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

$doc_sql = "SELECT * from dental_users WHERE userid=".mysql_real_escape_string($_GET['docid']);
$doc_q = mysql_query($doc_sql);
$doc = mysql_fetch_assoc($doc_q);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>


<span class="admin_head">
        Credit Card Billing History - <?= $doc['first_name']; ?> <?= $doc['last_name']; ?>
        <a href="manage_percase_invoice.php" style="float:right; font-size:14px; color: #999; margin-right:10px;">Back to Invoices</a>
</span>
<br />


<div align="center" class="red" style="clear:both;">
        <b><? echo $_GET['msg'];?></b>
</div>

<?php
  $charge_sql = "SELECT * FROM dental_charge
			WHERE userid='".mysql_real_escape_string($_GET['docid'])."'";
  $charge_q = mysql_query($charge_sql);
?>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                        Date
                </td>
                <td valign="top" class="col_head" width="20%">
                        Amount
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
        </tr>
        <? if(mysql_num_rows($charge_q) == 0)
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
                while($charge_r = mysql_fetch_array($charge_q))
                {
                ?>
                        <tr>
                                <td valign="top">
                                        <?=st(date('m/d/Y g:i a', strtotime($charge_r["charge_date"])));?>
                                </td>
                                <td valign="top" style="font-weight:bold;">
                                        $<?php
                                            echo st($charge_r["amount"]); ?>
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
$key_sql = "SELECT stripe_secret_key FROM companies c 
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='".mysql_real_escape_string($_GET['docid'])."'";
$key_q = mysql_query($key_sql);
$key_r= mysql_fetch_assoc($key_q);

Stripe::setApiKey($key_r['stripe_secret_key']);

try{
  $charge = Stripe_Charge::retrieve($charge_r["stripe_charge"]);
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $body = $e->getJsonBody();
  $err  = $body['error'];       
  echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
  //die();

}
echo $charge->card->last4;
?>
				</td>

                        </tr>
        <?      }

        }?>
</table>
</form>


<br /><br />

<span class="admin_head">
        Per-case Invoice History - <?= $doc['first_name']; ?> <?= $doc['last_name']; ?>
        <a href="manage_percase_invoice.php" style="float:right; font-size:14px; color: #999; margin-right:10px;">Back to Invoices</a>
</span>
<br />


<div align="center" class="red" style="clear:both;">
        <b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
                dl.docid='".$myarray['docid']."' AND                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_percase_invoice_extra dl         WHERE 
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
$case_q = mysql_query($case_sql);
		$case = mysql_fetch_assoc($case_q);
		?>
			<tr class="status_<?= $myarray['status']; ?>">
				<td valign="top">
					<?=st(date('m/d/Y g:i a', strtotime($myarray["adddate"])));?>
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
					<a href="../q_file/percase_invoice_<?= $myarray['docid'];?>_<?= $myarray['id']; ?>.pdf" class="button" title="EDIT" style="padding:3px 5px;" target="_blank">
						View
					</a>
                    
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
