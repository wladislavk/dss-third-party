<?php include 'includes/top.htm'; ?>

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
$s = "SELECT * FROM dental_document WHERE categoryid='".mysql_real_escape_string($_GET['cat'])."'";
$sq = mysql_query($s);
while($doc = mysql_fetch_assoc($sq)){ ?>
	<tr>
		<td>
			<?= $doc['name']; ?>
		</td>
		<td>
			<a target="_blank" href="q_file/<?= $doc['filename']; ?>">View</a>
		</td>
	</tr>
<?php } ?>

</table>

<?php include 'includes/bottom.htm'; ?>
