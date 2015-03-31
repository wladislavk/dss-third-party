<?php
	session_start();
        require_once('includes/main_include.php');
	require_once('includes/sescheck.php');

if(isset($_GET['clear'])){

        $s = "DELETE FROM dental_claim_electronic WHERE reference_id IN 
                ('12312312', 
                '56565656',
                '11111111',
                '34343434',
                '12121212', 
                '45454545', 
                '67676767', 
                '78787878', 
                '89898989', 
                '919191919', 
                '202020202', 
                '212121212')";	

	mysql_query($s);
	?><h1>Test reference IDs deleted.</h1><?php

}

?>

<table>
<?php

	$s = "SELECT * FROM dental_claim_electronic WHERE reference_id IN 
		('12312312', 
		'56565656',
		'11111111',
		'34343434',
                '12121212', 
                '45454545', 
                '67676767', 
                '78787878', 
                '89898989', 
                '919191919', 
                '202020202', 
                '212121212')"; 
	$q = mysql_query($s);
	while($r = mysql_fetch_assoc($q)){
		?><tr>
		<td><?php echo $r['claimid']; ?></td>
                <td><?php echo $r['reference_id']; ?></td>		
		</tr><?php	
	} 

?>
</table>
<a href="clear_webhooks.php?clear=1" onclick="return prompt('Enter Code') =='dss999!';">Clear</a>
