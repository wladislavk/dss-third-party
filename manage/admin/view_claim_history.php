<?php 
include "includes/top.htm";
?>
<link rel="stylesheet" href="css/ledger.css" />
<?php
$sql = "SELECT * FROM dental_claim_electronic WHERE id='".mysqli_real_escape_string($con,$_GET['id'])."' ORDER BY adddate DESC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

$my = mysqli_query($con,$sql);
$num_users = mysqli_num_rows($my);

?>

<div class="page-header">
	Claim History
</div>

<br />

<?php
  while($r = mysqli_fetch_assoc($my)){
	?><div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
		<h3>Claim Electronically filed on
    		<?php echo  $r['adddate']; ?></h3>
		<p>Response: <?php echo  $r['response'];?></p>
     		<h4>Webhook responses</h4> 
		<?php
			$w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id='".mysqli_real_escape_string($con,$r['reference_id'])."'";
			$w_q = mysqli_query($con,$w_sql);
			while($w_r = mysqli_fetch_assoc($w_q)){
			  ?><strong><?php echo  $w_r['event_type']; ?></strong>
				<p><?php echo  $w_r['response']; ?></p>
				<?php $p = json_decode($w_r['response']); ?>
				<p>Category: <?php echo  $p->{"details"}->{"codes"}->{"category_code"}; ?> - <?php echo  $p->{"details"}->{"codes"}->{"category_label"}; ?><br />
				Status: <?php echo  $p->{"details"}->{"codes"}->{"status_code"}; ?> - <?php echo  $p->{"details"}->{"codes"}->{"status_label"}; ?>
				</p>
			<?php
			}
			?>
	</div><?php
  }
?>


<br /><br />	
<?php include "includes/bottom.htm";?>
