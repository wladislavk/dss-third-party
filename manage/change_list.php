<? 
include "includes/top.htm";
include_once "includes/constants.inc";

?>
<div class="fullwidth">
<?php
  $api_sql = "SELECT content FROM dental_change_list";
  $api_q = mysql_query($api_sql);
  $api_r = mysql_fetch_assoc($api_q);
echo $api_r['content']; 
?></div><div style="clear:both;"><br /></div><?php
include 'includes/bottom.htm';
?>

