<?php 
	require_once('includes/constants.inc');
	include "includes/top.htm";
	include "includes/similar.php";
	include 'admin/classes/Db.php';

	$db = new Db();
?>

<link rel="stylesheet" href="css/screener.css" />

<?php
	if (isset($_REQUEST['delid'])) {
	  $sql = "DELETE FROM dental_screener where docid='".mysql_real_escape_string($_SESSION['docid'])."' AND id='".mysql_real_escape_string($_REQUEST['delid'])."'";
	  $db->query($sql);
	}

	if(isset($_REQUEST['hst'])){
	  $sql = "SELECT * FROM dental_screener WHERE id='".mysql_real_escape_string($_REQUEST['hst'])."'";
	  $r = $db->getRow($sql);

	  $sql = "SELECT * FROM dental_hst WHERE screener_id='".mysql_real_escape_string($r['id'])."'";
	  $h = $db->getRow($sql);

	  $dob = ($h['patient_dob'] != '') ? date('m/d/Y', strtotime($h['patient_dob'])) : '';

	  $pat_sql = "INSERT INTO dental_patients SET
				  docid='".mysql_real_escape_string($r['docid'])."',
				  firstname = '".mysql_real_escape_string($r['first_name'])."',
	              lastname = '".mysql_real_escape_string($r['last_name'])."',
	              cell_phone = '".mysql_real_escape_string($r['phone'])."',
				  email = '".mysql_real_escape_string($h['patient_email'])."',
				  dob = '".mysql_real_escape_string($dob)."',
				  status='1',
				  adddate = now(),
				  ip_address = '".$_SERVER['REMOTE_ADDR']."'";

	  error_log($pat_sql);
	  $pat_id = $db->getInsertId($pat_sql);
	  
	  $hst_sql = "UPDATE dental_hst SET
				  patient_id = '".$pat_id."',
				  status='".DSS_HST_PENDING."'
				  WHERE screener_id=".mysql_real_escape_string($r['id']);

	  $db->query($hst_sql);
			
	  $screener_sql = "UPDATE dental_screener SET
					   patient_id = '".$pat_id."',
					   contacted = '1'
					   WHERE id=".mysql_real_escape_string($r['id']);

	  $db->query($screener_sql);
?>
	  <script type="text/javascript">
	    window.location = 'manage_screeners.php';
	  </script>
<?php
	}		
?>

<link rel="stylesheet" type="text/css" href="css/manage_screeners.css">

<?php
	$rec_disp = 20;

	if ($_REQUEST["page"] != "") {
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

	$sql = "SELECT s.*, u.name, h.id as hst_id, h.status as hst_status
			FROM dental_screener s 
			INNER JOIN dental_users u ON s.userid = u.userid 
			LEFT JOIN dental_hst h ON h.screener_id = s.id
			WHERE s.docid='".$_SESSION['docid']."' ";

	if (isset($_GET['risk']) && $_GET['risk'] != '') {
	  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysql_real_escape_string($_GET['risk'])." ";
	}

	if (isset($_GET['contacted']) && $_GET['contacted'] != '') {
	  $sql .= " AND contacted = ".mysql_real_escape_string($_GET['contacted'])." ";
	}

	if (isset($_GET['contacted_risk']) && $_GET['contacted_risk'] != '') {
	  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysql_real_escape_string($_GET['contacted_risk'])." ";
	  $sql .= " AND contacted = 0 ";
	}

	$sql .= "ORDER BY ".$sort." ".$dir;

	$total_rec = $db->getNumberRows($sql);

	$no_pages = $total_rec/$rec_disp;

	$sql .= " limit ".$i_val.",".$rec_disp;
	$my = $db->getResults($sql);
	$my_num = count($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />

<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient Screeners
</span>

<br /><br />&nbsp;<br />

<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>

<div style="margin-left:20px;margin-bottom:10px;">

	<?php if ($_GET['risk'] >= 10) { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?risk=10" class="addButton">Show High/Severe</a>
	<?php } ?>

	<?php if (isset($_GET['contacted']) && $_GET['contacted'] == '0') { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?contacted=0" class="addButton">Show Not Contacted</a>
	<?php } ?>

	<?php if ($_GET['contacted_risk'] >= 10) { ?>
		<a href="manage_screeners.php" class="addButton">Show All</a>
	<?php } else { ?>
		<a href="manage_screeners.php?contacted_risk=10" class="addButton">Show High/Severe NOT Contacted</a>
	<?php } ?>

</div>

<div style="font-weight:bold; font-size: 14px; margin:0 auto; width: 300px; text-align:center;">
	<?php if ($_GET['risk'] >= 10) { ?>
		<p>Showing High/Severe Patients only</p>
	<?php } elseif (isset($_GET['contacted']) && $_GET['contacted'] == '0') { ?>
		<p>Showing NOT contacted patients only</p>
	<?php } elseif ($_GET['contacted_risk'] >= 10) { ?>
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
						paging($no_pages,$index_val,"contacted=".$_GET['contacted']."&contacted_risk=".$_GET['contacted_risk']."&risk=".$_GET['risk']."&sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
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
					$survey_total = $myarray['breathing'] + $myarray['driving'] + $myarray['gasping'] + $myarray['sleepy'] + $myarray['snore'] + $myarray['weight_gain'] + $myarray['blood_pressure'] + $myarray['jerk'] + $myarray['burning'] + $myarray['headaches'] + $myarray['falling_asleep'] + $myarray['staying_asleep'];
			        $sect3_total = $myarray['rx_cpap'] + $myarray['rx_blood_pressure'] + $myarray['rx_hypertension'] + $myarray['rx_heart_disease'] + $myarray['rx_stroke'] + $myarray['rx_apnea'] + $myarray['rx_diabetes'] + $myarray['rx_lung_disease'] + $myarray['rx_insomnia'] + $myarray['rx_depression'] + $myarray['rx_narcolepsy'] + $myarray['rx_medication'] + $myarray['rx_restless_leg'] + $myarray['rx_headaches'] + $myarray['rx_heartburn'];

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

				        <?php if ($survey_total > 15 || $ep['ep_total'] > 18 || $sect3_total > 3) {	?>
				        	<td valign="top" class="risk_severe"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">Severe</a></td>
				        <?php } elseif ($survey_total > 11 || $ep['ep_total'] > 14 || $sect3_total > 2) { ?>
							<td valign="top" class="risk_high"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">High</a></td>
						<?php } else if($survey_total > 7 || $ep['ep_total'] > 9 || $sect3_total > 1) { ?>
							<td valign="top" class="risk_moderate"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">Moderate</a></td>
						<?php } else { ?>
							<td valign="top" class="risk_low"><a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;">Low</a></td>
						<?php } ?>

						<td valign="top">
							<?php echo  ($myarray['rx_cpap']>0)?'Yes':'No'; ?>
						</td>

	                    <td valign="top">
							<?php echo  st($ep['ep_total']); ?>
	                    </td>

						<td valign="top">
							<?php
								$diagnosis = array();
								if ($myarray['rx_blood_pressure'] > 0) {
									array_push($diagnosis, 'High blood pressure');
								}

		                        if ($myarray['rx_hypertension'] > 0) {
		                            array_push($diagnosis, 'Hypertension');
		                        }

		                        if ($myarray['rx_heart_disease'] > 0) {
		                            array_push($diagnosis, 'Heart disease');
		                        }
		                        
		                        if ($myarray['rx_stroke'] > 0) {
		                            array_push($diagnosis, 'Stroke');
		                        }

	                            if ($myarray['rx_apnea'] > 0) {
	                                array_push($diagnosis, 'Sleep apnea');
	                            }

	                            if ($myarray['rx_diabetes'] > 0) {
	                                array_push($diagnosis, 'Diabetes');
	                            }

	                            if ($myarray['rx_lung_disease'] > 0) {
	                                array_push($diagnosis, 'Lung disease');
	                            }

	                            if ($myarray['rx_insomnia'] > 0) {
	                                array_push($diagnosis, 'Insomnia');
	                            }

	                            if ($myarray['rx_depression'] > 0) {
	                                array_push($diagnosis, 'Depression');
	                            }

	                            if ($myarray['rx_narcolepsy'] > 0) {
	                                array_push($diagnosis, 'Narcolepsy');
	                            }

	                            if ($myarray['rx_medication'] > 0) {
	                                array_push($diagnosis, 'Sleeping medication');
	                            }

	                            if ($myarray['rx_restless_leg'] > 0) {
	                                array_push($diagnosis, 'Restless Leg Syndrome');
	                            }

	                            if ($myarray['rx_headaches'] > 0) {
	                                array_push($diagnosis, 'Morning headaches');
	                            }

	                            if ($myarray['rx_heartburn'] > 0) {
	                                array_push($diagnosis, 'Heartburn (Gastroesophageal Reflux)');
	                            }
							?>

							<a href="#" onclick="$('#details_<?php echo  $myarray['id']; ?>').toggle(); return false;" id="diagnosis_count_<?php echo $myarray['id']; ?>">View</a>
						</td>

						<td valign="top">
					  		<?php if ($myarray['hst_id']) { 
								if($myarray['hst_status'] == DSS_HST_REQUESTED){
							?>
	                        	<?php
									$sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysql_real_escape_string($_SESSION['userid'])."'";
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
							<a href="manage_screeners.php?delid=<?php echo  $myarray['id']; ?>&page=<?php echo  $_REQUEST['page']; ?>" onclick="return confirm('Are you sure you want to delete this screener?');">Delete</a>
						</td>
					</tr>

					<tr id="details_<?php echo  $myarray['id']; ?>" style="display:none;">
						<td colspan="4" valign="top">
							<strong>Epworth Sleepiness Score</strong><br />

							<?php
								$ep_sql = "SELECT se.response, e.epworth 
										   FROM dental_screener_epworth se
										   JOIN dental_epworth e ON se.epworth_id =e.epworthid
										   WHERE se.response > 0 AND se.screener_id='".mysql_real_escape_string($myarray['id'])."'";
								
								$ep_q = $db->getResults($ep_sql);
								if (count($ep_q)) foreach ($ep_q as $ep_r) {
							?>
								<?php echo  $ep_r['response']; ?> - <strong><?php echo  $ep_r['epworth']; ?></strong><br />
							<?php } ?>

							<?php echo  $ep['ep_total']; ?> - Total
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
