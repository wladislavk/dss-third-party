<?php
$s_sql = "SELECT * FROM dental_screener WHERE patient_id='".mysql_real_escape_string($_GET['pid'])."'";
$myarray = $db->getRow($s_sql);
if($myarray){?>
<div style="float:right; margin:20px;">
    <a href="#" class="addButton" onclick="$('#screener').toggle(500);">View Screener</a>
</div>
<div class="fullwidth"  style="display:none;" id="screener">
    <strong>Epworth Sleepiness Score</strong><br />
<?php 
$ep_sql = "SELECT se.response, e.epworth 
            FROM dental_screener_epworth se
            JOIN dental_epworth e ON se.epworth_id =e.epworthid
            WHERE se.response > 0 AND se.screener_id='".mysql_real_escape_string($myarray['id'])."'";
$ep_q = $db->getResults($ep_sql);
foreach ($ep_q as $ep_r) {
    echo $ep_r['response'] . ' - <strong>' . $ep_r['epworth'] . '</strong><br />';
}
echo $ep['ep_total']; ?> - Total

<br /><br />

<strong>Health Symptoms</strong><br />
<?php echo ($myarray['breathing']>0)?'Yes - <strong>Have you ever been told you stop breathing while asleep?</strong><br />':'';
      echo ($myarray['driving']>0)?'Yes - <strong>Have you ever fallen asleep or nodded off while driving?</strong><br />':'';
      echo ($myarray['gasping']>0)?'Yes - <strong>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</strong><br />':'';
      echo ($myarray['sleepy']>0)?'Yes - <strong>Do you feel excessively sleepy during the day?</strong><br />':'';
      echo ($myarray['snore']>0)?'Yes - <strong>Do you snore or have you ever been told that you snore?</strong><br />':'';
      echo ($myarray['weight_gain']>0)?'Yes - <strong>Have you had weight gain and found it difficult to lose?</strong><br />':'';
      echo ($myarray['blood_pressure']>0)?'Yes - <strong>Have you taken medication for, or been diagnosed with high blood pressure?</strong><br />':'';
      echo ($myarray['jerk']>0)?'Yes - <strong>Do you kick or jerk your legs while sleeping?</strong><br />':'';
      echo ($myarray['burning']>0)?'Yes - <strong>Do you feel burning, tingling or crawling sensations in your legs when you wake up?</strong><br />':'';
      echo ($myarray['headaches']>0)?'Yes - <strong>Do you wake up with headaches during the night or in the morning?</strong><br />':'';
      echo ($myarray['falling_asleep']>0)?'Yes - <strong>Do you have trouble falling asleep?</strong><br />':'';
      echo ($myarray['staying_asleep']>0)?'Yes - <strong>Do you have trouble staying asleep once you fall asleep?</strong><br />':''; ?>

<br />
<strong>Co-morbidity</strong><br />
<?php
foreach($diagnosis as $d){
    echo $d."<br />";
}?>

</div>
<?php 
} ?>

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


<div id="hideshow2section2" style="width: 100%; margin: 0 auto; display: table;">
        <!--The sumadd script generates divs and tabular data from a db-->
        <?php include("dss_summADD.php"); ?>

</div>

<link rel="stylesheet" href="css/summ_subj.css" type="text/css" media="screen" />