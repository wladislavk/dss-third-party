<?php
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");

$q=$_GET["q"];
$pco=$_GET["pco"];
$t = $_GET['t'];

$sql = sprintf("SELECT transaction_code from dental_transaction_code WHERE transaction_codeid=%s",
                  mysql_real_escape_string($q));
$r = mysql_query($sql);
$ro = mysql_fetch_row($r);
$tc = $ro[0];


$sql="SELECT amount FROM dental_transaction_code WHERE transaction_code = '".$tc."' and docid=".$_SESSION['docid'];

$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$r = ($t==2||$t==3)?'':'readonly="readonly"';
echo '<input readonly="readonly" name="amount" type="text" class="tbox" value="'.$row[0].'"  maxlength="255"/>';
?> 
