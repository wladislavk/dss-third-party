<?php
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

	$q1_sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";

	$q1_myarray = $db->getRow($q1_sql);
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
		$m_s = "Mrs.";
	} else {
		$h_h =  "his";
		$s_h =  "he";
		$h_h1 =  "him";
		$m_s = "Mr.";
	}
?>
	<br />
	<span class="admin_head">
		DSS SOAP for pt
	</span>
	<br />
	&nbsp;&nbsp;
	<a href="dss_letters.php?pid=<?php echo $_GET['pid'];?>" class="editlink" title="EDIT">
		<b>&lt;&lt;Back</b></a>
	<br /><br>
	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<?php echo date('F d, Y')?><br><br>

				Re: 	<strong><?php echo $name?></strong> <br>
				DOB:	<strong><?php echo st($pat_myarray['dob'])?></strong><br><br>


				<strong><?php echo $name?></strong> is a <strong><?php echo $age;?></strong> year old <strong><?php echo $pat_myarray['gender']?></strong> with a prior medical history that includes <strong><?php echo $history_disp;?></strong>.<br /><br />

				Subjective:  <strong><?php echo $name?></strong> presents with chief complaint(s) of (populate from chief complaints).//all info pages 1, sleep test (results),  3 and4 questionnaire<br /><br />

				Objective:  <strong><?php echo $name?></strong> underwent <strong>sleep test <?php echo $type_study;?></strong> monitor on <strong><?php echo date('F d, Y',strtotime($sleep_study_on))?></strong> date.  <?php echo ucwords($s_h);?> was diagnosed with <strong><?php echo $confirmed_diagnosis;?> <?php echo $custom_diagnosis;?></strong>.  <?php echo ucwords($s_h);?> had an AHI/RDI of <strong>???</strong>.  On his back, his AHI was <strong><?php echo $ahi?></strong>; during REM sleep his AHI was <strong>???</strong>.  He had a low O2 level of <strong>???</strong>;  and he spent <strong>???</strong>% of the night below 90% O2.//all of page 3 including CPAP<br /><br />

				The temporalis muscles are tender to palpation.  The teeth are in a Class I occlusion.  Range of motion is XX mm protrusive; XX mm to the Left; and XX mm to the right.  He can open XX mm.  The tongue is XX.  //all of page 4 then 5 then pages 1-3<br /><br />

				Assessment:  <strong><?php echo $name1?></strong> was diagnosed with <strong>???</strong>.  He  intolerant of CPAP//if the box is checked.  Otherwise, he is a good candidate for dental device therapy.//all of page 6<br /><br />

				Plan:  ****See My notes from DW on device placed**.Recommend XX.//all of page 7<br /><br />
			</td>
		</tr>
	</table>

<?php include 'includes/bottom.htm';?>