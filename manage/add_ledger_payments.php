<?php
<<<<<<< HEAD
  include "includes/top.htm";
  include_once "includes/constants.inc";
=======
include "includes/top.htm";
include_once "includes/constants.inc";
require "includes/calendarinc.php";
$sql = "SELECT * FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE (dl.primary_claim_id='".$_GET['cid']."'  or dl.secondary_claim_id=".$_GET['cid'].");";
$p_sql = mysql_query($sql);
$payments = mysql_fetch_array($p_sql);
$csql = "SELECT i.*, CONCAT(p.firstname, ' ',p.lastname) name FROM dental_insurance i 
	JOIN dental_patients p ON p.patientid=i.patientid
	WHERE i.insuranceid='".$_GET['cid']."';";
$cq = mysql_query($csql);
$claim = mysql_fetch_array($cq);
>>>>>>> branch

  $sql = "SELECT * FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."' ;";
  $payments = $db->getRow($sql);

  $csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."';";
  $claim = $db->getRow($csql);

  $pasql = "SELECT * FROM dental_insurance_file where claimid='".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''))."' AND
  		(status = ".DSS_CLAIM_SENT." OR status = ".DSS_CLAIM_DISPUTE.")";
  $num_pa = $db->getNumberRows($pasql);


  $sasql = "SELECT * FROM dental_insurance_file where claimid='".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''))."' AND
            (status = ".DSS_CLAIM_SEC_SENT." OR status = ".DSS_CLAIM_SEC_DISPUTE.")";
  $num_sa = $db->getNumberRows($sasql);
?>

<div class="fullwidth">

<?php 
/**

*/
?>

<script type="text/javascript">
//CHECK LEDGER PAYMENT SUBMISSION
function validSubmission(f)
{
  returnval = true;

  if (!authShown) {
  //CHECK PAYMENT IS ENTERED
  payment = false
  $('.payment_amount').each( function(){
    if( $(this).val()!=''){
      payment = true;
    }
  });

  if(!payment){
    alert('You did not enter a payment to submit. Please enter a payment or exit payment window. If disputing an unpaid claim enter 0 in payment field.');
    returnval = false;
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
      } else if (<?php echo  ($claim['status']==DSS_CLAIM_SENT)?1:0; ?>) {
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

<?php 
/**

*/
?>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript">
<script language="text/javascript" src="calendar1.js"></script>
<script language="text/javascript" src="calendar2.js"></script>
<script type="text/javascript" src="js/add_ledger_payments.js"></script>

<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payments.php" onsubmit="return validSubmission(this)" method="POST" enctype="multipart/form-data">
  <div style="width:200px; margin:0 auto; text-align:center;">
    <input type="hidden" value="0" id="currval" />
  </div>
  <?php
    $sql = "SELECT dlp.*, dl.description FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."' ;";
    $p_sql = $db->getResults($sql);

<<<<<<< HEAD
    if(count($p_sql)==0) {
  ?>
    <div style="margin-left:50px;">No Previous Payments</div>
  <?php
    } else {
  ?>
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
  ?>
    <tr>
      <td><?php echo  date('m/d/Y', strtotime($p['payment_date'])); ?></td>
      <td><?php echo  date('m/d/Y', strtotime($p['entry_date'])); ?></dt>
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
      <td><?php echo  $p['followup']; ?></td>
      <td><?php echo  $p['note']; ?></td>
    </tr>
=======
<?php
$sql = "SELECT dlp.*, dl.description FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE (dl.primary_claim_id='".$_GET['cid']."'  or dl.secondary_claim_id=".$_GET['cid'].");";
$p_sql = mysql_query($sql);
if(mysql_num_rows($p_sql)==0){
?><div style="margin-left:50px;">No Previous Payments</div><?php
}else{
?>
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
while($p = mysql_fetch_array($p_sql)){
?>
<td><?= date('m/d/Y', strtotime($p['payment_date'])); ?></td>
<td><?= date('m/d/Y', strtotime($p['entry_date'])); ?></dt>
<td><?= $p['description']; ?></td>
<td><?= $dss_trxn_payer_labels[$p['payer']]; ?></td>
<td><?= $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></td>
<td><?= ($p['amount'] > 0 ? $p['amount'] : ""); ?></td>
<td><?= ($p['amount_allowed'] > 0 ? $p['amount_allowed'] : ""); ?></td>
<td><?= ($p['ins_paid'] > 0 ?  $p['ins_paid'] : ""); ?></td>
<td><?= ($p['deductible'] > 0 ? $p['deductible'] : ""); ?></td>
<td><?= ($p['copay'] > 0 ? $p['copay'] : ""); ?></td>
<td><?= ($p['coins'] > 0 ? $p['coins'] : ""); ?></td>
<td><?= ($p['overpaid'] > 0 ? $p['overpaid'] : ""); ?></td>
<td><?= $p['followup']; ?></td>
<td><?= $p['note']; ?></td>
</tr>
>>>>>>> branch
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
      </select>
    </div>
    <div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
      <span style="width:80px;margin: 0 10px 0 0; float:left;">Service Date</span>
      <span style="width:180px;margin: 0 10px 0 0; float:left;">Description</span>
      <span style="width:100px;margin: 0 10px 0 0; float:left;">Amount</span>
      <span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Payment Date</span>
      <span style="float:left;font-weight:bold;">Paid Amount</span>
    </div>

<<<<<<< HEAD
    <?php
      $lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id=".(!empty($_GET['cid']) ? $_GET['cid'] : '');
      $lq = $db->getResults($lsql);
      foreach ($lq as $row) {
    ?>
        <div style="height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
          <span style="width:80px;margin: 0 10px 0 0; float:left;"><?php echo  $row['service_date']; ?></span>
          <span style="width:180px;margin: 0 10px 0 0; float:left;"><?php echo  $row['description']; ?></span>
          <span style="width:100px;margin: 0 10px 0 0; float:left;">$<?php echo  $row['amount']; ?></span>
          <span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">
            <input style="width:140px" type="text" name="payment_date_<?php echo  $row['ledgerid']; ?>" value="<?php echo  date('m/d/Y'); ?>" />
          </span>
          <span style="float:left;font-weight:bold;">
            <input class="payment_amount dollar_input" style="width:140px;" type="text" name="amount_<?php echo  $row['ledgerid']; ?>" />
          </span>
        </div>
    <?php } ?>
=======
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="width:80px;margin: 0 10px 0 0; float:left;">Service Date</span>
<span style="width:180px;margin: 0 10px 0 0; float:left;">Description</span>
<span style="width:100px;margin: 0 10px 0 0; float:left;">Amount</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Payment Date <span class="req">*</span></span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Amount Allowed</span>
<span style="float:left;font-weight:bold;">Paid Amount <span class="req">*</span></span>
</div>
<?php
$lsql = "SELECT * FROM dental_ledger WHERE (primary_claim_id=".$_GET['cid']."  or secondary_claim_id=".$_GET['cid'].")";
$lq = mysql_query($lsql);
while($row = mysql_fetch_assoc($lq)){
?>
<div style="height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="width:80px;margin: 0 10px 0 0; float:left;"><?= $row['service_date']; ?></span>
<span style="width:180px;margin: 0 10px 0 0; float:left;"><?= $row['description']; ?></span>
<span style="width:100px;margin: 0 10px 0 0; float:left;">$<?= $row['amount']; ?></span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;"><input style="width:140px" type="text" id="payment_date_<?= $row['ledgerid']; ?>" class="calendar_top" name="payment_date_<?= $row['ledgerid']; ?>" value="<?= date('m/d/Y'); ?>" /></span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;"><input style="width:140px" type="text" class="allowed_amount dollar_input" name="allowed_<?= $row['ledgerid']; ?>" /></span>
<span style="float:left;font-weight:bold;"><input class="payment_amount dollar_input" style="width:140px;" type="text" name="amount_<?= $row['ledgerid']; ?>" /></span>
</div>
>>>>>>> branch

    <br />
    <input type="checkbox" id="close" name="close" onclick=" if(this.checked){ $('#dispute').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').hide('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value="1" />
     <label>Close Claim</label>
    <br />
    <input type="checkbox" id="dispute" name="dispute" onclick=" if(this.checked){ $('#close').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').show('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value='1' />
     <label>Dispute</label>
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
      <input type="submit" value="Submit Payments" />
    </div>
  </div>

  <div id="auth_div" style="display:none; padding: 10px">
    <p>You are not authorized to complete this transaction. Please have an authorized user enter their credentials.</p>
    Username: <input type="text" name="username" /><br />
    Password: <input type="password" name="password" /><br />
    <input type="submit" value="Submit" />
  </div>
</form>
<br><br>

<a href="view_claim.php?claimid=<?php echo (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="button" style="float:left;">Cancel</a>
<a href="ledger_payments_advanced.php?cid=<?php echo (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="button" style="float:right;">Advanced Payment</a>

<div style="clear:both;"></div>
</div>

<?php include 'includes/bottom.htm'; ?>
