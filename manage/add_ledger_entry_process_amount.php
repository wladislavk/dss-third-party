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
$r = ($t==2||$t==3||$t==6)?'':'readonly="readonly"';
if(($t!=2&&$t!=3)&&$row[0]==''){
echo "0";
}else{
echo '<input '.$r.' class="dollar_input" onkeypress="return is_dollar_input(event);" value="'.$row[0].'" type="text" id="form['.$pco.'][amount]" name="form['.$pco.'][amount]" style="margin: 0; float: left; width:75px;margin-right:10px;">';
}
?> 
