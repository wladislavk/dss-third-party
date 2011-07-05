<?php

$template = "<p>%todays_date%</p>
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

<p>%patient_fullname% is a %patient_age% year old %patient_gender% with a past medical history that includes:   Medications: %medications%</p>

<p><b>HPI</b>:  Patient underwent a %2ndtype_study% on %2ndstudy_date% due to %reason_seeking_tx%.  Patient has a BMI of %bmi% and had symptoms of %symptoms%.  %He/She% was diagnosed with %2nddiagnosis%.</p>

<p><b>SUBJECTIVE</b>:  %patient_firstname% presents with subjective complaint(s) of %reason_seeking_tx%.</p>

<p><b>OBJECTIVE</b>:  %patient_firstname% underwent a %2ndtype_study% on %2ndstudy_date%.  %He/She% was diagnosed with %2nddiagnosis%.  %He/She% had an AHI of %2ndahi%.  On %his/her% back, %his/her% AHI was %2ndahisupine%; during REM sleep %his/her% AHI was [REM AHI from summary sheet].  %He/She% had a low O2 level of %2ndLowO2%;  and %he/she% spent %2ndO2Sat90%% of the night below 90% O2.</p>

<p><b>ASSESSMENT</b>:  %patient_firstname% was diagnosed with %2nddiagnosis%.  %He/She% is a good candidate for dental device therapy.</p>

<p><b>PLAN</b>:  Discussed risks, benefits,  and alternatives of treatment options. Recommend [Patient's Treatment Plan]</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />";

?>
