<?php namespace Ds3\Libraries\Legacy; ?><?php

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
		<td>%patient_fullname% - PATIENT NO LONGER DENTAL DEVICE COMPLIANT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

%patprogress%

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% after undergoing a %type_study% done at the %1st_sleeplab_name%.</p>

<p>We delivered a %dental_device% dental device on %delivery_date%.</p>

<p>I regret to inform you that %he/she% has become non compliant with dental device therapy due to %noncomp_reason%.</p>

<p>I am referring her back to you to discuss other treatment alternatives.  Thank you again for the opportunity to participate in %patient_firstname%'s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %nonpcp_mds%<br />
%ccpatient_fullname%</p>";

?>
