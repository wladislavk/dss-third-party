<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once('includes/constants.inc');
	
	if(isset($_GET['delid'])){
		$del_sql = "delete FROM dental_ledger_payment WHERE id='".$_GET['delid']."' ;";
		
		$db->query($del_sql);
?>
		<script type="text/javascript">
			parent.window.location = parent.window.location;
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
  		<script type="text/javascript" src="/manage/js/edit_ledger_payment.js"></script>
	</head>

	<body>
		<link rel="stylesheet" href="css/form.css" type="text/css" />
		<script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
		<script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>

		<form id="ledgerentryform" name="ledgerentryform" action="update_ledger_payment.php" method="POST" onsubmit="validate();">
			<div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
				<span style="margin: 0pt 10px 0pt 0pt; float: left; width:100px;">Payment Date</span>
				<span style="width:100px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
				<span style="width:150px;margin: 0pt 10px 0pt 0pt; float: left;">Paid By</span>
				<span style="margin: 0pt 10px 0pt 0pt; float: left; width: 150px;">Payment Type</span>
				<span style="float:left;font-weight:bold;">Amount</span>
			</div>
			<?php
				$sql = "SELECT * FROM dental_ledger_payment WHERE id='".(!empty($_GET['ed']) ? $_GET['ed'] : '')."' ;";
				
				$p_sql = $db->getResults($sql);
				if ($p_sql) foreach ($p_sql as $p){
			?>
					<div style="margin-left:9px; margin-top: 10px; width:98%;color: #fff;">
						<span style="margin: 0 10px 0 0; float:left;width:100px;">
							<input type="text" style="width:90px"
								name="payments[<?= $p['id'] ?>][payment_date]" value="<?php echo  date('m/d/Y', strtotime($p['payment_date'])); ?>" />
						</span>
						<span style="margin: 0 10px 0 0; float:left;width:100px;">
							<input type="text" style="width:90px" name="payments[<?= $p['id'] ?>][entry_date]" value="<?php echo  date('m/d/Y', strtotime($p['entry_date'])); ?>" />
						</span>
						<span style="margin: 0 10px 0 0; float:left;width:150px;">
							<select id="payer_<?php echo  $p['id']; ?>"
								name="payments[<?= $p['id'] ?>][payer]"
								style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" >
								<option value="<?php echo  DSS_TRXN_PAYER_PRIMARY; ?>" <?php echo  ($p['payer']==DSS_TRXN_PAYER_PRIMARY)?'selected="selected"':''; ?>><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option>
								<option value="<?php echo  DSS_TRXN_PAYER_SECONDARY; ?>" <?php echo  ($p['payer']==DSS_TRXN_PAYER_SECONDARY)?'selected="selected"':''; ?>><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?></option>
								<option value="<?php echo  DSS_TRXN_PAYER_PATIENT; ?>" <?php echo  ($p['payer']==DSS_TRXN_PAYER_PATIENT)?'selected="selected"':''; ?>><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?></option>
								<option value="<?php echo  DSS_TRXN_PAYER_WRITEOFF; ?>" <?php echo  ($p['payer']==DSS_TRXN_PAYER_WRITEOFF)?'selected="selected"':''; ?>><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?></option>
								<option value="<?php echo  DSS_TRXN_PAYER_DISCOUNT; ?>" <?php echo  ($p['payer']==DSS_TRXN_PAYER_DISCOUNT)?'selected="selected"':''; ?>><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></option>
							</select>
						</span>
						<span style="margin: 0 10px 0 0; float:left;width:150px;">
							<select id="payment_type_<?php echo  $p['id']; ?>"
								name="payments[<?= $p['id'] ?>][payment_type]"
								style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;" >
								<option value="<?php echo  DSS_TRXN_PYMT_CREDIT; ?>" <?php echo  ($p['payment_type']==DSS_TRXN_PYMT_CREDIT)?'selected="selected"':''; ?>><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option>
								<option value="<?php echo  DSS_TRXN_PYMT_DEBIT; ?>" <?php echo  ($p['payment_type']==DSS_TRXN_PYMT_DEBIT)?'selected="selected"':''; ?>><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option>
								<option value="<?php echo  DSS_TRXN_PYMT_CHECK; ?>" <?php echo  ($p['payment_type']==DSS_TRXN_PYMT_CHECK)?'selected="selected"':''; ?>><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
								<option value="<?php echo  DSS_TRXN_PYMT_CASH; ?>" <?php echo  ($p['payment_type']==DSS_TRXN_PYMT_CASH)?'selected="selected"':''; ?>><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
								<option value="<?php echo  DSS_TRXN_PYMT_WRITEOFF; ?>" <?php echo  ($p['payment_type']==DSS_TRXN_PYMT_WRITEOFF)?'selected="selected"':''; ?>><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
                                <option value="<?php echo  DSS_TRXN_PYMT_EFT; ?>" <?php echo  ($p['payment_type']==DSS_TRXN_PYMT_EFT)?'selected="selected"':''; ?>><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT]; ?></option>
							</select>
						</span>
						<span style="margin: 0 10px 0 0; float:left;">
							<input type="text" class="dollar_input" name="payments[<?= $p['id'] ?>][amount]"
								value="<?php echo  $p['amount']; ?>" />
						</span>
						<div style="clear:both"></div>
					</div>
			<?php
				}
			?>
			<div id="FormFields" style="margin: 20px 10px;"></div>
			<input type="hidden" name="id" value="<?php echo (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>">
			<input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
			<input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
			<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
			<input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
			<input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
			<a href="?delid=<?php echo  (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>&pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" onclick="return confirm('Are you sure you want to delete this payment? This cannot be undone.');" class="dellink">Delete</a>
			<div style="width:200px;float:right;margin-right:10px;text-align:right;" id="submitButton">
				<input type="submit" onclick="validate(<?php (!empty($_COOKIE['tempforledgerentry']) ? $_COOKIE['tempforledgerentry'] : ''); ?>)" value="Edit Payment" />
			</div>
		</form>
	</body>
</html> 

<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="/manage/js/masks.js"></script>
