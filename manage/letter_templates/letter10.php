<?php

$template = "<p>%todays_date%</p>
<p>
%contact_fullname%<br />
%practice%
%addr1%<br />
%addr2%
%city%, %state% %zip%<br />
</p>
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

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% with a PMH that includes %history%.  %His/Her% medications include %medications%.  %patient_firstname% had a %type_study% done at the %sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  However, %he/she% is waiting to begin treatment due to %delay_reason%.</p>

<p>Thank you again for your confidence and the referral.  We will keep you updated on %his/her% treatment progress.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:  %other_mds%</p>";

?>
