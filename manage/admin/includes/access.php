<?php
//access functions
function is_super($admin_access){
  return ($admin_access==DSS_ADMIN_ACCESS_SUPER);
}

function is_admin($admin_access){
  return ($admin_access==DSS_ADMIN_ACCESS_SUPER || $admin_access==DSS_ADMIN_ACCESS_ADMIN);
}

function is_billing_admin($admin_access){
  return ($admin_access==DSS_ADMIN_ACCESS_BILLING_ADMIN);
}

function is_billing($admin_access){
  return ($admin_access==DSS_ADMIN_ACCESS_BILLING_ADMIN || $admin_access==DSS_ADMIN_ACCESS_BILLING_USER);
}

?>
