<?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	$sql = "SELECT * FROM dental_ledger_payment WHERE ledgerid='".$_POST['ledgerid']."' ;";
	
	$p_sql = $db->getResults($sql);
	if ($p_sql) foreach ($p_sql as $p) {
		$s = "UPDATE dental_ledger_payment SET
			  entry_date='".mysql_real_escape_string(date('Y-m-d', strtotime($_POST['entry_date_'.$p['id']])))."',
			  payment_date='".mysql_real_escape_string(date('Y-m-d',strtotime($_POST['payment_date_'.$p['id']])))."',
			  payer='".mysql_real_escape_string($_POST['payer_'.$p['id']])."',
			  payment_type='".mysql_real_escape_string($_POST['payment_type_'.$p['id']])."',
			  amount='".mysql_real_escape_string(str_replace(',','',$_POST['amount_'.$p['id']]))."'
			  WHERE id='".mysql_real_escape_string($p['id'])."'";
		
		$db->query($s);
	}

?>
	<script type="text/javascript">
		parent.window.location = parent.window.location;
	</script>