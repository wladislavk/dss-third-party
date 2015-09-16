<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	$q = (!empty($_GET["q"]) ? $_GET["q"] : '');
	$pco = (!empty($_GET["pco"]) ? $_GET["pco"] : '');
	$t = (!empty($_GET['t']) ? $_GET['t'] : '');

	$sql = sprintf("SELECT transaction_code from dental_transaction_code WHERE transaction_codeid = '%s'", mysqli_real_escape_string($con,$q));
	
	$ro = $db->getRow($sql); 
	$tc = $ro['transaction_code'];
	$sql = "SELECT amount FROM dental_transaction_code WHERE transaction_code = '" . $tc . "' and docid = '" . $_SESSION['docid'] . "'";

	$row = $db->getRow($sql);
	$r = '';
	if(($t != 2 && $t != 3) && $row['amount'] == ''){
		echo "0";
	} else {
		echo '<input '.$r.' class="dollar_input" onkeypress="return is_dollar_input(event);" value="'.$row['amount'].'" type="text" id="form['.$pco.'][amount]" name="form['.$pco.'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;">';
	}
?> 
