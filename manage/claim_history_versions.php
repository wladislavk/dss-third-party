<?php namespace Ds3\Legacy; ?><?php
  $s = "SELECT * FROM dental_insurance_history WHERE insuranceid='".mysqli_real_escape_string($con, !empty($_GET['cid']) ? $_GET['cid'] : '')."'";
  
  $q = $db->getResults($s);
?>

<table class="fullwidth">
  <tr>
    <th>Date</th>
    <th>Action</th>
  </tr>
  
  <?php
    if ($q) foreach ($q as $r){
  ?>
    	<tr>
    	  <td><?php echo  date('m/d/Y h:i', strtotime($r['updated_at'])); ?></td>
    	  <td><a href="claim_history_versions_view.php?id=<?php echo  $r['id']; ?>">View</a></td>
    	</tr>
  <?php
    }
  ?>

</table>
