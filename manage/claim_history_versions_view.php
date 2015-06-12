<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include 'includes/top.htm';

	$s = "SELECT * FROM dental_insurance_history WHERE id='".mysqli_real_escape_string($con, !empty($_GET['id']) ? $_GET['id'] : '')."'";
	
	$r = $db->getRow($s);
?>
	<div class="fullwidth">
		<?php print_r($r); ?>
	</div>

<?php include 'includes/bottom.htm'; ?>
