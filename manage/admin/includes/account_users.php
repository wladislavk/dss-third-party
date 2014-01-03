<?php
session_start();
require_once 'main_include.php';
require_once '../../includes/constants.inc';
require 'access.php';
$docid = $_REQUEST['account'];
$n_sql = "SELECT * from dental_users where (userid='".$docid."' OR docid='".$docid."') AND status=1 order by docid ASC, first_name ASC, last_name ASC";
$n_q = mysql_query($n_sql);
 $c = '';
 while($u = mysql_fetch_assoc($n_q)){ 
    $c .= "<option value='".$u['userid']."'>".$u['first_name']." ".$u['last_name']."</option>";
 }
  echo '{"options":"'.$c.'"}';
?>

