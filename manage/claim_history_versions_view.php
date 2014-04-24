<?php 
include 'includes/top.htm';

  $s = "SELECT * FROM dental_insurance_history WHERE id='".mysql_real_escape_string($_GET['id'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  ?>
<div class="fullwidth">
<?php print_r($r); ?>
</div>
<?php

include 'includes/bottom.htm';
?>
