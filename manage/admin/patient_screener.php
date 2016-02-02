<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/patient_nav.php';
require_once __DIR__ . '/../includes/screener-functions.php';

$coMorbidityLabels = coMorbidityLabels();
$coMorbidityWeights = coMorbidityWeights();

$myarray = $db->getRow("SELECT s.*
    FROM dental_screener s
        JOIN dental_hst h ON h.screener_id = s.id
    WHERE h.patient_id = '" . intval($_GET['pid']) . "'");

if (!$myarray) { ?>
    No screener
<?php } else {
    $ep_sql = "SELECT se.response, e.epworth
        FROM dental_screener_epworth se
            JOIN dental_epworth e ON se.epworth_id = e.epworthid
        WHERE se.response > 0
            AND se.screener_id = '" . intval($myarray['id']) . "'";
    $ep_q = $db->getResults($ep_sql);

    $epTotal = 0;

    if (count($ep_q)) foreach ($ep_q as $ep_r) {
        $epTotal += $ep_r['response'];
    }

    $survey_total = $myarray['breathing'] +
        $myarray['driving'] +
        $myarray['gasping'] +
        $myarray['sleepy'] +
        $myarray['snore'] +
        $myarray['weight_gain'] +
        $myarray['blood_pressure'] +
        $myarray['jerk'] +
        $myarray['burning'] +
        $myarray['headaches'] +
        $myarray['falling_asleep'] +
        $myarray['staying_asleep'];

    /**
     * Instead of relying on the field values, sum based on a lookup list.
     *
     * Due a mistake on a previous task, the DB values during certain period might be wrong.
     */
    $sect3_total = coMorbiditySum($myarray);

    $diagnosis = array();

    foreach ($coMorbidityLabels as $fieldName=>$legend) {
        if ($myarray[$fieldName]) {
            $diagnosis []= $legend;
        }
    }

    ?>
				<strong>Epworth Sleepiness Score</strong><br />
	<?php foreach ($ep_q as $ep_r) { ?>
		<?php echo  $ep_r['response']; ?> - <strong><?php echo  $ep_r['epworth']; ?></strong><br />
		<?php } ?>
		<?= $epTotal ?> - Total

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
                        <?php echo  ($myarray['rx_cpap']>0)?'<br /> Yes - <strong>Have you ever used CPAP before?</strong><br />':''; ?>

			<br />
			<strong>Co-morbidity</strong><br />
			<?php
			if (!empty($diagnosis)) foreach($diagnosis as $d){
				echo $d."<br />";
			}
			?>


<?php } ?>

<?php include 'includes/bottom.htm'; ?>
