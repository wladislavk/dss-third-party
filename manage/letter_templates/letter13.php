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
		<td>%patient_fullname% - DENTAL SLEEP DEVICE TREATMENT</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>We have a mutual patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %completed_ahi% after undergoing a %completed_type_study% done at the %completed_sleeplab_name%. %He/She% was referred to me %by_referral_fullname% for treatment of %his/her% sleep disordered breathing with a Mandibular Advancement Device.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  %He/She% is scheduled to begin treatment very soon.</p>

<p>We will keep you updated as treatment progresses.  Please keep us in mind for all of your patients who suffer from sleep disordered breathing.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";

?>
