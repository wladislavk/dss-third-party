<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
$sql = "SELECT * FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".$_GET['cid']."' ;";
$p_sql = mysql_query($sql);
$payments = mysql_fetch_array($p_sql);
$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid='".$_GET['cid']."';";
$cq = mysql_query($csql);
$claim = mysql_fetch_array($cq);

$pasql = "SELECT * FROM dental_insurance_file where claimid='".mysql_real_escape_string($_GET['cid'])."' AND
		(status = ".DSS_CLAIM_SENT." OR status = ".DSS_CLAIM_DISPUTE.")";
$paq = mysql_query($pasql);
$num_pa = mysql_num_rows($paq);


$sasql = "SELECT * FROM dental_insurance_file where claimid='".mysql_real_escape_string($_GET['cid'])."' AND
                (status = ".DSS_CLAIM_SEC_SENT." OR status = ".DSS_CLAIM_SEC_DISPUTE.")";
$saq = mysql_query($sasql);
$num_sa = mysql_num_rows($saq);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

</head>
<body>

<script type="text/javascript">
//CHECK LEDGER PAYMENT SUBMISSION
function validSubmission(f){
returnval = true;
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
  if(<?= ($claim['status']==DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE)?1:0; ?>){
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
  if(<?= ($claim['status']==DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE)?1:0; ?>){
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
          returnval = false;
          alert('A claim must have an EOB attached to close.');
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
          returnval = false;
          alert('A claim must have an EOB attached to close.');
        }
      //VALID
    }else{
      if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
    }
  }else{
    //WHAT HAPPENS?
  }
}


return returnval;
}

</script>

<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
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
$sql = "SELECT dlp.*, dl.description FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".$_GET['cid']."' ;";
$p_sql = mysql_query($sql);
if(mysql_num_rows($p_sql)==0){
?><div style="margin-left:50px; color:#fff;">No Previous Payments</div><?php
}else{
?>
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Payment Date</span>
<span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
<span style="width:140px;margin: 0 10px 0 0; float:left;">Description</span>
<span style="width:130px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width: 100px;">Payment Type</span>
<span style="float:left;font-weight:bold;width:100px;">Amount</span>
</div>
<?php
while($p = mysql_fetch_array($p_sql)){
?>
<div style="margin-left:9px; margin-top: 10px; width:98%;height:16px; color: #fff;">
<span style="margin: 0 10px 0 0; float:left;width:83px;"><?= date('m/d/Y', strtotime($p['payment_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:80px;"><?= date('m/d/Y', strtotime($p['entry_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:140px;"><?= $p['description']; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:130px;"><?= $dss_trxn_payer_labels[$p['payer']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:100px;"><?= $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:100px;"><?= $p['amount']; ?></span>

</div>
<?php 
}
}
 ?>


<div id="select_fields" style="margin: 10px;color:#fff;">
<label>Paid By</label>
<select id="payer" name="payer" style="width:170px;margin: 0pt 10px 0pt 0pt;" >
  <option value="<?= DSS_TRXN_PAYER_PRIMARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_SECONDARY; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_PATIENT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_WRITEOFF; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?></option>
  <option value="<?= DSS_TRXN_PAYER_DISCOUNT; ?>"><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></option>
</select>
<label>Payment Type</label>
<select id="payment_type" name="payment_type" style="width:120px;margin: 0pt 10px 0pt 0pt; " >
  <option value="<?= DSS_TRXN_PYMT_CREDIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_DEBIT; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_CHECK; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_CASH; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
</select>
</div>

<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="width:80px;margin: 0 10px 0 0; float:left;">Service Date</span>
<span style="width:180px;margin: 0 10px 0 0; float:left;">Description</span>
<span style="width:100px;margin: 0 10px 0 0; float:left;">Amount</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;">Payment Date</span>
<span style="float:left;font-weight:bold;">Paid Amount</span>
</div>
<?php
$lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id=".$_GET['cid'];
$lq = mysql_query($lsql);
while($row = mysql_fetch_assoc($lq)){
?>
<div style="color:#fff;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="width:80px;margin: 0 10px 0 0; float:left;"><?= $row['service_date']; ?></span>
<span style="width:180px;margin: 0 10px 0 0; float:left;"><?= $row['description']; ?></span>
<span style="width:100px;margin: 0 10px 0 0; float:left;">$<?= $row['amount']; ?></span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:150px;"><input style="width:140px" type="text" name="payment_date_<?= $row['ledgerid']; ?>" value="<?= date('m/d/Y'); ?>" /></span>
<span style="float:left;font-weight:bold;"><input class="payment_amount" style="width:140px;" type="text" name="amount_<?= $row['ledgerid']; ?>" /></span>
</div>

<?php
}
?>
<br />
<input type="checkbox" name="close" onclick=" if(this.checked){ $('#ins_attach').show('slow');$('#dispute_reason_div').hide('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value="1" /> Close Claim
<br />
<input type="checkbox" name="dispute" onclick=" if(this.checked){ $('#ins_attach').show('slow');$('#dispute_reason_div').show('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value='1' /> Dispute
<div id="dispute_reason_div" style="display: none">
<label>Reason for dispute:</label> <input type="text" name="dispute_reason" />
</div>
<div id="ins_attach" style="display: none">
<label>Explanation of Benefits:</label> <input type="file" name="attachment" /><br />
</div>
<input type="hidden" name="claimid" value="<?php echo $_GET['cid']; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<input type="hidden" name="entrycount" value="javascript::readCookie();">
<div style="width:200px;float:right;margin-left:10px;text-align:left;" id="submitButton"><input type="submit" value="Submit Payments" /></div>
</form>
</body>
</html> 
