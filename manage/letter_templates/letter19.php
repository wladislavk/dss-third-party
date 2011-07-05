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
		<td>%patient_fullname% - DENTAL DEVICE TREATMENT RESULTS</td>
	</tr>
	<tr>
		<td width=\"50px\">DOB:</td>
		<td>%patient_dob%</td>
	</tr>
</table>

<p>Dear %salutation% %contact_lastname%:</p>

<p>We have a mutual patient, %patient_fullname%, a %patient_age% year old %patient_gender% who was diagnosed with %2nddiagnosis% after undergoing %2ndtype_study% on %2ndstudy_date% where %he/she% scored an AHI of %2ndahi% and/or RDI of %2ndrdi%; and spent %2ndO2Sat90%% of the night below 90% O2.</p>

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
cc:  %patient_fullname%</p>";

?>
