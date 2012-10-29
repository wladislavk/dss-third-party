<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
if(isset($_GET['delid'])){
$del_sql = "delete FROM dental_ledger_payment WHERE id='".$_GET['delid']."' ;";
mysql_query($del_sql);
?>
<script type="text/javascript">
parent.window.location = parent.window.location;
</script>
<?php
die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />


<head>


  <script type="text/javascript">
function validate(){
if(document.getElementById('ledger_entry_service_date').value = ''){
  alert('Please enter a service date');
}
</script>

</head>
<body>




<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form id="ledgerentryform" name="ledgerentryform" action="update_ledger_payment.php" method="POST" onsubmit="validate();">

<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
<span style="margin: 0pt 10px 0pt 0pt; float: left; width:100px;">Payment Date</span>
<span style="width:100px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
<span style="width:150px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span>
<span style="margin: 0pt 10px 0pt 0pt; float: left; width: 150px;">Payment Type</span>
<span style="float:left;font-weight:bold;">Amount</span>
</div>

<?php
$sql = "SELECT * FROM dental_ledger_payment WHERE id='".$_GET['ed']."' ;";
$p_sql = mysql_query($sql);
while($p = mysql_fetch_array($p_sql)){
?>
<div style="margin-left:9px; margin-top: 10px; width:98%;color: #fff;">
<span style="margin: 0 10px 0 0; float:left;width:100px;"><input type="text" style="width:90px" name="payment_date_<?= $p['id']; ?>" value="<?= date('m/d/Y', strtotime($p['payment_date'])); ?>" /></span>
<span style="margin: 0 10px 0 0; float:left;width:100px;"><input type="text" style="width:90px" name="entry_date_<?= $p['id']; ?>" value="<?= date('m/d/Y', strtotime($p['entry_date'])); ?>" /></span>
<span style="margin: 0 10px 0 0; float:left;width:150px;">
<select id="payer_<?= $p['id']; ?>" name="payer_<?= $p['id']; ?>" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" >
<option value="<?= DSS_TRXN_PAYER_PRIMARY; ?>" <?= ($p['payer']==DSS_TRXN_PAYER_PRIMARY)?'selected="selected"':''; ?>><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option>
<option value="<?= DSS_TRXN_PAYER_SECONDARY; ?>" <?= ($p['payer']==DSS_TRXN_PAYER_SECONDARY)?'selected="selected"':''; ?>><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?></option>
<option value="<?= DSS_TRXN_PAYER_PATIENT; ?>" <?= ($p['payer']==DSS_TRXN_PAYER_PATIENT)?'selected="selected"':''; ?>><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?></option>
<option value="<?= DSS_TRXN_PAYER_WRITEOFF; ?>" <?= ($p['payer']==DSS_TRXN_PAYER_WRITEOFF)?'selected="selected"':''; ?>><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?></option>
<option value="<?= DSS_TRXN_PAYER_DISCOUNT; ?>" <?= ($p['payer']==DSS_TRXN_PAYER_DISCOUNT)?'selected="selected"':''; ?>><?= $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></option>
</select>
</span>

<span style="margin: 0 10px 0 0; float:left;width:150px;">
<select id="payment_type_<?= $p['id']; ?>" name="payment_type_<?= $p['id']; ?>" style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" >
<option value="<?= DSS_TRXN_PYMT_CREDIT; ?>" <?= ($p['payment_type']==DSS_TRXN_PYMT_CREDIT)?'selected="selected"':''; ?>><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option>
<option value="<?= DSS_TRXN_PYMT_DEBIT; ?>" <?= ($p['payment_type']==DSS_TRXN_PYMT_DEBIT)?'selected="selected"':''; ?>><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option>
<option value="<?= DSS_TRXN_PYMT_CHECK; ?>" <?= ($p['payment_type']==DSS_TRXN_PYMT_CHECK)?'selected="selected"':''; ?>><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
<option value="<?= DSS_TRXN_PYMT_CASH; ?>" <?= ($p['payment_type']==DSS_TRXN_PYMT_CASH)?'selected="selected"':''; ?>><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
<option value="<?= DSS_TRXN_PYMT_WRITEOFF; ?>" <?= ($p['payment_type']==DSS_TRXN_PYMT_WRITEOFF)?'selected="selected"':''; ?>><?= $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
</select>
</span> 

<span style="margin: 0 10px 0 0; float:left;"><input type="text" class="dollar_input" name="amount_<?= $p['id']; ?>" value="<?= $p['amount']; ?>" /></span>
<div style="clear:both"></div>
</div>
<?php } ?>

<div id="FormFields" style="margin: 20px 10px;"></div>

<input type="hidden" name="id" value="<?php echo $_GET['ed']; ?>">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<a href="?delid=<?= $_GET['ed']; ?>&pid=<?= $_GET['pid']; ?>" onclick="return confirm('Are you sure you want to delete this payment? This cannot be undone.');" class="dellink">Delete</a>
<div style="width:200px;float:right;margin-right:10px;text-align:right;" id="submitButton"><input type="submit" onclick="validate(<?php $_COOKIE['tempforledgerentry']; ?>)" value="Edit Payment" /></div>
</form>
</body>
</html> 

<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/manage/js/masks.js"></script>
