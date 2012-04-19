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
		<td>%patient_fullname%</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>%tyreferred% As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%.  %medicationssentence%  %patient_firstname% had a %type_study% done at the %1st_sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  However, %he/she% is waiting to begin treatment due to %delay_reason%.</p>

<p>Thank you again for your confidence and the referral.  We will keep you updated on %his/her% treatment progress.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";

?>
