<?php

  $s = "SELECT * FROM dental_insurance_history WHERE insuranceid='".mysql_real_escape_string($_GET['cid'])."'";
  $q = mysql_query($s);
?>
<table class="fullwidth">
  <tr>
    <th>Date</th>
    <th>Action</th>
  </tr>
<?php
  while($r = mysql_fetch_assoc($q)){

    ?>
	<tr>
	  <td><?= date('m/d/Y h:i', strtotime($r['updated_at'])); ?></td>
	  <td><a href="claim_history_versions_view.php?id=<?= $r['id']; ?>">View</a></td>
	</tr>
    <?php
  }

?>

</table>
