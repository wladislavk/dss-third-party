<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/calendarinc.php';

$claimId = intval($_GET['cid']);

$sql = "SELECT *
    FROM dental_ledger_payment dlp
        JOIN dental_ledger dl ON dlp.ledgerid = dl.ledgerid
    WHERE dl.primary_claim_id = '$claimId' OR dl.secondary_claim_id = '$claimId'";
$payments = $db->getRow($sql);

$csql = "SELECT *
    FROM dental_insurance i
    WHERE i.insuranceid = '$claimId'";
$claim = $db->getRow($csql);

$pasql = "SELECT *
    FROM dental_insurance_file
    WHERE claimid = '$claimId'
        AND status IN (".DSS_CLAIM_SENT.", ".DSS_CLAIM_DISPUTE.", ".DSS_CLAIM_SEC_EFILE_ACCEPTED.")";
$num_pa = $db->getNumberRows($pasql);


$sasql = "SELECT *
    FROM dental_insurance_file
    WHERE claimid = '$claimId'
        AND status IN (".DSS_CLAIM_SEC_SENT.", ".DSS_CLAIM_SEC_DISPUTE.", ".DSS_CLAIM_SEC_EFILE_ACCEPTED.")";
$num_sa = $db->getNumberRows($sasql);

?>
<script>
    var DSS_TRXN_PAYER_PRIMARY = <?php echo DSS_TRXN_PAYER_PRIMARY; ?>;
    var dss_trxn_payer_labels_primary = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?>";

    var DSS_TRXN_PAYER_SECONDARY = <?php echo DSS_TRXN_PAYER_SECONDARY; ?>;
    var dss_trxn_payer_labels_secondary = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?>";

    var DSS_TRXN_PAYER_PATIENT = <?php echo DSS_TRXN_PAYER_PATIENT; ?>;
    var dss_trxn_payer_labels_patient = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?>";

    var DSS_TRXN_PAYER_WRITEOFF = <?php echo DSS_TRXN_PAYER_WRITEOFF; ?>;
    var dss_trxn_payer_labels_writeoff = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?>";

    var DSS_TRXN_PAYER_DISCOUNT = <?php echo DSS_TRXN_PAYER_DISCOUNT; ?>;
    var dss_trxn_payer_labels_discount = "<?php echo $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?>";

    var DSS_TRXN_PYMT_CREDIT = <?php echo DSS_TRXN_PYMT_CREDIT; ?>;
    var dss_trxn_pymt_type_labels_credit = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?>";

    var DSS_TRXN_PYMT_DEBIT = <?php echo DSS_TRXN_PYMT_DEBIT; ?>;
    var dss_trxn_pymt_type_labels_debit = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?>";

    var DSS_TRXN_PYMT_CHECK = <?php echo DSS_TRXN_PYMT_CHECK; ?>;
    var dss_trxn_pymt_type_labels_check = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?>";

    var DSS_TRXN_PYMT_CASH = <?php echo DSS_TRXN_PYMT_CASH; ?>;
    var dss_trxn_pymt_type_labels_cash = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?>";

    var DSS_TRXN_PYMT_WRITEOFF = <?php echo DSS_TRXN_PYMT_WRITEOFF; ?>;
    var dss_trxn_pymt_type_labels_writeoff = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?>";

    var DSS_TRXN_PYMT_EFT = <?php echo DSS_TRXN_PYMT_EFT; ?>;
    var dss_trxn_pymt_type_labels_eft = "<?php echo $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT]; ?>";

    jQuery(function($){
        $('[name=empty-claim]').change(function(){
            if (!$('#close:checkbox').is(':checked')) {
                $('#close:checkbox').trigger('click');
            }

            $('#dispute:checkbox').prop('disabled', $(this).is(':checked'));
        });

        $('#close:checkbox').change(function(){
            if ($(this).is(':checked')) {
                $('#dispute').removeAttr('checked');
                $('#ins_attach').show('slow');
                $('#dispute_reason_div').hide('slow');
            } else {
                $('#ins_attach').hide('slow');
                $('#dispute_reason_div').hide('slow');
            }
        });
    });

//CHECK LEDGER PAYMENT SUBMISSION
function validSubmission(f)
{
  returnval = true;
  var alertMessage = '',
      $forceClose = $('[name=empty-claim]');

  if (!authShown) {
  //CHECK PAYMENT IS ENTERED

  // Use a class to mark the valid rows
  $('.payment_amount').removeClass('isValid').each(function(){
    var $payment = $(this),
        $parent = $payment.closest('.claims'),
        $date = $parent.find('[id^=payment_date]'),
        $allowed = $parent.find('.allowed_amount'),
        hasPayment = $payment.val().trim() != '',
        hasAllowed = $allowed.val().trim() != '',
        hasDate = $date.val().trim() != '';

    if (
      ((hasPayment || hasAllowed) && !hasDate) ||
      (hasAllowed && (!hasPayment || !hasDate))
    ) {
      alertMessage = 'Fields "Paid Amount" and "Payment Date" are required for line-items with data entered in other fields.';
      return false;
    }

    if (hasAllowed && !hasPayment && !$forceClose.is(':checked')) {
      alertMessage = 'You did not enter a payment to submit. Please enter a payment or exit payment window. If disputing an unpaid claim enter 0 in payment field.';
      return false;
    }

    if (hasPayment) {
      $payment.addClass('isValid');
    }
  });

  if (!alertMessage.length && !$('.payment_amount.isValid').length && !$forceClose.is(':checked')) {
    alertMessage = 'You did not enter a payment to submit. Please enter a payment or exit payment window. If disputing an unpaid claim enter 0 in payment field.'
  }

  if (alertMessage.length) {
    alert(alertMessage);
    return false;
  }

  //DISPUTE CLAIM
  if(f.dispute.checked){
    //CHECK IF ALREADY DISPUTED
    if(<?php echo  ($claim['status'] == DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE || $claim['status']==DSS_CLAIM_PATIENT_DISPUTE || $claim['status']==DSS_CLAIM_SEC_PATIENT_DISPUTE)?1:0; ?>){
      alert('This claim is already under dispute. Please uncheck the "Dispute" box and resubmit. Please contact the DSS Corporate office if you have further questions regarding your dispute.');
      returnval = false;
    } else if (<?php echo  ($claim['status']==DSS_CLAIM_PENDING || $claim['status']==DSS_CLAIM_SEC_PENDING)?1:0; ?>) {
      alert('A pending claim cannot be disputed. You cannot dispute a claim until it has been sent.');
      returnval = false;
    } else if (f.attachment.value =='') {
      alert('A disputed claim must have attachments from insurance company.');
      returnval = false;
    } else if (f.dispute_reason.value == '') {
      alert('You must provide a reason to dispute a claim.');
      returnval = false;
    } else {
      //Dispute valid
    } 

  //NO DISPUTE
  } else {
      if(<?php echo ($claim['status']==DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE || $claim['status']==DSS_CLAIM_PATIENT_DISPUTE || $claim['status']==DSS_CLAIM_SEC_PATIENT_DISPUTE)?1:0; ?>){
        if(!confirm("You have posted payment to a claim that is currently under dispute. Do you want to change claim status from Dispute to PAID?")){
          alert("You can make changes to the claim but they will not affect the already-submitted dispute. Please contact the DSS Corporate office if you have updates to this disputed claim.");
          returnval =  false;
        }
      }

      //Already status paid
      if(<?php echo  ($claim['status']==DSS_CLAIM_PAID_INSURANCE)?1:0; ?>){
        //VALID    

      //PENDING
      } else if (<?php echo  ($claim['status']==DSS_CLAIM_PENDING)?1:0; ?>) {
         if (f.payer.value==<?php echo  DSS_TRXN_PAYER_PRIMARY; ?>) {
           alert('You listed Primary Insurance as the "Payer" for this transaction. However, the Primary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Primary Insurance. Please choose another Payer.');
           returnval = false;
         } else if (f.payer.value==<?php echo  DSS_TRXN_PAYER_SECONDARY; ?>) {
           alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
           returnval = false;
         } else if (f.close.checked) {
           alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
           returnval = false;
         } else {
           //VALID
         } 
      //SEC PENDING
      } else if (<?php echo  ($claim['status']==DSS_CLAIM_SEC_PENDING)?1:0; ?>) {
        if(f.payer.value==<?php echo  DSS_TRXN_PAYER_PRIMARY;?> && f.close.checked) {
          alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
          returnval = false;
        } else if (f.payer.value!=<?php echo  DSS_TRXN_PAYER_SECONDARY;?> && f.close.checked) {
          alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
          returnval = false;
        } else if (f.payer.value==<?php echo  DSS_TRXN_PAYER_SECONDARY;?>) {
           alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
           returnval = false;
        } else {

        }
      } else if (<?php echo  ($claim['status']==DSS_CLAIM_SENT||$claim['status']==DSS_CLAIM_EFILE_ACCEPTED)?1:0; ?>) {
        if (f.payer.value==<?php echo  DSS_TRXN_PAYER_PRIMARY;?>) {
          if (f.close.checked) {
            if (f.attachment.value =='' && <?php echo  ($num_pa == 0)?1:0; ?>) {
              returnval = false;
              alert('A claim must have an EOB attached to close.');
            }
            //file secondary
            //VALID
          } else {
            if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
          }
        } else if(f.payer.value==<?php echo  DSS_TRXN_PAYER_SECONDARY;?>) {
          alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
          returnval = false;
        } else {
          if(f.close.checked) {
            //VALID      
          } else {
            if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
          }
        }
      } else if (<?php echo  ($claim['status']==DSS_CLAIM_SEC_SENT)?1:0; ?>) {
        if (f.close.checked){
          if (f.attachment.value =='' && <?php echo  ($num_sa == 0)?1:0; ?>) {
              returnval = false;
              alert('A claim must have an EOB attached to close.');
            }
          //VALID
        } else {
          if (!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){
           returnval = false;
          }
        }
      } else {
        //WHAT HAPPENS?
      }
    }
  }

  if (returnval) {
    if(<?php echo ($_SESSION['user_access']==2)?1:0;?>){
      return true;
    } else {
      if (!authShown) {
        return true; //To bypass auth until figured out
        showAuthBox();
        authShown = true;
        return false;
      } else {
        return true;
      }
    }
  } else {
    return returnval;
  }
}

var authShown = false;

function showAuthBox()
{
  document.getElementById('form_div').style.display = 'none';
  document.getElementById('auth_div').style.display = 'block';
}
</script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script language="text/javascript" src="calendar1.js"></script>
<script language="text/javascript" src="calendar2.js"></script>
<script type="text/javascript" src="js/add_ledger_payment.js?v=<?= time() ?>"></script>
<div class="fullwidth">
<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payments.php" onsubmit="return validSubmission(this)" method="POST" enctype="multipart/form-data">
  <div style="width:200px; margin:0 auto; text-align:center;">
    <input type="hidden" value="0" id="currval" />
  </div>
  <?php
  $sql = "SELECT dlp.*, dl.description
      FROM dental_ledger_payment dlp
          JOIN dental_ledger dl ON dlp.ledgerid = dl.ledgerid
      WHERE dl.primary_claim_id = '$claimId' OR dl.secondary_claim_id = '$claimId'";
  $p_sql = $db->getResults($sql);

  if (!count($p_sql)) { ?>
      <div style="margin-left:50px;">No Previous Payments</div>
  <?php } else { ?>
    <table style="width: 98%" border="1">
      <tr>
      <th>Payment Date</th>
      <th>Entry Date</th>
      <th>Description</th>
      <th>Paid By</th>
      <th>Payment Type</th>
      <th>Amount</th>
      <th>Allowed</th>
      <th>Ins. Paid</th>
      <th>Deductible</th>
      <th>Copay</th>
      <th>CoIns</th>
      <th>Overpaid</th>
      <th>Follow-up</th>
      <th>Note</th>
      </tr>
  <?php
      foreach ($p_sql as $p) {
        if (!empty($p['followup']) && strtotime($p['followup']) > 0) {
          $followUp = $p['followup'];
        } else {
          $followUp = '';
        }

        if (!empty($p['payment_date']) && strtotime($p['payment_date']) > 0) {
          $paymentDate = date('m/d/Y', strtotime($p['payment_date']));
        } else {
          $paymentDate = '';
        }
  ?>
    <tr>
      <td><?php echo  $paymentDate; ?></td>
      <td><?php echo  date('m/d/Y', strtotime($p['entry_date'])); ?></td>
      <td><?php echo  $p['description']; ?></td>
      <td><?php echo  $dss_trxn_payer_labels[$p['payer']]; ?></td>
      <td><?php echo  $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></td>
      <td><?php echo  ($p['amount'] > 0 ? $p['amount'] : ""); ?></td>
      <td><?php echo  ($p['amount_allowed'] > 0 ? $p['amount_allowed'] : ""); ?></td>
      <td><?php echo  ($p['ins_paid'] > 0 ?  $p['ins_paid'] : ""); ?></td>
      <td><?php echo  ($p['deductible'] > 0 ? $p['deductible'] : ""); ?></td>
      <td><?php echo  ($p['copay'] > 0 ? $p['copay'] : ""); ?></td>
      <td><?php echo  ($p['coins'] > 0 ? $p['coins'] : ""); ?></td>
      <td><?php echo  ($p['overpaid'] > 0 ? $p['overpaid'] : ""); ?></td>
      <td><?php echo  $followUp; ?></td>
      <td><?php echo  $p['note']; ?></td>
    </tr>

<?php 
  }
?>
    </table>
</br>
</br>
</br>
<?php 
}
?>
<span class="admin_head">
  Add New Claim Payment
</span>
</br>
  <div id="form_div">
    <div id="select_fields" style="margin: 10px;">
      <label>Paid By</label>
      <select id="payer" name="payer" onchange="updateType(this)" style="width:170px;margin: 0pt 10px 0pt 0pt;" >
        <option value="<?php echo  DSS_TRXN_PAYER_PRIMARY; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option>
        <option value="<?php echo  DSS_TRXN_PAYER_SECONDARY; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?></option>
        <option value="<?php echo  DSS_TRXN_PAYER_PATIENT; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?></option>
        <option value="<?php echo  DSS_TRXN_PAYER_WRITEOFF; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?></option>
        <option value="<?php echo  DSS_TRXN_PAYER_DISCOUNT; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></option>
      </select>
      <label>Payment Type</label>
      <select id="payment_type" name="payment_type" style="width:120px;margin: 0pt 10px 0pt 0pt; " >
        <option value="<?php echo  DSS_TRXN_PYMT_CREDIT; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option>
        <option value="<?php echo  DSS_TRXN_PYMT_DEBIT; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option>
        <option selected="selected" value="<?php echo  DSS_TRXN_PYMT_CHECK; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
        <option value="<?php echo  DSS_TRXN_PYMT_CASH; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
          <option value="<?php echo  DSS_TRXN_PYMT_WRITEOFF; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
          <option value="<?php echo  DSS_TRXN_PYMT_EFT; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT]; ?></option>
      </select>
    </div>
    <div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
      <span style="width:80px;margin: 0 10px 0 0; float:left;">Service Date</span>
      <span style="width:180px;margin: 0 10px 0 0; float:left;">Description</span>
      <span style="width:100px;margin: 0 10px 0 0; float:left;">Amount</span>
      <span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Payment Date</span>
      <span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Amount Allowed</span>
      <span style="float:left;font-weight:bold;">Paid Amount</span>
    </div>

    <?php

    $lsql = "SELECT *
        FROM dental_ledger
        WHERE primary_claim_id = '$claimId' OR secondary_claim_id = '$claimId'";
    $lq = $db->getResults($lsql);

    if (!$lq) { ?>
        <p style="text-align: center;">
            <label title="Click here if this claim is faulty and needs to be closed">
                <input type="checkbox" name="empty-claim" value="1" />
                This claim is empty and needs to be forcefully closed
            </label>
        </p>
    <?php }

    foreach ($lq as $row) { ?>
        <div style="height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;" class="claims">
        <span style="width:80px;margin: 0 10px 0 0; float:left;"><?php echo  $row['service_date']; ?></span>
        <span style="width:180px;margin: 0 10px 0 0; float:left;"><?php echo  $row['description']; ?></span>
        <span style="width:100px;margin: 0 10px 0 0; float:left;">$<?php echo  $row['amount']; ?></span>
        <span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">
            <input style="width:140px" readonly class="calendar_top" id="payment_date_<?= $row['ledgerid'] ?>"
                type="text" name="payments[<?= $row['ledgerid'] ?>][0][payment_date]" value="<?= date('m/d/Y') ?>" />
        </span>
        <span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">
            <input style="width:140px" type="text" class="allowed_amount dollar_input"
                name="payments[<?= $row['ledgerid'] ?>][0][amount_allowed]" />
        </span>
        <span style="float:left;font-weight:bold;">
            <input class="payment_amount dollar_input" style="width:140px;" type="text"
                name="payments[<?= $row['ledgerid'] ?>][0][amount]" />
        </span>
    </div>
    <?php } ?>

    <br />
    <input type="checkbox" id="close" name="close" value="1" />
     <label for="close">Close Claim</label>
    <br />
    <input type="checkbox" id="dispute" name="dispute" onclick=" if(this.checked){ $('#close').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').show('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value='1' />
     <label for="dispute">Dispute</label>
    <div id="dispute_reason_div" style="display: none">
      <label>Reason for dispute:</label> <input type="text" name="dispute_reason" />
    </div>
    <div id="ins_attach" style="display: none">
      <label>Explanation of Benefits:</label> <input type="file" name="attachment" /><br />
    </div>
    <input type="hidden" name="claimid" value="<?php echo (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?>">
    <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
    <input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
    <input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
    <input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <input type="hidden" name="entrycount" value="javascript::readCookie();">
    <div style="width:200px;float:right;margin-left:10px;text-align:left;" id="submitButton">
      <input style="width:auto;" type="submit" value="Submit Payments" />
    </div>
  </div>

  <div id="auth_div" style="display:none; padding: 10px;">
    <p>You are not authorized to complete this transaction. Please have an authorized user enter their credentials.</p>
    Username: <input type="text" name="username" /><br />
    Password: <input type="password" name="password" /><br />
    <input type="submit" value="Submit" style="width:auto;"/>
  </div>
</form>
<br><br>

<a href="view_claim.php?claimid=<?= $claimId ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="button" style="float:left;">Cancel</a>
<a href="ledger_payments_advanced.php?cid=<?= $claimId ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="button" style="float:right;">Advanced Payment</a>

<div style="clear:both;"></div>
</div>

<?php include 'includes/bottom.htm'; ?>
