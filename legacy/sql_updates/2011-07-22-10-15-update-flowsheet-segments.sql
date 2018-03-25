/* initialcontactrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>

<table id="initialcontactrow" width="100%">
<tr class="highrow">
<td width="109">
Initital Contact
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" />
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">
<input type="checkbox">
</td>


<td width="102">
<select <?php echo ($i > 0) ? "disabled" : ""; ?> name="data[<?php echo $step; ?>][letter_method]">
<option <?php echo $emailed; ?> value="">Emailed</option>
<option <?php echo $faxed; ?> value="">Faxed</option>
<option <?php echo $mailed; ?> value="">Mailed</option>
</select>
</td>-->

<td width="250">

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="2">Consult</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="3">Sleep Study</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="consultrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="1" name="data[<?php echo $step; ?>][segmentid]" />
</td>
</tr>
</table>'
WHERE section = 'initialcontactrow';

/* consultrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>

<table id="consultrow" width="100%">
<tr class="highrow">
<td width="109">
Consult
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<br />
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">
<input type="checkbox">
</td>


<td width="102">
<select <?php echo ($i > 0) ? "disabled" : ""; ?> name="data[<?php echo $step; ?>][letter_method]">
<option>Emailed</option>
<option>Faxed</option>
<option>Mailed</option>
</select>
</td>-->


<td width="250">

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="3">Sleep Study</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="consultrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />

<?php } ?>

<input type="hidden" value="2" name="data[<?php echo $step; ?>][segmentid]" />
</td>
</tr>
</table>'
WHERE section = 'consultrow';

/* sleepstudyrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="sleepstudyrow" width="100%"> 
<tr id="sleepstudyrow">
<td width="109">
Sleep Study<br /><input id="study_type<?php echo $step; ?>" name="data[<?php echo $step; ?>][study_type]" type="text" style="width:50px;" value="<?=$sleepstudy?>" />
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<br />
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="247">

</td>


<td width="115">

</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">
<?php if($i == 0){ ?>


<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="4">Impressions</option>
<option value="6">Refused Treatment</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="8">Check / Follow Up</option>
<option value="11">Treatment Complete</option>
<option value="7">Device Delivery</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="10">Home Sleep Test</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
<option value="3">Sleep Study</option>
</select>
<input type="hidden" value="sleepstudyrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="3" name="data[<?php echo $step; ?>][segmentid]" />
</td>
</tr>
</table>'
WHERE section = 'sleepstudyrow';

/* impressionrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="impressionrow" width="100%">
<tr>
<td width="109">
Impressions
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>

<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  onClick="<?=$caldatesched?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span></td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">
<select>
<option>Emailed</option>
<option>Faxed</option>
<option>Mailed</option>
</select>
</td>-->


<td width=250>

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="7">Device Delivery</option>
<option value="4">Impressions</option>
<option value="6">Refused Treatment</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="11">Treatment Complete</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="10">Home Sleep Test</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
<option value="3">Sleep Study</option>
</select>
<input type="hidden" value="impressionrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="4" name="data[<?php echo $step; ?>][segmentid]" />

</td>
</tr>
</table>'
WHERE section = 'impressionrow';

/* delayingtreatmentrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="delayingtreatmentrow" width="100%">
<tr class="delayingtreatmentrow<?php echo $step; ?>">
<td width="109">
Delaying Treatment<br />
<select id="delay_reason<?php echo $step; ?>" name="data[<?php echo $step; ?>][delay_reason]" style="width:94px;">
<option <?php print ($delayreason == "insurance") ? "selected " : ""; ?>value="insurance">Insurance</option>
<option <?php print ($delayreason == "dental work") ? "selected " : ""; ?>value="dental work">Dental Work</option>
<option <?php print ($delayreason == "deciding") ? "selected " : ""; ?>value="deciding">Deciding</option>
<option <?php print ($delayreason == "sleep study") ? "selected " : ""; ?>value="sleep study">Sleep Study</option>
<option <?php print ($delayreason == "other") ? "selected " : ""; ?>value="other">Other</option>
</select><br />
<a id="reason_btn<?php echo $step; ?>" style="display:none;" onclick="Javascript: loadPopup(''flowsheet_other_reason.php?ed=<?=$step?>&pid=<?=$_GET[''pid'']?>&sid=5'');" href="Javascript: ;">Other Reason</a>
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<br />
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;background-color:#cccccc;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" value="example 11/11/1234" disabled /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">


<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="4">Impressions</option>
<option value="6">Refused Treatment</option>
<option value="2">Consult</option>
<option value="3">Sleep Study</option>
<option value="7">Device Delivery</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
<option value="5">Delaying Treatment / Waiting</option>
</select>
<input type="hidden" value="delayingtreatmentrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="5" name="data[<?php echo $step; ?>][segmentid]" />

</td>
</tr>
<tr>
<td id="description<?=$step?>" style="display:none;" colspan="5"><?php echo $description; ?></td>
</tr>
</table>'
WHERE section = 'delayingtreatmentrow';

/* refusedtreatmentrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="refusedtreatmentrow" width="100%">
<tr>
<td width="109">
Refused Treatment
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span><br />
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;background-color:#cccccc;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" value="example 11/11/1234" disabled /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="2">Consult</option>
<option value="3">Sleep Study</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="7">Device Delivery</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="refusedtreatmentrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="6" name="data[<?php echo $step; ?>][segmentid]" />

</td>
</tr>
</table>'
WHERE section = 'refusedtreatmentrow';

/* devicedeliveryrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="devicedeliveryrow" width="100%">
<tr>
<td width="109">
Device Delivery
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="247">

</td>


<td width="115">

</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->




<td width="250">


<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="3">Sleep Study</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
<option value="7">Device Delivery</option>
</select>
<input type="hidden" value="devicedeliveryrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="7" name="data[<?php echo $step; ?>][segmentid]" />

</td>
</tr>
</table>'
WHERE section ='devicedeliveryrow';

/* checkuprow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="checkuprow" width="100%">
<tr>
<td width="109">
Check / Follow Up
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">


<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="8">Check / Follow Up</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="3">Sleep Study</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="7">Device Delivery</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="checkuprow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="8" name="data[<?php echo $step; ?>][segmentid]" />


</td>
</tr>
</table>'
WHERE section = 'checkuprow';

/* patientnoncomprow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="patientnoncomprow" width="100%">
<tr class="patientnoncomprow<?php echo $step; ?>">
<td width="109">
Patient Non Compliant
<select id="noncomp_reason<?php echo $step; ?>" name="data[<?php echo $step; ?>][noncomp_reason]" style="width:94px;">
<option <?php print ($noncompreason == "pain/discomfort") ? "selected " : ""; ?>value="pain/discomfort">Pain/Discomfort</option>
<option <?php print ($noncompreason == "lost device") ? "selected " : ""; ?>value="lost device">Lost Device</option>
<option <?php print ($noncompreason == "device not working") ? "selected " : ""; ?>value="device not working">Device Not Working</option>
<option <?php print ($noncompreason == "other") ? "selected " : ""; ?>value="other">Other</option>
</select><br />
<a id="reason_btn<?php echo $step; ?>" style="display:none;" onclick="Javascript: loadPopup(''flowsheet_other_reason.php?ed=<?=$step?>&pid=<?=$_GET[''pid'']?>&sid=9'');" href="Javascript: ;">Other Reason</a>

</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;background-color:#cccccc;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');"  value="example 11/11/1234" disabled /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">-->

</td>


<td width="250">

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="2">Consult</option>
<option value="3">Sleep Study</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="7">Device Delivery</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non Compliant</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="patientnoncomprow" name="formsegment" />

<?php } ?>

<input type="hidden" value="9" name="data[<?php echo $step; ?>][segmentid]" />


</td>
</tr>
<tr>
<td id="description<?=$step?>" style="display:none;" colspan="5"><?php echo $description; ?></td>
</tr>
</table>'
WHERE section = 'patientnoncomprow';

/* homesleeptestrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="homesleeptestrow" width="100%">
<tr>
<td width="109">
Home Sleep Test
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="247">

</td>


<td width="115">

</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="11">Treatment Complete</option>
<option value="8">Check / Follow Up</option>
<option value="10">Home Sleep Test</option>
<option value="3">Sleep Study</option>
<option value="9">Patient Non-Compliant</option>
<option value="7">Device Delivery</option>
<option value="2">Consult</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="homesleeptestrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="10" name="data[<?php echo $step; ?>][segmentid]" />


</td>
</tr>
</table>'
WHERE section = 'homesleeptestrow';

/* starttreatmentrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="starttreatmentrow" width="100%">
<tr>
<td width="109">
Treatment Complete
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;background-color:#cccccc;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" disabled /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">

<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="12">Annual Recall</option>
<option value="3">Sleep Study</option>
<option value="2">Consult</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="7">Device Delivery</option>
<option value="8">Check / Follow Up</option>
<option value="9">Patient Non-Compliant</option>
<option value="10">Home Sleep Test</option>
<option value="13">Termination</option>
<option value="11">Treatment Complete</option>
</select>
<input type="hidden" value="starttreatmentrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="11" name="data[<?php echo $step; ?>][segmentid]" />


</td>
</tr>
</table>'
WHERE section = 'starttreatmentrow';

/* annualrecallrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<table id="annualrecallrow" width="100%">
<tr>
<td width="109">
Annual Recall
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');" onClick="<?=$caldatesched?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="247">

</td>


<td width="115">

</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">


<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="document.page2submit.submit();">
<option>Next Step</option>
<option value="12">Annual Recall</option>
<option value="8">Check / Follow Up</option>
<option value="10">Home Sleep Test</option>
<option value="3">Sleep Study</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="7">Device Delivery</option>
<option value="11">Treatment Complete</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="annualrecallrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

<?php } ?>

<input type="hidden" value="12" name="data[<?php echo $step; ?>][segmentid]" />

</td>
</tr>
</table>'
WHERE section = 'annualrecallrow';

/* terminationrow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>
<style>
	#startterminationrow td{
		border-bottom:none;
	}
</style>
<table id="startterminationrow" width="100%">
<tr>
<td width="109">
Termination
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabinde x="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
<input id="<?=$schedid?>" name="data[<?php echo $step; ?>][datesched]" type="text" class="field text addr tbox" value="<?php echo $datesched; ?>" tabindex="10" style="width:100px;background-color:#cccccc;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datesched]'');"  value="example 11/11/1234" disabled /><span id="req_0" class="req">*</span>
</td>


<td width="247">
<?php echo $letterlink; ?>
</td>


<td width="115">
<?php if ($letterlink != ""): ?>
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
<?php endif; ?>
</td>


<!--<td width="26">

</td>


<td width="102">

</td>-->


<td width="250">
<input type="hidden" value="13" name="data[<?php echo $step; ?>][segmentid]" />
</td>
</tr>
</table>'
WHERE section = 'terminationrow';

