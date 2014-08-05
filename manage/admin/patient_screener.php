<?php
include "includes/top.htm";
include "includes/patient_nav.php";
?>

<?php
  $s_sql = "SELECT * FROM dental_screener WHERE patient_id='".mysql_real_escape_string($_GET['pid'])."'";
  $s_q = mysql_query($s_sql);
  if(mysql_num_rows($s_q)==0){
	?>No screener<?php
  }else{
  $myarray = mysql_fetch_assoc($s_q); ?>

				<strong>Epworth Sleepiness Score</strong><br />
	<?php $ep_sql = "SELECT se.response, e.epworth 
				FROM dental_screener_epworth se
				JOIN dental_epworth e ON se.epworth_id =e.epworthid
				WHERE se.response > 0 AND se.screener_id='".mysql_real_escape_string($myarray['id'])."'";
		$ep_q = mysql_query($ep_sql);
		while($ep_r = mysql_fetch_assoc($ep_q)){
		?>
		<?= $ep_r['response']; ?> - <strong><?= $ep_r['epworth']; ?></strong><br />
		<?php } ?>
		<?= $ep['ep_total']; ?> - Total

	<br /><br />

			<strong>Health Symptoms</strong><br />
			<?= ($myarray['breathing']>0)?'Yes - <strong>Have you ever been told you stop breathing while asleep?</strong><br />':''; ?>
                        <?= ($myarray['driving']>0)?'Yes - <strong>Have you ever fallen asleep or nodded off while driving?</strong><br />':''; ?>
                        <?= ($myarray['gasping']>0)?'Yes - <strong>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</strong><br />':''; ?>
                        <?= ($myarray['sleepy']>0)?'Yes - <strong>Do you feel excessively sleepy during the day?</strong><br />':''; ?>
                        <?= ($myarray['snore']>0)?'Yes - <strong>Do you snore or have you ever been told that you snore?</strong><br />':''; ?>
                        <?= ($myarray['weight_gain']>0)?'Yes - <strong>Have you had weight gain and found it difficult to lose?</strong><br />':''; ?>
                        <?= ($myarray['blood_pressure']>0)?'Yes - <strong>Have you taken medication for, or been diagnosed with high blood pressure?</strong><br />':''; ?>
                        <?= ($myarray['jerk']>0)?'Yes - <strong>Do you kick or jerk your legs while sleeping?</strong><br />':''; ?>
                        <?= ($myarray['burning']>0)?'Yes - <strong>Do you feel burning, tingling or crawling sensations in your legs when you wake up?</strong><br />':''; ?>
                        <?= ($myarray['headaches']>0)?'Yes - <strong>Do you wake up with headaches during the night or in the morning?</strong><br />':''; ?>
                        <?= ($myarray['falling_asleep']>0)?'Yes - <strong>Do you have trouble falling asleep?</strong><br />':''; ?>
                        <?= ($myarray['staying_asleep']>0)?'Yes - <strong>Do you have trouble staying asleep once you fall asleep?</strong><br />':''; ?>

			<br />
			<strong>Co-morbidity</strong><br />
			<?php
			foreach($diagnosis as $d){
				echo $d."<br />";
			}
			?>


<?php } ?>

<?php include 'includes/bottom.htm'; ?>
