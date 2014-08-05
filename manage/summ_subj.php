<?php
  $s_sql = "SELECT * FROM dental_screener WHERE patient_id='".mysql_real_escape_string($_GET['pid'])."'";
  $s_q = mysql_query($s_sql);
  if(mysql_num_rows($s_q)){ ?>
 <?php $myarray = mysql_fetch_assoc($s_q); ?>
<div style="float:right; margin:20px;">
    <a href="#" class="addButton" onclick="$('#screener').toggle(500);">View Screener</a>
</div>
    <div class="fullwidth"  style="display:none;" id="screener">
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



    </div>
  <?php } ?>

<table width="100%" align="center">
<tr>
<td style="background:#333; color:#FFFFFF; font-size: 14px; font-weight:bold; height:30px;" colspan="15">
Subjective Tests:
</td>
</tr>
</table>


<!--
        hideshow2section2
        The wrapper div keeps everything in a scrollable area
-->

<style>
        #hideshow2section2 input        { width:40px; }
        .followup-datatable                     { margin: 0; padding: 0; border: 0; }
        .followup-datatable tr          { height: 25px; }
        .followup-datatable tr td       { padding: 0 4px; }

        .followup-keytable                      { margin: 0; padding: 0; border: 0; }
        .followup-keytable tr           { height: 25px; }
        .followup-keytable tr td        { text-align: right; padding-right: 4px; font-weight: normal; }


</style>

<div id="hideshow2section2" style="width: 100%; margin: 0 auto; display: table;">
        <!--The sumadd script generates divs and tabular data from a db-->
        <?php include("dss_summADD.php"); ?>

</div>
<script type="text/javascript">
$(document).ready(function(){
  $('#hideshow2section2 input').change(function(){
    $(this).parents('form:first').find('td').css('background', 'rgb(173, 216, 230)');
    window.onbeforeunload = function(){
      return 'You have made changes to a Test and have not saved your changes. Click OK to leave the page, or Cancel to return and save your changes.';
    }
  })
});
</script>
