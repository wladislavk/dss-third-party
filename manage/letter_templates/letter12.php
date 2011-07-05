<?php

$template = "<p>%todays_date%</p>
<p>
%contact_fullname%<br />
%practice%
%addr1%<br />
%addr2%
%city%, %state% %zip%</p>
<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - PATIENT DID NOT ATTEND CONSULTATION</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office.</p>

<p>I appreciate your confidence and the referral, but I regret to inform you that our attempts to arrange a consultation with %patient_firstname% have been unsuccessful.  Please be aware that %he/she% may not be treating her sleep disordered breathing.</p>

<p>Again, thank you and please continue to keep us in mind for all of your mild to moderate sleep apneics, as well as those who cannot tolerate CPAP.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%</p>

<p>cc:  %other_mds%</p>";

?>
