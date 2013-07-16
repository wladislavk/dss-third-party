<?php
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");


$p=$_GET["p"];
$pco=$_GET['pco'];
$sql2="SELECT * FROM dental_transaction_code WHERE transaction_codeid = '".$p."'";

$result2 = mysql_query($sql2);

while($row = mysql_fetch_array($result2)){                                        
echo "<input type='text' name='desctextbox".$pco."' id='desctextbox".$pco."' value='".$row['description']."' />";
}
?>
