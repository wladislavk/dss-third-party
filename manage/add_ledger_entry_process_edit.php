<?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	$q = (!empty($_GET["q"]) ? $_GET["q"] : '');
	$pco = (!empty($_GET["pco"]) ? $_GET["pco"] : '');
	$sql="SELECT * FROM dental_transaction_code WHERE type = '".$q."' and docid=".$_SESSION['docid'];

	$result = $db->getResults($sql);
	echo "<select onchange='getTransCodesAmount(this.value,this.name,".$q.")' id='proccode' name='proccode'><option value='0'>Select TX Code</option>";
	
	if (!empty($result)) foreach ($result as $row) {
	  echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
	}
	  
	if (!empty($result)) foreach ($result as $row) {
	  echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
	}

	echo "</select>";
?> 
