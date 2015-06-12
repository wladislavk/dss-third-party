<?php namespace Ds3\Libraries\Legacy; ?><?php
	include 'includes/top.htm';

	$pat_sql = "select * from dental_patients where patientid='".s_for(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
	
	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);
	$name1 = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname']);
	if(/*empty($pat_myarray['patientid'])*/0)
	{
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}

	$ref_sql = "select * from dental_q_recipients where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
	
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

	$q2_sql = "select * from dental_q_page2 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
	
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
		$h_h =  "Her";
		$s_h =  "She";
		$h_h1 =  "her";
		$m_s = "Mrs.";
	} else {
		$h_h =  "His";
		$s_h =  "He";
		$h_h1 =  "him";
		$m_s = "Mr.";
	}
?>
	<br />
	<span class="admin_head">
		DSS to pt no treatment
	</span>
	<br />
	&nbsp;&nbsp;
	<a href="dss_letters.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>" class="editlink" title="EDIT">
		<b>&lt;&lt;Back</b></a>
	<br /><br>

	<div align="right">
		<button class="addButton" onclick="Javascript: window.open('dss_to_pt_no_treatment_print.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_to_pt_no_treatment_word.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<?php echo date('F d, Y')?><br><br>
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

				Thank you for taking the time to come in and consult with us regarding your diagnosis of <strong><?php echo $confirmed_diagnosis;?> <?php echo $custom_diagnosis;?></strong>. I hope that you found it was worth your time. We work very hard to be the best we can be.<br /><br />

				I understand your concern about the cost and wanting to know what insurance will cover, but in the meantime, I am concerned that you are not treating your sleep disordered breathing problem!  <br /><br />

				As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, stroke, as well as an increased risk for falling asleep while driving.  All of which can be reversed by successful treatment!  <br /><br />

				I look forward to working with you to help you sleep better and feel better.<br /><br />

				Sincerely,
				<br><br><br><br>
				<strong><?php echo $_SESSION['name']?>, DDS</strong><br><br>

				CC:  <strong><?php echo $a_arr[0];?></strong>
				<br><br>
			</td>
		</tr>
	</table>

<?php include 'includes/bottom.htm';?>
