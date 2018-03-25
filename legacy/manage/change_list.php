<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include_once "includes/constants.inc";
?>
<div class="fullwidth">
	<?php
		$api_sql = "SELECT content FROM dental_change_list";
		$api_r = $db->getRow($api_sql);
		echo $api_r['content']; 
	?>
</div>
<div style="clear:both;"><br /></div>
<?php include 'includes/bottom.htm'; ?>

