<?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once 'includes/claim_functions.php';

	$sql = "SELECT * FROM dental_ledger_payment WHERE id='".(!empty($_POST['id']) ? $_POST['id'] : '')."' ;";
	
	$p_sql = $db->getResults($sql);
	if ($p_sql) foreach ($p_sql as $p) {
		$s = "UPDATE dental_ledger_payment SET
			entry_date='".mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['entry_date_'.$p['id']])))."',
			payment_date='".mysqli_real_escape_string($con,date('Y-m-d',strtotime($_POST['payment_date_'.$p['id']])))."',
			payer='".mysqli_real_escape_string($con,$_POST['payer_'.$p['id']])."',
			payment_type='".mysqli_real_escape_string($con,$_POST['payment_type_'.$p['id']])."',
			amount='".mysqli_real_escape_string($con,str_replace(',','',$_POST['amount_'.$p['id']]))."'
			WHERE id='".mysqli_real_escape_string($con,$p['id'])."'";

		$db->query($s);
		payment_history_update($p['id'], $_SESSION['userid'], '');
	}
?>
	<script type="text/javascript">
		parent.window.location = parent.window.location;
	</script>