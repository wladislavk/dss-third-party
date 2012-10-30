<?php
//access functions
function is_super($admin_access){
  return ($admin_access==DSS_ADMIN_ACCESS_SUPER);
}

function is_admin($admin_access){
  return ($admin_access==DSS_ADMIN_ACCESS_SUPER || $admin_access==DSS_ADMIN_ACCESS_ADMIN);
}


?>
