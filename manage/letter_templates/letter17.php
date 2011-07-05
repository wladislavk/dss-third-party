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
		<td>%patient_fullname% - PATIENT NO LONGER DENTAL DEVICE COMPLIANT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear %salutation% %contact_lastname%:</p>

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% with a PMH that includes %history%.  %His/Her% medications include %medications%.  %patient_firstname% had a %type_study% done at the %sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>We delivered a %dental_device% dental device on %delivery_date%.</p>

<p>I regret to inform you that %he/she% has become non compliant with dental device therapy due to %noncomp_reason%.</p>

<p>I am referring her back to you to discuss other treatment alternatives.  Thank you again for the opportunity to participate in %patient_firstname%'s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:  %other_mds%<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%ccpatient_fullname%</p>";

?>
