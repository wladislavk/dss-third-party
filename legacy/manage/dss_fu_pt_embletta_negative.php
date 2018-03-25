<?php namespace Ds3\Libraries\Legacy; ?><?php
	include 'includes/top.htm';

	$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);
	$name1 = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname']);
	if($pat_myarray['patientid'] == '') {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}

	$ref_sql = "select * from dental_q_recipients where patientid='".$_GET['pid']."'";
	
	$ref_myarray = $db->getRow($ref_sql);
	$referring_physician = st($ref_myarray['referring_physician']);
	$a_arr = explode('
	',$referring_physician);
	if(st($pat_myarray['dob']) <> '' ) {
		$dob_y = date('Y',strtotime(st($pat_myarray['dob'])));
		$cur_y = date('Y');
		$age = $cur_y - $dob_y;
	} else {
		$age = 'N/A';
	}

	$q3_sql = "select * from dental_q_page3 where patientid='".$_GET['pid']."'";
	
	$q3_myarray = $db->getRow($q3_sql);
	$history = st($q3_myarray['history']);
	$medications = st($q3_myarray['medications']);
	$history_arr = explode('~',$history);
	$history_disp = '';
	foreach($history_arr as $val) {
		if(trim($val) <> "") {
			$his_sql = "select * from dental_history where historyid='".trim($val)."' and status=1 ";
			
			$his_myarray = $db->getRow($his_sql);
			if(st($his_myarray['history']) <> '') {
				if($history_disp <> '') $history_disp .= ' and ';	
				$history_disp .= st($his_myarray['history']);
			}
		}
	}

	$medications_arr = explode('~',$medications);
	$medications_disp = '';
	foreach($medications_arr as $val) {
		if(trim($val) <> "") {
			$medications_sql = "select * from dental_medications where medicationsid='".trim($val)."' and status=1 ";
			
			$medications_myarray = $db->getRow($medications_sql);		
			if(st($medications_myarray['medications']) <> '') {
				if($medications_disp <> '') $medications_disp .= ', ';
				$medications_disp .= st($medications_myarray['medications']);
			}
		}
	}

	$q2_sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";

	$q2_myarray = $db->getRow($q2_sql);
	$polysomnographic = st($q2_myarray['polysomnographic']);
	$sleep_center_name = st($q2_myarray['sleep_center_name']);
	$sleep_study_on = st($q2_myarray['sleep_study_on']);
	$confirmed_diagnosis = st($q2_myarray['confirmed_diagnosis']);
	$rdi = st($q2_myarray['rdi']);
	$ahi = st($q2_myarray['ahi']);
	$type_study = st($q2_myarray['type_study']);
	$custom_diagnosis = st($q2_myarray['custom_diagnosis']);

	if(st($pat_myarray['gender']) == 'Female') {
		$h_h =  "her";
		$s_h =  "she";
		$h_h1 =  "her";
		$m_m = "Mrs.";
	} else {
		$h_h =  "his";
		$s_h =  "he";
		$h_h1 =  "him";
		$m_m = "Mr.";
	}
?>
	<br />
	<span class="admin_head">
		DSS FU pt embletta negative
	</span>
	<br />
	&nbsp;&nbsp;
	<a href="dss_letters.php?pid=<?php echo $_GET['pid'];?>" class="editlink" title="EDIT">
		<b>&lt;&lt;Back</b></a>
	<br /><br>
	<div align="right">
		<button class="addButton" onclick="Javascript: window.open('dss_fu_pt_embletta_negative_print.php?pid=<?php echo $_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_fu_pt_embletta_negative_word.php?pid=<?php echo $_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<?php echo date('F d, Y')?>
				<br><br>
				<strong>
				<?php echo $name;?>
				<?php if(st($pat_myarray['add1']) <> '') { ?>
					<br /><?php echo st($pat_myarray['add1']);?>	
				<?php } ?>

				<?php if(st($pat_myarray['add2']) <> '') { ?>
					<br /><?php echo st($pat_myarray['add2']);?>	
				<?php } ?>
				&nbsp;
				<?php echo st($pat_myarray['city']);?>	
				&nbsp;
				<?php echo st($pat_myarray['state']);?>	
				&nbsp;
				<?php echo st($pat_myarray['zip']);?>	
				</strong>
				<br><br>
				Dear <strong><?php echo st($pat_myarray['firstname']);?></strong>,<br><br>

				Thank you for taking the time to undergo the overnight sleep study utilizing the <strong>???</strong> sleep recorder.   I have summarized the results in the table below.  The �Before� column refers to your last sleep study, while the �After� column is with your dental sleep device in place.  Dental Sleep Solutions dentists adhere to the most stringent criteria for successful treatment.  We define successful treatment as a reduction in your AHI / RDI by at least one half and to a level below 10. <br /><br />

				We delivered <strong>???</strong> device  on <strong>???</strong>, and <strong><?php echo $s_h?></strong> has reported doing well with it.  I write to give you a progress update after the initial titration period and following a take home sleep study done with the state-of-the-art <strong>???</strong> sleep recorder.  <strong><?php echo $name1?>�s</strong> numbers, baseline and post appliance insertion, appear below.<br /><br />
				<table width="98%" border="1" cellspacing="0" cellpadding="6">
					<tr>
						<td width="214" valign="top">&nbsp;</td>
						<td width="85" valign="top" align="center">Before</td>
						<td width="85" valign="top" align="center">8-22-06</td>
						<td width="93" valign="top" align="center">After</td>
						<td width="93" valign="top" align="center">12-2-06</td>
					</tr>
					<tr>
						<td valign="top">RDI / AHI</td>
						<td colspan="2" valign="top" align="center">24.7 (REM 33)</td>
						<td colspan="2" valign="top" align="center">4.3</td>
					</tr>
					<tr>
						<td valign="top">Low O2</td>
						<td colspan="2" valign="top" align="center">80%</td>
						<td colspan="2" valign="top" align="center">86%</td>
					</tr>
					<tr>
						<td valign="top">T O2 &le; 90%</td>
						<td colspan="2" valign="top">&nbsp;</td>
						<td colspan="2" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">ESS</td>
						<td colspan="2" valign="top">&nbsp;</td>
						<td colspan="2" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">Snoring</td>
						<td colspan="2" valign="top">&nbsp;</td>
						<td colspan="2" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">
							***Other Summary Sheet info 
							<br />(break down into subjective and Objective)
						</td>
						<td colspan="2" valign="top">&nbsp;</td>
						<td colspan="2" valign="top">&nbsp;</td>
					</tr>
				</table>
				<br />
				As you can see, the results of this study show that with your <strong>???</strong> device in place at the current setting, your overall RDI or AHI has not improved to a successful point (as defined above).  We need to talk about your options from here forward.  <br />
				<ul>
					<li>Combine a dental sleep device with CPAP (hybrid therapy)</li>
					<li>Further adjustment of your <strong>???</strong></li>
					<li>Referral back to your physician to discuss treatment alternatives</li>
					<li>Continue treatment with the dental sleep device at the current setting.  Understand that failure to successfully treat Obstructive Sleep Apnea may result many serious and life threatening negative medical outcomes</li>
				</ul>
				Please understand that Obstructive Sleep Apnea is a serious medical disorder and we recommend that you seek care with other methods to avoid possible these unwanted medical outcomes.  Caution should also be taken while driving.  After we decide on a plan, I will inform your physician(s) of our decision.  I welcome any questions you may have.   <br /><br />

				Thank you again for the opportunity to work with you.  Please don�t hesitate to call if you have any questions.  <br /><br />

				Sincerely,<br><br><br><br>
				<strong><?php echo $_SESSION['name']?>, DDS</strong><br><br>

				CC:  <strong><?php echo $name;?></strong>
				<br><br>
			</td>
		</tr>
	</table>

<?php include 'includes/bottom.htm';?>
