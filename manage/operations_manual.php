<?php
include_once 'includes/constants.inc';
include 'includes/top.htm';
?>
<div style="padding:0 20px; width:920px;height: 600px; overflow-y: scroll;">
<?php
if($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE){ 
include 'includes/manual_operations_content.php';
}
?>
</div>
<? include 'includes/bottom.htm';?>

