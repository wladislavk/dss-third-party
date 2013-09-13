<?
include "includes/top.htm";

if(isset($_POST['user_sub'])){
  $d_sql = "UPDATE dental_users SET billing_company_id=NULL WHERE billing_company_id='".mysql_real_escape_string($_POST['id'])."'";
  mysql_query($d_sql);
  $u = implode(',',$_POST['user']);
  $up_sql = "UPDATE dental_users set billing_company_id='".mysql_real_escape_string($_POST['id'])."' WHERE userid IN (".$u.")";
  mysql_query($up_sql);
}
?>
<?php
$u_sql = "SELECT u.* FROM dental_users u
		JOIN dental_user_company uc ON uc.userid=u.userid
		 WHERE
		uc.companyid='".mysql_real_escape_string($_REQUEST['id'])."' AND
		docid=0
		ORDER BY first_name ASC, last_name ASC, username ASC";
$u_q = mysql_query($u_sql);
while($user = mysql_fetch_assoc($u_q)){
?>
  <?= $user['first_name']. " " .$user['last_name'] . " - " . $user['username']; ?><br />
<?php
  }
?>









<?php
include 'includes/bottom.htm';
?>
