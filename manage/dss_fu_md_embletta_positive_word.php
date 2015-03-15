<?php namespace Ds3\Legacy; ?><?php 
	# This line will stream the file to the user rather than spray it across the screen
	header("Content-type: application/octet-stream");

	# replace excelfile.xls with whatever you want the filename to default to
	header("Content-Disposition: attachment; filename=dss_fu_md_embletta_positive_".date('m-d-Y').".doc");
	header("Pragma: no-cache");
	header("Expires: 0");

	include "admin/includes/main_include.php";

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
		die();
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
	$sum_sql = "select * from dental_summary where patientid='".$_GET['pid']."'";

	$sum_myarray = $db->getRow($sum_sql);
	$sti_o2_1 = st($sum_myarray['sti_o2_1']);
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
		DSS FU MD embletta positive
	</span>
	<br /><br>
	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<p>
				<?php echo date('F d, Y')?>
				<br><br>
				<strong>
				<?php echo nl2br($referring_physician);?>
				</strong><br>
				<br>
				Re: 	<strong>
				<?php echo $name?>
				</strong> <br>
				DOB:	<strong>
				<?php echo st($pat_myarray['dob'])?>
				</strong><br>
				<br>
				Dear Dr. <strong>
				<?php echo $a_arr[0];?>
				</strong>,<br>
				<br>
				We have a mutual patient, <strong>
				<?php echo $name;?>
				</strong>. <strong>
				<?php echo $age;?>
				</strong> year old <strong>
				<?php echo $pat_myarray['gender']?>
				</strong> who was diagnosed with <strong>
				<?php echo confirmed_diagnosis;?> 
				<?php echo custom_diagnosis;?>
				</strong> after undergoing <strong>
				<?php echo $type_study;?>
				</strong> on <strong>
				<?php echo date('F d, Y',strtotime($sleep_study_on))?>
				</strong>, where he scored an AHI of <strong>
				<?php echo $ahi?>
				</strong> 
				<?php if($rdi <> '') {?>
				and or RDI of <strong>
				<?php echo $rdi?>
				</strong> 
				<?php }?> 
				.? <strong>???</strong>, and spent <strong><?php echo $sti_o2_1;?></strong> of the night below 90% O2.  <br />
				<br />
				We delivered <strong>???</strong> device  on <strong>???</strong>, and <strong><?php echo $s_h?></strong> has reported doing well with it.  I write to give you a progress update after the initial titration period and following a take home sleep study done with the state-of-the-art <strong>???</strong> sleep recorder.  <strong><?php echo $name1?>’s</strong> numbers, baseline and post appliance insertion, appear below.<br /><br />
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
				<strong><?php echo $name1?></strong> has been counseled that OSA is a progressive disease and I have stressed the importance of a team healthcare approach and disciplined follow up.  As you can see by the numbers, <strong><?php echo $name1?>’s</strong> treatment with dental sleep therapy appears to be <strong>???</strong>  and at this point and I believe <strong><?php echo $s_h?></strong> has reached the maximum medical improvement afforded by dental sleep therapy. <strong>(How will they check???)</strong><br><br>

				Please don’t hesitate to call if you have any questions.  I thank you again for the opportunity to participate in this patient’s treatment.<br><br>

				Sincerely,<br><br><br><br>
				<strong><?php echo $_SESSION['name']?>, DDS</strong><br><br>

				CC:  <strong><?php echo $name;?></strong>
				<br><br>
			</td>
		</tr>
	</table>
