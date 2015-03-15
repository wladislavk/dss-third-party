<?php namespace Ds3\Libraries\Legacy; ?><?php
$sql = "SELECT * FROM dental_claim_electronic ORDER BY adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<div class="page-header">
	Claim History
</div>

<br />

<?php
  while($r = mysql_fetch_assoc($my)){
$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = ".mysql_real_escape_string($r['claim_id']);
$cq = mysql_query($csql);
$claim = mysql_fetch_assoc($cq);
	?><div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
		<h3>Claim Electronically filed on
    		<?= $r['adddate']; ?></h3>
		<p>Response: <?= $r['response'];?></p>
     		<h4>Webhook responses</h4> 
		<?php
			$w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysql_real_escape_string($r['reference_id'])."'";
			$w_q = mysql_query($w_sql);
			while($w_r = mysql_fetch_assoc($w_q)){
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


