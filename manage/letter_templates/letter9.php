<?php

$template = "<p>%todays_date%</p>
<p>
%referral_fullname%<br />
%referral_practice%
%ref_addr1%<br />
%ref_addr2%
%ref_city%, %ref_state% %ref_zip%<br />
</p>
<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - ACCEPTS TREATMENT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %referral_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% with a PMH that includes %history%.  %His/Her% medications include %medications%.  %patient_firstname% had a %type_study% done at the %1st_sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  %He/She% is scheduled to begin treatment as soon as we receive the dental device back from the lab</p>

<p>Thank you again for your confidence and the referral.  We will keep you updated as treatment progresses.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";

?>
