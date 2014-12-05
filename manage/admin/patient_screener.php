<?php
include "includes/top.htm";
include "includes/patient_nav.php";
?>

<?php
  $s_sql = "SELECT * FROM dental_screener WHERE patient_id='".mysqli_real_escape_string($con,$_GET['pid'])."'";
  $s_q = mysqli_query($con,$s_sql);
  if(mysqli_num_rows($s_q)==0){
	?>No screener<?php
  }else{
  $myarray = mysqli_fetch_assoc($s_q); ?>

				<strong>Epworth Sleepiness Score</strong><br />
	<?php $ep_sql = "SELECT se.response, e.epworth 
				FROM dental_screener_epworth se
				JOIN dental_epworth e ON se.epworth_id =e.epworthid
				WHERE se.response > 0 AND se.screener_id='".mysqli_real_escape_string($con,$myarray['id'])."'";
		$ep_q = mysqli_query($con,$ep_sql);
		while($ep_r = mysqli_fetch_assoc($ep_q)){
		?>
		<?php echo  $ep_r['response']; ?> - <strong><?php echo  $ep_r['epworth']; ?></strong><br />
		<?php } ?>
		<?php echo  (!empty($ep['ep_total']) ? $ep['ep_total'] : ''); ?> - Total

	<br /><br />

			<strong>Health Symptoms</strong><br />
			<?php echo  ($myarray['breathing']>0)?'Yes - <strong>Have you ever been told you stop breathing while asleep?</strong><br />':''; ?>
                        <?php echo  ($myarray['driving']>0)?'Yes - <strong>Have you ever fallen asleep or nodded off while driving?</strong><br />':''; ?>
                        <?php echo  ($myarray['gasping']>0)?'Yes - <strong>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</strong><br />':''; ?>
                        <?php echo  ($myarray['sleepy']>0)?'Yes - <strong>Do you feel excessively sleepy during the day?</strong><br />':''; ?>
                        <?php echo  ($myarray['snore']>0)?'Yes - <strong>Do you snore or have you ever been told that you snore?</strong><br />':''; ?>
                        <?php echo  ($myarray['weight_gain']>0)?'Yes - <strong>Have you had weight gain and found it difficult to lose?</strong><br />':''; ?>
                        <?php echo  ($myarray['blood_pressure']>0)?'Yes - <strong>Have you taken medication for, or been diagnosed with high blood pressure?</strong><br />':''; ?>
                        <?php echo  ($myarray['jerk']>0)?'Yes - <strong>Do you kick or jerk your legs while sleeping?</strong><br />':''; ?>
                        <?php echo  ($myarray['burning']>0)?'Yes - <strong>Do you feel burning, tingling or crawling sensations in your legs when you wake up?</strong><br />':''; ?>
                        <?php echo  ($myarray['headaches']>0)?'Yes - <strong>Do you wake up with headaches during the night or in the morning?</strong><br />':''; ?>
                        <?php echo  ($myarray['falling_asleep']>0)?'Yes - <strong>Do you have trouble falling asleep?</strong><br />':''; ?>
                        <?php echo  ($myarray['staying_asleep']>0)?'Yes - <strong>Do you have trouble staying asleep once you fall asleep?</strong><br />':''; ?>

			<br />
			<strong>Co-morbidity</strong><br />
			<?php
			if (!empty($diagnosis)) foreach($diagnosis as $d){
				echo $d."<br />";
			}
			?>


<?php } ?>

<?php include 'includes/bottom.htm'; ?>
