<?php
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="keywords" content="<?php echo st($page_myarray['keywords']);?>" />
		<title><?php echo $sitename;?> | <?php echo $name;?> - DSS intro to MD from dentist</title>
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
	</head>

	<body onLoad="window.print(); window.close();">
		<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
		  	<tr bgcolor="#FFFFFF">
		    	<td colspan="2" > 
					<br />
					<span class="admin_head">
						DSS intro to MD from dentist
					</span>

					<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
						<tr>
							<td valign="top">
								<strong>
								?????
								</strong>
								<br><br>
								Dear <strong>Doctor</strong>:<br><br>

								Thank you for allowing me a few minutes of your time.  My name is Dr. <strong><?php echo $_SESSION['name']?></strong>, and I am a dentist who has partnered with Dental Sleep Solutions, a company committed to maximizing successful treatment options for patients who suffer from sleep disordered breathing.    As a Dental Sleep Solutions dentist, I have received training from nationally known board certified dentists and adhere to practice protocols that are consistent with the highest levels of patient care. <br><br>

								We welcome your referrals for the treatment of snoring, upper airway resistance syndrome, and obstructive sleep apnea (OSA). We evaluate patients individually and recommend treatment plans based on disease severity and patient preferences. We follow the guidelines as laid down by the AASM’s position paper on the parameters  for use of oral appliances in the treatment of OSA, as appeared  in the Feb., 2006 issue of Sleep.   It states that oral appliances may be used as a first line of therapy for patients with mild to moderate OSA as well as for patients who are severe OSA and have failed CPAP or who prefer them to CPAP.  <br><br>

								We are working closely with physicians like you who recognize the importance of diagnosing and treating this illness.  As awareness of the ill effects of OSA (hypertension, MI, CHF, stroke, fatigue, impotence, mood swings, and dozing accidents) increases in the public’s eye, all of medicine will begin to see an increasing number of patients asking questions about snoring and sleep apnea and seeking treatment options.<br><br>

								I have included an informational brochure as well as a simple referral form, making the referral process easy for you and the patient.  <br><br>

								Again, thank you for your time, and I look forward to working with you.<br><br>

								Regards,<br><br><br><br>
								Dr. <?php echo $_SESSION['name']?>, DDS<br><br>
							</td>
						</tr>
					</table>
					<br /><br />	
				</td>
			</tr>
		</table>
	</body>
</html>