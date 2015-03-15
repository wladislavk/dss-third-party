<?php namespace Ds3\Legacy; ?><?php include 'includes/top.htm'; ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="75%">
			Name
		</td>
		<td valign="top" class="col_head" width="25%">
			Action
		</td>
	</tr>
<?php 
$s = "SELECT * FROM dental_document WHERE categoryid='".mysqli_real_escape_string($con,(!empty($_GET['cat']) ? $_GET['cat'] : ''))."'";
$sq = $db->getResults($s);
foreach ($sq as $doc) { ?>
	<tr>
		<td>
			<?php echo $doc['name']; ?>
		</td>
		<td>
			<a target="_blank" href="display_file.php?f=<?php echo $doc['filename']; ?>">View</a>
		</td>
	</tr>
<?php } ?>

</table>

<?php include 'includes/bottom.htm'; ?>
