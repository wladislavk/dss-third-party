<?php
	# This line will stream the file to the user rather than spray it across the screen
	header("Content-type: application/octet-stream");

	# replace excelfile.xls with whatever you want the filename to default to
	header("Content-Disposition: attachment; filename=dss_request_lomn_and_rx_".date('m-d-Y').".doc");
	header("Pragma: no-cache");
	header("Expires: 0");

	include "admin/includes/main_include.php";

	$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
	
	$pat_myarray = $db->getRow($pat_sql);
	$name = st((!empty($pat_myarray['salutation']) ? $pat_myarray['salutation'] : ''))." ".st((!empty($pat_myarray['firstname']) ? $pat_myarray['firstname'] : ''))." ".st((!empty($pat_myarray['middlename']) ? $pat_myarray['middlename'] : ''))." ".st((!empty($pat_myarray['lastname']) ? $pat_myarray['lastname'] : ''));
	$name1 = st((!empty($pat_myarray['salutation']) ? $pat_myarray['salutation'] : ''))." ".st((!empty($pat_myarray['firstname']) ? $pat_myarray['firstname'] : ''));
	if(empty($pat_myarray['patientid'])) {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		die();
	}

	$ref_sql = "select * from dental_q_recipients where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
	
	$ref_myarray = $db->getRow($ref_sql);
	$referring_physician = st((!empty($ref_myarray['referring_physician']) ? $ref_myarray['referring_physician'] : ''));
	$a_arr = explode('
	',$referring_physician);
	if(!empty($pat_myarray['dob'])) {
		$dob_y = date('Y',strtotime(st($pat_myarray['dob'])));
		$cur_y = date('Y');
		$age = $cur_y - $dob_y;
	} else { 
		$age = 'N/A';
	}

	if(!empty($pat_myarray['gender']) && st($pat_myarray['gender']) == 'Female') {
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
	<br /><br>
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