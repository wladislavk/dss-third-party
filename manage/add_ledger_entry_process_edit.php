<?php
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");

$q=$_GET["q"];
$pco=$_GET["pco"];

$sql="SELECT * FROM dental_transaction_code WHERE type = '".$q."' and docid=".$_SESSION['docid'];

$result = mysql_query($sql);


echo "<select onchange='getTransCodesAmount(this.value,this.name,".$q.")' id='proccode' name='proccode'><option>Select TX Code</option>";
while($row = mysql_fetch_array($result))
  {
  echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
  }
  
while($row = mysql_fetch_array($result))
  {
  echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
}
echo "</select>";
?> 
