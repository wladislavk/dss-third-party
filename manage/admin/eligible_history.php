<?php
$sql = "SELECT * FROM dental_claim_electronic ORDER BY adddate DESC";
$my = mysqli_query($con, $sql);
$total_rec = mysqli_num_rows($my);

$my=mysqli_query($con, $sql) or die(mysqli_error($con));
$num_users=mysqli_num_rows($my);

?>

<div class="page-header">
	Claim History
</div>

<br />

<?php
  while($r = mysqli_fetch_assoc($my)){
$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = ".mysqli_real_escape_string($con, $r['claim_id']);
$cq = mysqli_query($con, $csql);
$claim = mysqli_fetch_assoc($cq);
	?><div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
		<h3>Claim Electronically filed on
    		<?= $r['adddate']; ?></h3>
		<p>Response: <?= $r['response'];?></p>
     		<h4>Webhook responses</h4> 
		<?php
			$w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysqli_real_escape_string($con, $r['reference_id'])."'";
			$w_q = mysqli_query($con, $w_sql);
			while($w_r = mysqli_fetch_assoc($w_q)){
			  ?><strong><?= $w_r['event_type']; ?></strong>
<?php $p = json_decode($w_r['response']); ?>
                                <p>Category: <?= $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
                                Status: <?= $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?= $p->{"details"}->{"codes"}->{"status_label"}; ?>
                                </p>

				<p><?= $w_r['response']; ?></p>
			<?php
			}
			?>
	</div><?php
  }
?>


