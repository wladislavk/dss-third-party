<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';

$claimId = intval($_GET['id']);

$c_sql = "SELECT CONCAT(p.firstname, ' ', p.lastname) AS pat_name, CONCAT(u.first_name, ' ', u.last_name) AS doc_name
    FROM dental_insurance i
        JOIN dental_patients p ON i.patientid = p.patientid
        JOIN dental_users u ON u.userid = p.docid
    WHERE i.insuranceid = '$claimId'";
$c_q = mysqli_query($con, $c_sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
$c = mysqli_fetch_assoc($c_q);

$sql = "SELECT *
    FROM dental_ledger_payment dlp
        JOIN dental_ledger dl ON dlp.ledgerid = dl.ledgerid
    WHERE (dl.primary_claim_id = '$claimId' OR dl.secondary_claim_id = '$claimId')";
$p_sql = mysqli_query($con, $sql);

$payments = mysqli_fetch_array($p_sql);
$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = '$claimId'";
$cq = mysqli_query($con, $csql);
$claim = mysqli_fetch_array($cq);

$pasql = "SELECT * FROM dental_insurance_file WHERE claimid = '$claimId' AND
		(status = ".DSS_CLAIM_SENT." OR status = ".DSS_CLAIM_DISPUTE.")";
$paq = mysqli_query($con, $pasql);
$num_pa = mysqli_num_rows($paq);

$sasql = "SELECT * FROM dental_insurance_file WHERE claimid = '$claimId' AND
                (status = ".DSS_CLAIM_SEC_SENT." OR status = ".DSS_CLAIM_SEC_DISPUTE.")";
$saq = mysqli_query($con, $sasql);
$num_sa = mysqli_num_rows($saq);

?>
<div class="fullwidth">
<script type="text/javascript">
//CHECK LEDGER PAYMENT SUBMISSION
function validSubmission(f){
returnval = true;
if(!authShown){
//CHECK PAYMENT IS ENTERED
payment = false
$('.payment_amount').each( function(){
  if( $(this).val()!=''){
    payment = true;
  }

});

if( !payment ){
  alert('You did not enter a payment to submit. Please enter a payment or exit payment window. If disputing an unpaid claim enter 0 in payment field.');
  returnval = false;
}

//DISPUTE CLAIM
if(f.dispute.checked){
  //CHECK IF ALREADY DISPUTED
  if(<?= ($claim['status']==DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE || $claim['status']==DSS_CLAIM_PATIENT_DISPUTE || $claim['status']==DSS_CLAIM_SEC_PATIENT_DISPUTE)?1:0; ?>){
    alert('This claim is already under dispute. Please uncheck the "Dispute" box and resubmit. Please contact the DSS Corporate office if you have further questions regarding your dispute.');
    returnval = false;
  }else if(<?= ($claim['status']==DSS_CLAIM_PENDING || $claim['status']==DSS_CLAIM_SEC_PENDING)?1:0; ?>){
    alert('A pending claim cannot be disputed. You cannot dispute a claim until it has been sent.');
    returnval = false;
  }else if(f.attachment.value ==''){
    alert('A disputed claim must have attachments from insurance company.');
    returnval = false;
  }else if(f.dispute_reason.value == ''){
    alert('You must provide a reason to dispute a claim.');
    returnval = false;
  }else{
    //Dispute valid
  } 

//NO DISPUTE
}else{
  if(<?= ($claim['status']==DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE || $claim['status']==DSS_CLAIM_PATIENT_DISPUTE || $claim['status']==DSS_CLAIM_SEC_PATIENT_DISPUTE)?1:0; ?>){
    if(!confirm("You have posted payment to a claim that is currently under dispute. Do you want to change claim status from Dispute to PAID?")){
      alert("You can make changes to the claim but they will not affect the already-submitted dispute. Please contact the DSS Corporate office if you have updates to this disputed claim.");
      returnval =  false;
    }
  }

  //Already status paid
  if(<?= ($claim['status']==DSS_CLAIM_PAID_INSURANCE)?1:0; ?>){
    //VALID    

  //PENDING
  }else if(<?= ($claim['status']==DSS_CLAIM_PENDING)?1:0; ?>){
     if(f.payer.value==<?= DSS_TRXN_PAYER_PRIMARY; ?>){
       alert('You listed Primary Insurance as the "Payer" for this transaction. However, the Primary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Primary Insurance. Please choose another Payer.');
       returnval = false;
     }else if(f.payer.value==<?= DSS_TRXN_PAYER_SECONDARY; ?>){
       alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
       returnval = false;
     }else if(f.close.checked){
       alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
       returnval = false;
     }else{
       //VALID
     } 
  //SEC PENDING
  }else if(<?= ($claim['status']==DSS_CLAIM_SEC_PENDING)?1:0; ?>){
    if(f.payer.value==<?= DSS_TRXN_PAYER_PRIMARY;?> && f.close.checked){
      alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
      returnval = false;
    }else if(f.payer.value!=<?= DSS_TRXN_PAYER_SECONDARY;?> && f.close.checked){
      alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
      returnval = false;
    }else if(f.payer.value==<?= DSS_TRXN_PAYER_SECONDARY;?>){
       alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
       returnval = false;
    }else{

    }
  }else if(<?= ($claim['status']==DSS_CLAIM_SENT)?1:0; ?>){
    if(f.payer.value==<?= DSS_TRXN_PAYER_PRIMARY;?>){
      if(f.close.checked){
        if(f.attachment.value =='' && <?= ($num_pa == 0)?1:0; ?>){
          if(!confirm('It is recommended a claim has an EOB attached to close. Proceed?')){
  	    returnval = false;
	  }
        }
        //file secondary
        //VALID
      }else{
        if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
      }
    }else if(f.payer.value==<?= DSS_TRXN_PAYER_SECONDARY;?>){
      alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
      returnval = false;
    }else{
      if(f.close.checked){
        //VALID      
      }else{
        if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
      }
    }
  }else if(<?= ($claim['status']==DSS_CLAIM_SEC_SENT)?1:0; ?>){
    if(f.close.checked){
      if(f.attachment.value =='' && <?= ($num_sa == 0)?1:0; ?>){
          if(!confirm('It is recommended a claim has an EOB attached to close. Proceed?')){
            returnval = false;
          }
        }
      //VALID
    }else{
      if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
    }
  }else{
    //WHAT HAPPENS?
  }
}
}
if(returnval){
  if(<?= ($_SESSION['user_access']==2)?1:0;?>){
    return true;
  }else{
    if(!authShown){
      return true; //To bypass auth until figured out
      showAuthBox();
      authShown = true;
      return false;
    }else{
      return true;
    }
  }
}else{
  return returnval;
}
}
var authShown = false;

function showAuthBox(){
document.getElementById('form_div').style.display = 'none';
document.getElementById('auth_div').style.display = 'block';
}




</script>

<link rel="stylesheet" href="css/form.css" type="text/css" />

<script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
<script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
<p class="lead">
    Claim Payment - Pt: <?= $c['pat_name']; ?> - Claim: <?= $_GET['id']; ?> - Account: <?= $c['doc_name']; ?>
</p>

<div class="row">
    <div class="col-md-6">
        <a href="/manage/admin/claim_payments_advanced.php?id=<?=$_GET['id']; ?>&pid=<?=$_GET['pid']; ?>" class="btn btn-success">
            <span class="glyphicon glyphicon-chevron-right"></span>
            Advanced Payment
        </a>
    </div>
    <div class="col-md-6 text-right">
        <a href="/manage/admin/claim_notes.php?id=<?=$_GET['id']; ?>&pid=<?=$_GET['pid']; ?>" class="btn btn-success">
            View Notes
        </a>
        <a href="/manage/admin/insurance_claim_v2.php?insid=<?=$_GET['id']; ?>&pid=<?=$_GET['pid']; ?>" class="btn btn-success">
            View Claim
        </a>
    </div>
</div>

<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payments.php" onsubmit="return validSubmission(this)" method="POST" enctype="multipart/form-data">

 
<div style="width:200px; margin:0 auto; text-align:center;">
<input type="hidden" value="0" id="currval" />
<script type="text/javascript">
function showsubmitbutton(){
document.getElementById('linecountbtn').style.display = "none";
document.getElementById('linecount').style.display = "none";
document.getElementById('submitbtn').style.display = "block";
document.getElementById('submitbtn').style.cssFloat = "right";
}
</script>

</div>

<?php
$sql = "SELECT dlp.*, dl.description
    FROM dental_ledger_payment dlp
        JOIN dental_ledger dl ON dlp.ledgerid = dl.ledgerid
    WHERE (dl.primary_claim_id = '$claimId' OR dl.secondary_claim_id = '$claimId')";
$p_sql = mysqli_query($con, $sql);

if (mysqli_num_rows($p_sql) == 0) { ?>
    <p class="lead text-center">No Previous Payments</p>
<?php } else { ?>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Payment Date</th>
                <th>Entry Date</th>
                <th>Description</th>
                <th>Paid By</th>
                <th>Payment Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_array($p_sql)) { ?>
                <tr>
                    <td><?= date('m/d/Y', strtotime($p['payment_date'])); ?></td>
                    <td><?= date('m/d/Y', strtotime($p['entry_date'])); ?></td>
                    <td><?= $p['description']; ?></td>
                    <td><?= $dss_trxn_payer_labels[$p['payer']]; ?></td>
                    <td><?= $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></td>
                    <td><?= $p['amount']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
<script type="text/javascript">

function updateType(payer){
  v = payer.value;
  if(v==1 || v==0){
    document.getElementById('payment_type').selectedIndex = 2;
  }else if(v==2){
    document.getElementById('payment_type').selectedIndex = 0;
  }else if(v==3 || v==4){
    document.getElementById('payment_type').selectedIndex = 4;
  }
}

</script>
<div id="form_div">
<div id="select_fields" style="margin: 10px;">
<label>Paid By</label>
<select id="payer" class="form-control input-sm input-inline" name="payer"
     onchange="updateType(this)" style="width:170px;margin: 0pt 10px 0pt 0pt;" >
  <option value="<?= DSS_TRXN_PAYER_PRIMARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_SECONDARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_PATIENT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_WRITEOFF; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_DISCOUNT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></option>
</select>
<label>Payment Type</label>
<select id="payment_type" class="form-control input-sm input-inline" name="payment_type"
     style="width:120px;margin: 0pt 10px 0pt 0pt; " >
  <option value="<?= DSS_TRXN_PYMT_CREDIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_DEBIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option>
  <option selected="selected" value="<?= DSS_TRXN_PYMT_CHECK; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_CASH; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_EFT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT]; ?></option>
</select>
</div>

<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="width:150px;margin: 0 10px 0 0; float:left;">Service Date</span>
<span style="width:180px;margin: 0 10px 0 0; float:left;">Description</span>
<span style="width:100px;margin: 0 10px 0 0; float:left;">Amount</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Payment Date *</span>
<span style="float:left;font-weight:bold; width:150px;">Paid Amount *</span>
<span style="float:left;font-weight:bold;">Allowed</span>
</div>
<?php
$lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id = '$claimId' OR secondary_claim_id = '$claimId'";
$lq = mysqli_query($con, $lsql);
while($row = mysqli_fetch_assoc($lq)){
?>
<div style="height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="width:150px;margin: 0 10px 0 0; float:left;"><?= date('m/d/Y', strtotime($row['service_date'])); ?></span>
<span style="width:180px;margin: 0 10px 0 0; float:left;"><?= $row['description']; ?></span>
<span style="width:100px;margin: 0 10px 0 0; float:left;">$<?= $row['amount']; ?></span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">
    <input style="width:140px" type="text" id="payment_date_<?= $row['ledgerid']; ?>"
        class="calendar form-control input-sm input-inline"
        name="payments[<?= $row['ledgerid'] ?>][0][payment_date]" value="<?= date('m/d/Y'); ?>" />
</span>
<span style="float:left;font-weight:bold;width:150px;">
    <input class="payment_amount dollar_input form-control input-sm input-inline" style="width:140px;" type="text"
        name="payments[<?= $row['ledgerid'] ?>][0][amount]" />
</span>
<span style="float:left;font-weight:bold;">
    <input class="payment_amount dollar_input form-control input-sm input-inline" style="width:140px;" type="text"
        name="payments[<?= $row['ledgerid'] ?>][0][amount_allowed]" />
</span>
</div>

<?php
}
?>
<br />
<input type="checkbox" id="close" name="close" class="form-control input-sm input-inline"
    onclick=" if(this.checked){ $('#dispute').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').hide('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value="1" /> <label>Close Claim</label>
<br />
<input type="checkbox" id="dispute" name="dispute" class="form-control input-sm input-inline"
    onclick=" if(this.checked){ $('#close').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').show('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value='1' /> <label>Dispute</label>
<div id="dispute_reason_div" style="display: none">
<label>Reason for dispute:</label> <input type="text" name="dispute_reason" class="form-control input-sm input-inline" />
</div>
<div id="ins_attach" style="display: none">
<label>Explanation of Benefits:</label> <input type="file" name="attachment" class="form-control input-sm input-inline" />
  <br />
</div>
<input type="hidden" name="claimid" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<input type="hidden" name="entrycount" value="javascript::readCookie();">
<div style="width:50%;float:right;margin-left:10px;text-align:right;" id="submitButton">
    <input class="btn btn-primary" type="submit" value="Submit Payments" />
</div>
</div>
<div id="auth_div" style="display:none; padding: 10px">
<p>You are not authorized to complete this transaction. Please have an authorized user enter their credentials.</p>
Username: <input type="text" name="username" class="form-control input-sm input-inline" /><br />
Password: <input type="password" name="password" class="form-control input-sm input-inline" /><br />
<input type="submit" value="Submit" class="btn btn-primary" />
</div>

</form>
</div>
<?php include 'includes/bottom.htm'; ?>
