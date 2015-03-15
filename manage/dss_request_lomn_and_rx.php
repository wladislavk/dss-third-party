<?php namespace Ds3\Legacy; ?><?php
	include 'includes/top.htm';

	$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";

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
		DSS request LOMN and Rx
	</span>
	<br />
	&nbsp;&nbsp;
	<a href="dss_letters.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>" class="editlink" title="EDIT">
		<b>&lt;&lt;Back</b></a>
	<br /><br>

	<div align="right">
		<button class="addButton" onclick="Javascript: window.open('dss_request_lomn_and_rx_print.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','Print_letter','width=800,height=500,scrollbars=1');" >
			Print Letter 
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="addButton" onclick="Javascript: window.open('dss_request_lomn_and_rx_word.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','word_letter','width=800,height=500,scrollbars=1');" >
			Word Document
		</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
	</div>

	<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top">
				<?php echo date('F d, Y')?><br><br>

				Re: 	<strong><?php echo $name?></strong> <br>
				DOB:	<strong><?php echo st($pat_myarray['dob'])?></strong><br>
				SSN:	<strong><?php echo st($pat_myarray['ssn'])?></strong><br><br>

				Dr. <strong><?php echo $a_arr[0];?></strong>,<br><br>

				We need your help with getting some insurance coverage for dental device therapy for <strong><?php echo $name?></strong>.<br /><br />

				Can you please provide us with the following:<br /><br />

				<ul>
					<li>Letter of Medical Necessity</li>
					<li>Prescription for Oral Appliance Therapy</li>
				</ul>
				Please fax this back to 941 778 7602 at your earliest convenience.  <br /><br />

				Thank you again for your help.  Please continue to keep us in mind for all of your mild to moderate OSA patients, as well as those who are intolerant of CPAP.<br /><br />

				Regards,<br /><br /><br /><br />
				<strong><?php echo $_SESSION['name']?>, DDS</strong><br><br>
			</td>
		</tr>
	</table>

<?php include 'includes/bottom.htm';?>
