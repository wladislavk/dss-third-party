<?php 
	include 'includes/top.htm';

	$s = "SELECT * FROM dental_insurance_history WHERE id='".mysql_real_escape_string($_GET['id'])."'";
	
	$r = $db->getRow($s);
?>
	<div class="fullwidth">
		<?php print_r($r); ?>
	</div>

<?php include 'includes/bottom.htm'; ?>
