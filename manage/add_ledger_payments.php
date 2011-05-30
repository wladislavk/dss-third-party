<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
$sql = "SELECT * FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".$_GET['cid']."' ;";
$p_sql = mysql_query($sql);
$payments = mysql_fetch_array($p_sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />


<head>


</head>
<body>




<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payments.php" method="POST">

 
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
<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Payment Date</span>
<span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
<span style="width:180px;margin: 0 10px 0 0; float:left;">Description</span>
<span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width: 147px;">Payment Type</span>
<span style="float:left;font-weight:bold;">Amount</span>
</div>

<?php
$sql = "SELECT dlp.*, dl.description FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE dl.primary_claim_id='".$_GET['cid']."' ;";
$p_sql = mysql_query($sql);
while($p = mysql_fetch_array($p_sql)){
?>
<div style="margin-left:9px; margin-top: 10px; width:98%;height:16px; color: #fff;">
<span style="margin: 0 10px 0 0; float:left;width:83px;"><?= date('m/d/Y', strtotime($p['payment_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:80px;"><?= date('m/d/Y', strtotime($p['entry_date'])); ?></span>
<span style="margin: 0 10px 0 0; float:left;width:180px;"><?= $p['description']; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:120px;"><?= $dss_trxn_pymt_labels[$p['payer']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;width:147px;"><?= $dss_trxn_pymt_type_lables[$p['payment_type']]; ?></span>
<span style="margin: 0 10px 0 0; float:left;"><?= $p['amount']; ?></span>

</div>
<?php } ?>


<div id="select_fields" style="margin: 10px;color:#fff;">
<label>Payer</label>
<select id="payer" name="payer" style="width:170px;margin: 0pt 10px 0pt 0pt;" >
  <option value="<?= DSS_TRXN_PYMT_PRIMARY; ?>"><?= $dss_trxn_pymt_labels[DSS_TRXN_PYMT_PRIMARY]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_SECONDARY; ?>"><?= $dss_trxn_pymt_labels[DSS_TRXN_PYMT_SECONDARY]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_PATIENT; ?>"><?= $dss_trxn_pymt_labels[DSS_TRXN_PYMT_PATIENT]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>"><?= $dss_trxn_pymt_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_DISCOUNT; ?>"><?= $dss_trxn_pymt_labels[DSS_TRXN_PYMT_DISCOUNT]; ?></option>
</select>
<label>Payment Type</label>
<select id="payment_type" name="payment_type" style="width:120px;margin: 0pt 10px 0pt 0pt; " >
  <option value="<?= DSS_TRXN_PYMT_CREDIT; ?>"><?= $dss_trxn_pymt_type_lables[DSS_TRXN_PYMT_CREDIT]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_DEBIT; ?>"><?= $dss_trxn_pymt_type_lables[DSS_TRXN_PYMT_DEBIT]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_CHECK; ?>"><?= $dss_trxn_pymt_type_lables[DSS_TRXN_PYMT_CHECK]; ?></option>
  <option value="<?= DSS_TRXN_PYMT_CASH; ?>"><?= $dss_trxn_pymt_type_lables[DSS_TRXN_PYMT_CASH]; ?></option>
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
<span style="float:left;font-weight:bold;"><input style="width:140px;" type="text" name="amount_<?= $row['ledgerid']; ?>" /></span>
</div>

<?php
}
?>
<br />
<input type="checkbox" name="close" /> Close Claim
<br />
<input type="checkbox" name="dispute" /> Dispute
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
