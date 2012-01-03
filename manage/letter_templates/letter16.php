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
%addr1%
%addr2%<br />
%city%, %state% %zip%<br />
</td>
</tr>
</table>
<p>&nbsp;</p>

<table>
  <tr>
		<td width=\"50px\">Re:</td>
		<td>%patient_fullname% - DENTAL DEVICE TREATMENT PROGRESS</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear %contact_salutation% %contact_lastname%:</p>

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% after undergoing a %type_study% done at the %1st_sleeplab_name%.

<p>We delivered a %dental_device% dental device on %delivery_date%.  We are now seeing %patient_firstname% for follow up.</p>

<p>The patient reports wearing the device %nightsperweek% nights. %His/Her% Epworth Sleepiness Scale / Thornton Snoring Scale has changed from %initESS/TSS% to %currESS/TSS%.  Additionally, %he/she% reports less snoring, improved daytime functioning, and more refreshing sleep.</p>

<p>We will continue to update you on %his/her% progress.  Thank you for the opportunity to participate in this patient's treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %nonpcp_mds%<br />
%ccpatient_fullname%</p>";

?>
