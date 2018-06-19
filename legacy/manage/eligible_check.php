<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include_once "includes/constants.inc";

$api_sql = "SELECT use_eligible_api FROM dental_users
              WHERE userid='".$db->escape( $_SESSION['docid'])."'";
$api_r = $db->getRow($api_sql);
if($api_r['use_eligible_api']==1){?>
<script>
    var eligibleApiKey = <?= json_encode(DSS_DEFAULT_ELIGIBLE_API_KEY) ?>;
</script>
<br />
<span class="admin_head">Eligibility Check for <?php echo (!empty($thename) ? $thename : ''); ?></span>
  <center>
    <iframe width="98%" height="2043px" onLoad="autoResize('eligible');" id="eligible" class="eligible" src="eligible_check/eligible_check.php?docid=<?php echo $_SESSION['docid'];?>&pid=<?php echo $_GET['pid']; ?>">
    </iframe>
  </center>

<script src="js/eligible_check.js?v=20160721" type="text/javascript"></script>

<?php
}
include 'includes/bottom.htm';
?>


