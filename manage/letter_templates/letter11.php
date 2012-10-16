<?php

$template = "
<p>
%franchisee_fullname%<br />
%franchisee_practice%<br />
%franchisee_addr%
</p><p>&nbsp;</p>
<p>%todays_date%</p>
<p>&nbsp;</p>
<table border=\"0\">
<tr>
<td width=\"70\"></td>
<td>
%contact_fullname%<br />
%practice%
%addr1%%addr2%<br />
%city%, %state% %zip%<br />
</td>
</tr>
</table>
<p>&nbsp;</p>
<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - PATIENT REFUSED TREATMENT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%.  %medicationssentence% %patient_firstname% had a %completed_type_study% done at the %completed_sleeplab_name% which showed an AHI of %completed_ahi%; %he/she% was diagnosed with %completed_diagnosis%.</p>

<p>I regret to inform you that the patient has refused treatment with a dental sleep device.  I am referring %him/her% back to you to discuss other treatment options.</p>

<p>Thank you again for your confidence and the referral.  We are committed to helping patients successfully treat their sleep disordered breathing.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";

?>
