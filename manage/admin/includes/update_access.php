<?php
session_start();
require_once 'main_include.php';
require_once '../../includes/constants.inc';
require 'access.php';
$oid = $_REQUEST['oid'];
$nid = $_REQUEST['nid'];
$cur = $_REQUEST['cur'];
$o_sql = "SELECT company_type from companies where id='".$oid."'";
$o_q = mysql_query($o_sql);
$old = mysql_fetch_assoc($o_q);
$n_sql = "SELECT company_type from companies where id='".$nid."'";
$n_q = mysql_query($n_sql);
$new = mysql_fetch_assoc($n_q);
if(is_billing($_SESSION['admin_access'])){
 if($cur == ''){ $cur = DSS_ADMIN_ACCESS_BILLING_BASIC; }

 $c = "<option ".(($cur==DSS_ADMIN_ACCESS_BILLING_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BILLING_ADMIN."'>Billing Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_BILLING_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BILLING_BASIC."'>Billing Basic</option>";
  echo '{"change":"'.$c.'"}';
}elseif(is_hst($_SESSION['admin_access'])){
 if($cur == ''){ $cur = DSS_ADMIN_ACCESS_HST_BASIC; }

 $c = "<option ".(($cur==DSS_ADMIN_ACCESS_HST_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_HST_ADMIN."'>HST Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_HST_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_HST_BASIC."'>HST Basic</option>";
  echo '{"change":"'.$c.'"}';
}elseif(is_software($_SESSION['admin_access'])){
 if($cur == ''){ $cur = DSS_ADMIN_ACCESS_BASIC; }
 $c = "<option ".(($cur==DSS_ADMIN_ACCESS_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_ADMIN."'>Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BASIC."'>Basic</option>";
  echo '{"change":"'.$c.'"}';
}elseif($new['company_type'] == $old['company_type']){
  echo '{"change":false}';
}elseif($new['company_type']==DSS_COMPANY_TYPE_SOFTWARE){
 if($cur == '' || $cur == DSS_ADMIN_ACCESS_BILLING_ADMIN || $cur == DSS_ADMIN_ACCESS_BILLING_BASIC){ $cur = DSS_ADMIN_ACCESS_BASIC; }
 $c = '';
 if(is_super($_SESSION['admin_access'])){ 
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option ".(($cur==DSS_ADMIN_ACCESS_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_ADMIN."'>Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_BASIC)?"selected='selected'":'')."value='".DSS_ADMIN_ACCESS_BASIC."'>Basic</option>";
  echo '{"change":"'.$c.'"}';
}elseif($new['company_type']==DSS_COMPANY_TYPE_BILLING){
 if($cur == '' || $cur == DSS_ADMIN_ACCESS_ADMIN || $cur == DSS_ADMIN_ACCESS_BASIC){ $cur = DSS_ADMIN_ACCESS_BILLING_BASIC; }
 $c = '';
 if(is_super($_SESSION['admin_access'])){
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option ".(($cur==DSS_ADMIN_ACCESS_BILLING_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BILLING_ADMIN."'>Billing Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_BILLING_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BILLING_BASIC."'>Billing Basic</option>";
  echo '{"change":"'.$c.'"}';
}elseif($new['company_type']==DSS_COMPANY_TYPE_HST){
 if($cur == '' || $cur == DSS_ADMIN_ACCESS_ADMIN || $cur == DSS_ADMIN_ACCESS_BASIC){ $cur = DSS_ADMIN_ACCESS_HST_BASIC; }
 $c = '';
 if(is_super($_SESSION['admin_access'])){
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option ".(($cur==DSS_ADMIN_ACCESS_HST_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_HST_ADMIN."'>HST Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_HST_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_HST_BASIC."'>HST Basic</option>";
  echo '{"change":"'.$c.'"}';
}else{
 if($cur == ''){ $cur = DSS_ADMIN_ACCESS_BASIC; }

 $c = '';
 if(is_super($_SESSION['admin_access'])){
    $c .= "<option value='".DSS_ADMIN_ACCESS_SUPER."'>Super</option>";
 }
 $c .= "<option ".(($cur==DSS_ADMIN_ACCESS_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_ADMIN."'>Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BASIC."'>Basic</option>";
 $c .= "<option ".(($cur==DSS_ADMIN_ACCESS_BILLING_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BILLING_ADMIN."'>Billing Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_BILLING_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_BILLING_BASIC."'>Billing Basic</option>";
 $c .= "<option ".(($cur==DSS_ADMIN_ACCESS_HST_ADMIN)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_HST_ADMIN."'>HST Admin</option><option ".(($cur==DSS_ADMIN_ACCESS_HST_BASIC)?"selected='selected'":'')." value='".DSS_ADMIN_ACCESS_HST_BASIC."'>HST Basic</option>";
  echo '{"change":"'.$c.'"}';

}
?>

