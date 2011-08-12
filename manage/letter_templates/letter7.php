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
		<td>%patient_fullname%</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %referral_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%.  %patient_firstname% had a %type_study% done at the %sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>I very much appreciate your confidence and the referral, but I regret to inform you that %patient_firstname% is not a candidate for dental device therapy.  I have counseled %him/her% to return to your office to discuss other treatment options.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";


?>
