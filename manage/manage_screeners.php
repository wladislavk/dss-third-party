<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include "includes/top.htm";
	include "includes/similar.php";
	include_once('includes/constants.inc');
require_once __DIR__ . '/includes/screener-functions.php';

$coMorbidityLabels = coMorbidityLabels();
$coMorbidityWeights = coMorbidityWeights();

?>

<link rel="stylesheet" href="css/screener.css" />

<?php
	if (isset($_REQUEST['delid'])) {
	  $sql = "DELETE FROM dental_screener where docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND id='".mysqli_real_escape_string($con,$_REQUEST['delid'])."'";
	  $db->query($sql);
	}

	if(isset($_REQUEST['hst'])){
	  $sql = "SELECT * FROM dental_screener WHERE id='".mysqli_real_escape_string($con,$_REQUEST['hst'])."'";
	  $r = $db->getRow($sql);

	  $sql = "SELECT * FROM dental_hst WHERE screener_id='".mysqli_real_escape_string($con,$r['id'])."'";
	  $h = $db->getRow($sql);

	  $dob = ($h['patient_dob'] != '') ? date('m/d/Y', strtotime($h['patient_dob'])) : '';

	  $pat_sql = "INSERT INTO dental_patients SET
				  docid='".mysqli_real_escape_string($con,$r['docid'])."',
				  firstname = '".mysqli_real_escape_string($con,$r['first_name'])."',
	              lastname = '".mysqli_real_escape_string($con,$r['last_name'])."',
	              cell_phone = '".mysqli_real_escape_string($con,$r['phone'])."',
				  email = '".mysqli_real_escape_string($con,$h['patient_email'])."',
				  dob = '".mysqli_real_escape_string($con,$dob)."',
				  status='1',
				  adddate = now(),
				  ip_address = '".$_SERVER['REMOTE_ADDR']."'";

	  error_log($pat_sql);
	  $pat_id = $db->getInsertId($pat_sql);
	  
	  $hst_sql = "UPDATE dental_hst SET
				  patient_id = '".$pat_id."',
				  status='".DSS_HST_PENDING."'
				  WHERE screener_id=".mysqli_real_escape_string($con,$r['id']);

	  $db->query($hst_sql);
			
	  $screener_sql = "UPDATE dental_screener SET
					   patient_id = '".$pat_id."',
					   contacted = '1'
					   WHERE id=".mysqli_real_escape_string($con,$r['id']);

	  $db->query($screener_sql);
?>
	  <script type="text/javascript">
	    window.location = 'manage_screeners.php';
	  </script>
<?php
	}		
?>

<link rel="stylesheet" type="text/css" href="css/manage_display_similar.css">

<?php
	$rec_disp = 20;

	if (!empty($_REQUEST["page"])) {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}

	if (isset($_REQUEST['sort']) && $_REQUEST['sort'] != '') {
		switch ($_REQUEST['sort']) {
		    case 'adddate':
				$sort = "s.adddate";
				break;
		    case 'patient':
				$sort = "s.last_name";
				break;
		    case 'user':
				$sort = 'u.name';
				break;
		    case 'phone':
				$sort = 's.phone';
			    break;
	  	}
	} else {
	  $_REQUEST['sort'] = 'adddate';
	  $_REQUEST['sortdir'] = 'DESC';
	  $sort = "s.adddate";
	}

	if (isset($_REQUEST['sortdir']) && $_REQUEST['sortdir'] != '') {
	  $dir = $_REQUEST['sortdir'];
	} else {
	  $dir = 'DESC';
	}
		
	$i_val = $index_val * $rec_disp;

	$sql = "SELECT
            s.*,
            CASE WHEN LENGTH(TRIM(u.name))
                THEN u.name
                ELSE CONCAT(u.first_name, ' ', u.last_name)
            END AS name,
            h.id AS hst_id,
            h.status AS hst_status
        FROM dental_screener s
            INNER JOIN dental_users u ON s.userid = u.userid
            LEFT JOIN dental_hst h ON h.screener_id = s.id
        WHERE s.docid = '".$_SESSION['docid']."'";

	if (isset($_GET['risk']) && $_GET['risk'] != '') {
	  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysqli_real_escape_string($con,$_GET['risk'])." ";
	}

	if (isset($_GET['contacted']) && $_GET['contacted'] != '') {
	  $sql .= " AND contacted = ".mysqli_real_escape_string($con,$_GET['contacted'])." ";
	}

	if (isset($_GET['contacted_risk']) && $_GET['contacted_risk'] != '') {
	  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysqli_real_escape_string($con,$_GET['contacted_risk'])." ";
	  $sql .= " AND contacted = 0 ";
	}

	$sql .= "ORDER BY ".$sort." ".$dir;

	$total_rec = $db->getNumberRows($sql);

	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;
	$my = $db->getResults($sql);
	$my_num = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />

<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient Screeners
</span>

<br /><br />&nbsp;<br />

<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<div style="margin-left:20px;margin-bottom:10px;">

	<?php if (!empty($_GET['risk']) && $_GET['risk'] >= 10) { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?risk=10" class="addButton">Show High/Severe</a>
	<?php } ?>

	<?php if (isset($_GET['contacted']) && $_GET['contacted'] == '0') { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?contacted=0" class="addButton">Show Not Contacted</a>
	<?php } ?>

	<?php if (!empty($_GET['contacted_risk']) && $_GET['contacted_risk'] >= 10) { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?contacted_risk=10" class="addButton">Show High/Severe NOT Contacted</a>
	<?php } ?>

</div>

<div style="font-weight:bold; font-size: 14px; margin:0 auto; width: 300px; text-align:center;">
	<?php if (!empty($_GET['risk']) && $_GET['risk'] >= 10) { ?>
		<p>Showing High/Severe Patients only</p>
	<?php } elseif (isset($_GET['contacted']) && $_GET['contacted'] == '0') { ?>
		<p>Showing NOT contacted patients only</p>
	<?php } elseif (!empty($_GET['contacted_risk']) && $_GET['contacted_risk'] >= 10) { ?>
	        <p>Showing High/Severe NOT contacted patients only</p>
	<?php } else { ?>
		<p>Showing ALL Patients</p>
	<?php } ?>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<?php if ($total_rec > $rec_disp) { ?>
			<tr bgColor="#ffffff">
				<td align="right" colspan="15" class="bp">
					Pages:
					<?php
						paging($no_pages,$index_val,"contacted=".(!empty($_GET['contacted']) ? $_GET['contacted'] : '')."&contacted_risk=".(!empty($_GET['contacted_risk']) ? $_GET['contacted_risk'] : '')."&risk=".(!empty($_GET['risk']) ? $_GET['risk'] : '')."&sort=".(!empty($_GET['sort']) ? $_GET['sort'] : '')."&sortdir=".(!empty($_GET['sortdir']) ? $_GET['sortdir'] : ''));
					?>
				</td>
			</tr>
		<?php } ?>

		<tr class="tr_bg_h">
			<td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'adddate') ? 'arrow_'.strtolower($_REQUEST['sortdir']) : ''; ?>" width="20%">
				<a href="manage_screeners.php?sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Date</a>
			</td>

			<td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
				<a href="manage_screeners.php?sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
			</td>
      <td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="13%">
          <a href="manage_screeners.php?sort=phone&sortdir=<?php echo ($_REQUEST['sort']=='phone'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
      </td>

      <td valign="top" class="col_head"  width="10%">
          Risk 
      </td>

	<td valign="top" class="col_head" width="10%">
          CPAP
      </td>

      <td valign="top" class="col_head" width="10%">
		Epworth
      </td>
      <td valign="top" class="col_head" width="10%">
		Results	
      </td>
      <td valign="top" class="col_head" width="10%">
          HST
      </td>

			<td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'user')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
	            <a href="manage_screeners.php?sort=user&sortdir=<?php echo ($_REQUEST['sort']=='user'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Screened By</a>
	        </td>

	        <td valign="top" class="col_head" width="10%">
	            Contacted
	        </td>

			<td valign="top" class="col_head">
				Edit
			</td>
		</tr>

		<?php if ($my_num == 0) { ?>
			<tr class="tr_bg">
				<td valign="top" class="col_head" colspan="4" align="center">
					No Records
				</td>
			</tr>
		<?php } else {
				$epworth_labels[0] = 'No chance of dozing';
				$epworth_labels[1] = 'Slight chance of dozing';
		        $epworth_labels[2] = 'Moderate chance of dozing';
		        $epworth_labels[3] = 'High chance of dozing';

                foreach ($my as $myarray) {
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
					<tr>
						<td valign="top">
							<?php echo  date('m/d/Y h:i a', strtotime($myarray["adddate"]));?>
						</td>

						<td valign="top">
					  		<?php if ($myarray['patient_id'] != '') { ?>
								<a href="add_patient.php?ed=<?php echo $myarray['patient_id']; ?>&pid=<?php echo $myarray['patient_id']; ?>"><?php echo  st($myarray["first_name"]); ?> <?php echo  $myarray['last_name']; ?></a>
					  		<?php } else { ?>
	                            <?php echo  st($myarray["first_name"]); ?> <?php echo  $myarray['last_name']; ?>
					  		<?php } ?>
						</td>

	                    <td valign="top">
	                        <?php echo  st($myarray["phone"]); ?> 
	                    </td>

				        <?php if ($survey_total > 15 || $epTotal > 18 || $sect3_total > 3) {	?>
				        	<td valign="top" class="risk_severe"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">Severe</a></td>
				        <?php } elseif ($survey_total > 11 || $epTotal > 14 || $sect3_total > 2) { ?>
							<td valign="top" class="risk_high"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">High</a></td>
						<?php } else if($survey_total > 7 || $epTotal > 9 || $sect3_total > 1) { ?>
							<td valign="top" class="risk_moderate"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">Moderate</a></td>
						<?php } else { ?>
							<td valign="top" class="risk_low"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">Low</a></td>
						<?php } ?>

						<td valign="top">
							<?php echo  ($myarray['rx_cpap']>0)?'Yes':'No'; ?>
						</td>

	                    <td valign="top">
							<?= $epTotal ?>
	                    </td>

						<td valign="top">
							<a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;" id="diagnosis_count_<?php echo $myarray['id']; ?>">View</a>
						</td>

						<td valign="top">
					  		<?php if ($myarray['hst_id']) { 
								if($myarray['hst_status'] == DSS_HST_REQUESTED){
							?>
	                        	<?php
									$sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
									$sign_r = $db->getRow($sign_sql);
									$user_sign = $sign_r['sign_notes'];

	                                if($user_sign || $_SESSION['docid'] == $_SESSION['userid']) {
	                            ?>
	                                	<a href="manage_screeners.php?hst=<?php echo  $myarray['id']; ?>" onclick="return confirm('By clicking OK, you certify that you have discussed HST protocols with this patient and are legally qualified to request a HST for this patient. Your digital signature will be attached to this submission. You will be notified by the HST company when the patient\'s HST is complete.');" title="Authorize HST">
	                                        Authorize/Send
	                                    </a>
	                            <?php } else { ?>
									<a href="#" onclick="alert('You do not have sufficient permission to order a Home Sleep Test. Only a dentist may do this.');return false;" title="Authorize HST">
	                                    Authorize/Send
	                                </a>
	                            <?php } ?>
					  		<?php } else {
								echo $dss_hst_status_labels[$myarray['hst_status']];
								}
							} ?>
						</td>

						<td valign="top">
							<?php echo  $myarray['name']; ?>	
						</td>

						<td valign="top">
							<input type="checkbox" class="contact_chbx" value="<?php echo  $myarray['id']; ?>" <?php echo  ($myarray['contacted']==1)?'checked="checked"':'';?> />
						</td>

						<td>
							<a href="manage_screeners.php?delid=<?php echo  $myarray['id']; ?>&page=<?php echo  (!empty($_REQUEST['page']) ? $_REQUEST['page'] : ''); ?>" onclick="return confirm('Are you sure you want to delete this screener?');">Delete</a>
						</td>
					</tr>

					<tr id="details_<?php echo  $myarray['id']; ?>" style="display:none;">
						<td colspan="4" valign="top">
							<strong>Epworth Sleepiness Score</strong><br />

							<?php if (count($ep_q)) foreach ($ep_q as $ep_r) { ?>
                                <?= $ep_r['response'] ?> - <strong><?= $ep_r['epworth']; ?></strong><br />
                            <?php } ?>
							<?= $epTotal ?> - Total
						</td>

						<td valign="top" colspan="6">
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
								foreach($diagnosis as $d){
									echo $d."<br />";
								}
							?>
						</td>
					</tr>
				<?php }
			}?>
	</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>

    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>

<div id="backgroundPopup"></div>

<br /><br />

<? include "includes/bottom.htm";?>

<script src="js/manage_screeners.js" type="text/javascript"></script>
