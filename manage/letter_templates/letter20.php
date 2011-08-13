<?php

$template = "<p>%todays_date%</p>
<p>
%ptreferral_fullname%<br />
%ptref_addr1%<br />
%ptref_addr2%
%ptref_city%, %ptref_state% %ptref_zip%<br />
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

<p>Dear %ptreferral_firstname% %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  There is no greater compliment than for someone such as you to refer a colleague, friend, or family member.</p>

<p>Thank you again for your confidence and the referral!</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";

?>
