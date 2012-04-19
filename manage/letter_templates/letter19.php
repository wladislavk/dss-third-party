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
		<td>%patient_fullname% - DENTAL DEVICE TREATMENT RESULTS</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% and/or RDI of %1stRDI% after undergoing a %type_study% done at the %1st_sleeplab_name%.   %He/She% spent %1stTO290% % of the night below 90% sp O2, and had an O2 nadir of %1stLowO2%.</p>

<p>We delivered %dental_device% device on %delivery_date%, and %he/she% has reported doing well with it.  I write to give you a progress update after the initial titration period and following a take home sleep study. %patient_firstname%'s results, baseline and post appliance insertion appear below.</p>

<table cellpadding=\"7px\">
	<tr>
		<th>OBJECTIVE</th>
		<th>Before</th>
		<th>%1ststudy_date%&nbsp;&nbsp;&nbsp;&nbsp;</th>
		<th>After</th>
		<th>%2ndstudy_date%</th>
	</tr>
	<tr>
		<td>RDI / AHI</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stRDI/AHI%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndRDI/AHI%</td>
	</tr>
	<tr>
		<td>Low O2</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stLowO2%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndLowO2%</td>
	</tr>
	<tr>
		<td>T O2 &#8804; 90%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stTO290%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndTO290%</td>
	</tr>
	<tr>
		<td>ESS</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stESS%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndESS%</td>
	</tr>
	<tr>
		<th>SUBJECTIVE</th>
		<td colspan=\"2\" style=\"text-align:center;\"></td>
		<td colspan=\"2\" style=\"text-align:center;\"></td>
	</tr>
	<tr>
		<td>Snoring</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stSnoring%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndSnoring%</td>
	</tr>
	<tr>
		<td>Energy Level</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stEnergy%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndEnergy%</td>
	</tr>
	<tr>
		<td>Sleep Quality</td>
		<td colspan=\"2\" style=\"text-align:center;\">%1stQuality%</td>
		<td colspan=\"2\" style=\"text-align:center;\">%2ndQuality%</td>
	</tr>
</table>

<p>%patient_firstname% has been counseled that OSA is a progressive disease and I have stressed the importance of a team healthcare approach and disciplined follow up.   I believe we have reached maximum medical improvement with a dental device, and at this point I plan to refer %patient_firstname% back to your office for further medical care.</p>

<p>Please don't hesitate to call if you have any questions. I thank you again for the opportunity to participate in this patient's treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %nonpcp_mds%<br />
%ccpatient_fullname%</p>";

?>
