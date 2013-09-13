<?php
session_start();
require_once 'main_include.php';
require_once '../../includes/constants.inc';
require 'access.php';
$oid = $_REQUEST['oid'];
$nid = $_REQUEST['nid'];
$o_sql = "SELECT company_type from companies where id='".$oid."'";
$o_q = mysql_query($o_sql);
$old = mysql_fetch_assoc($o_q);
$n_sql = "SELECT company_type from companies where id='".$nid."'";
$n_q = mysql_query($n_sql);
$new = mysql_fetch_assoc($n_q);
if($new['company_type'] == $old['company_type']){
  echo '{"change":false}';
}elseif($new['company_type']==DSS_COMPANY_TYPE_SOFTWARE){
 $c = '';
 if(is_super($_SESSION['admin_access'])){ 
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option value='".DSS_ADMIN_ACCESS_ADMIN."'>Admin</option><option value='".DSS_ADMIN_ACCESS_BASIC."'>Basic</option>";
  echo '{"change":"'.$c.'"}';
}elseif($new['company_type']==DSS_COMPANY_TYPE_BILLING){
 $c = '';
 if(is_super($_SESSION['admin_access'])){
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option value='".DSS_ADMIN_ACCESS_BILLING_ADMIN."'>Billing Admin</option><option value='".DSS_ADMIN_ACCESS_BILLING_BASIC."'>Billing Basic</option>";
  echo '{"change":"'.$c.'"}';
}else{
 $c = '';
 if(is_super($_SESSION['admin_access'])){
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option value='".DSS_ADMIN_ACCESS_ADMIN."'>Admin</option><option value='".DSS_ADMIN_ACCESS_BASIC."'>Basic</option>";
 $c .= "<option value='".DSS_ADMIN_ACCESS_BILLING_ADMIN."'>Billing Admin</option><option value='".DSS_ADMIN_ACCESS_BILLING_BASIC."'>Billing Basic</option>";
  echo '{"change":"'.$c.'"}';

}
?>

