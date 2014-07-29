<?php include 'includes/top.htm';?>

<?
require '../includes/constants.inc';


$c_sql = "SELECT CONCAT(p.firstname,' ', p.lastname) pat_name, CONCAT(u.first_name, ' ',u.last_name) doc_name 
                FROM dental_insurance i
                JOIN dental_patients p ON i.patientid=p.patientid
                JOIN dental_users u ON u.userid=p.docid
		WHERE i.insuranceid='".mysql_real_escape_string($_GET['id'])."'";
$c_q = mysql_query($c_sql) or die(mysql_error());
$c = mysql_fetch_assoc($c_q);


?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />

<span class="admin_head">
	Claim Payment - Pt: <?= $c['pat_name']; ?> - Claim: <?= $_GET['id']; ?> - Account: <?= $c['doc_name']; ?>
</span>
<br /><br />

<br /><br />
<div align="center" class="red">
	<? echo $_GET['msg'];?>
</div>
<?php

$sql = "SELECT * FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".$_GET['id']."' ;";
$p_sql = mysql_query($sql);
$payments = mysql_fetch_array($p_sql);
$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid='".$_GET['id']."';";
$cq = mysql_query($csql);
$claim = mysql_fetch_array($cq);

$pasql = "SELECT * FROM dental_insurance_file where claimid='".mysql_real_escape_string($_GET['id'])."' AND
                (status = ".DSS_CLAIM_SENT." OR status = ".DSS_CLAIM_DISPUTE.")";
$paq = mysql_query($pasql);
$num_pa = mysql_num_rows($paq);


$sasql = "SELECT * FROM dental_insurance_file where claimid='".mysql_real_escape_string($_GET['id'])."' AND
                (status = ".DSS_CLAIM_SEC_SENT." OR status = ".DSS_CLAIM_SEC_DISPUTE.")";
$saq = mysql_query($sasql);
$num_sa = mysql_num_rows($saq);

?>


<?php
$sql = "SELECT dlp.*, dl.description FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".$_GET['id']."' ;";
$p_sql = mysql_query($sql);
if(mysql_num_rows($p_sql)==0){
?><div style="margin-left:50px; ">No Previous Payments</div><?php
}else{
?>
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Payment Date</span>
<span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
<span style="width:190px;margin: 0 10px 0 0; float:left;">Description</span>
<span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width: 100px;">Payment Type</span>
<span style="float:left;font-weight:bold;width:100px;">Amount</span>
</div>
<?php
while($p = mysql_fetch_array($p_sql)){
?>
<div style="margin-left:9px; margin-top: 10px; width:98%; ">
<span style="margin: 0 10px 0 0; float:left;width:83px;"><?= date('m/d/Y', strtotime($p['payment_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:80px;"><?= date('m/d/Y', strtotime($p['entry_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:190px;"><?= $p['description']; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:80px;"><?= $dss_trxn_payer_labels[$p['payer']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:100px;"><?= $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:100px;"><?= $p['amount']; ?></span>
<div style="clear:both;"></div>
</div>
<?php
}
}
 ?>

<div id="form_div">
<div id="select_fields" style="margin: 10px;">
<label>Paid By</label>
<select id="payer" name="payer" onchange="updateType(this)" style="width:170px;margin: 0pt 10px 0pt 0pt;" >
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
  <option selected="selected" value="<?= DSS_TRXN_PYMT_CHECK; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_CASH; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>"><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
</select>
</div>

<style type="text/css">

input{ width: 60px; }

</style>


<table style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<tr>
<td>Service Date</td>
<td>Description</td>
<td>Amount</td>
<td>Allowed</td>
<td>Ins. Paid</td>
<td>Deductible</td>
<td>Copay</td>
<td>CoIns</td>
<td>Overpaid</td>
<td>Follow-up</td>
<td>Payment Date</td>
<td>Paid Amount</td>
<td>Note</td>
</tr>
<?php
$lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id=".$_GET['id'];
$lq = mysql_query($lsql);
while($row = mysql_fetch_assoc($lq)){
?>
<tr>
<td><?= $row['service_date']; ?></td>
<td><?= $row['description']; ?></td>
<td>$<?= $row['amount']; ?></td>
<td><input type="text" name="allowed" value="<?= $row['allowed']; ?>" /></td>
<td><input type="text" name="ins_paid" value="<?= $row['ins_paid']; ?>" /></td>
<td><input type="text" name="deductible" value="<?= $row['deductible']; ?>" /></td>
<td><input type="text" name="copay" value="<?= $row['copay']; ?>" /></td>
<td><input type="text" name="coins" value="<?= $row['coins']; ?>" /></td>
<td><input type="text" name="overpaid" value="<?= $row['overpaid']; ?>" /></td>
<td><input type="text" name="followup" value="<?= $row['followup']; ?>" /></td>
<td><input type="text" name="payment_date_<?= $row['ledgerid']; ?>" value="<?= date('m/d/Y'); ?>" /></td>
<td><input class="payment_amount dollar_input" type="text" name="amount_<?= $row['ledgerid']; ?>" /></td>
<td><input type="text" name="note" value="<?= $row['note']; ?>" /></td>
</tr>
<?php
}
?>
</table>
<br />
<input type="checkbox" id="close" name="close" onclick=" if(this.checked){ $('#dispute').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').hide('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value="1" <?= (isset($_GET['close']) && $_GET['close']==1)?'checked="checked"':''; ?>/> <label >Close Claim</label>
<br />
<input type="checkbox" id="dispute" name="dispute" onclick=" if(this.checked){ $('#close').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').show('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value='1' /> <label >Dispute</label>
<div id="dispute_reason_div" style="display: none">
<label >Reason for dispute:</label> <input type="text" name="dispute_reason" />
</div>
<div id="ins_attach" style="display: none">
<label >Explanation of Benefits:</label> <input type="file" name="attachment" /><br />
</div>
<input type="hidden" name="claimid" value="<?php echo $_GET['cid']; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<input type="hidden" name="entrycount" value="javascript::readCookie();">
<div style="width:200px;float:right;margin-left:10px;text-align:left;" id="submitButton"><input style="width:auto;" type="submit" value="Submit Payments" /></div>
</div>


</form>
<br><br>
<a href="claim_payments.php?id=<?=$_GET['id']; ?>&pid=<?=$_GET['pid']; ?>" class="button" style="float:right;">Simple Payment</a>
<div style="clear:both;"></div>




<div style="clear:both;"></div>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<? include 'includes/bottom.htm';?>
