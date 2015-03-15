<?php namespace Ds3\Legacy; ?><?php
$message = html_entity_decode($_REQUEST['message']);
?>

<table width="624px">
	<tr>
		<td height="86px"></td>
	</tr>
	<tr>
		<td><?php print $message; ?></td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>


<script type="text/javascript">
 window.print();
</script>
