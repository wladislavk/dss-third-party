<?php namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/includes/dual_app.php';
dualAppRedirect('main/medicine-manual');

include 'includes/top.htm';
include_once 'includes/constants.inc';
?>

<script src="js/manual.js" type="text/javascript"></script>

<div style="padding:0 20px; width:920px;height: 600px; overflow-y: scroll;">
    <?php include 'includes/medicine_manual_content.php'; ?>
</div>

<?php include 'includes/bottom.htm';?>

