<?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	$q = $_GET["q"];
	$pco = $_GET["pco"];

	$sql = "SELECT * FROM dental_transaction_code WHERE type = '".$q."' and docid=".$_SESSION['docid']." ORDER BY sortby ASC";

	$result = $db->getResults($sql);

	echo "<select style=\"width: 130px;\" onchange='return getTransCodesAmount(this.value,this.name,".$q.")' id='form[".$pco."][proccode]' name='form[".$pco."][proccode]'><option>Select TX Code</option>";
	if ($result) foreach ($result as $row) {
		echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
	}
  
	if ($result) foreach ($result as $row) {
		echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
	}

	echo "</select>";
?> 
