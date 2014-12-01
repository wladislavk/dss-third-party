<?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	$q = (!empty($_GET["q"]) ? $_GET["q"] : '');
	$pco = (!empty($_GET["pco"]) ? $_GET["pco"] : '');
	$t = (!empty($_GET['t']) ? $_GET['t'] : '');

	$sql = sprintf("SELECT transaction_code from dental_transaction_code WHERE transaction_codeid=%s", mysqli_real_escape_string($con,$q));
	
	$ro = $db->getRow($sql);
	$tc = $ro['transaction_code'];

	$sql = "SELECT amount FROM dental_transaction_code WHERE transaction_code = '".$tc."' and docid=".$_SESSION['docid'];

	$r = ($t==2||$t==3)?'':'readonly="readonly"';
	echo '<input readonly="readonly" name="amount" type="text" class="tbox" value="'.(!empty($row['amount']) ? $row['amount'] : '').'"  maxlength="255"/>';
?> 
