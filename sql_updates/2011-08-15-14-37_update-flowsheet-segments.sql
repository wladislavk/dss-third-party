/* notcandidaterow */
UPDATE flowsheet_segments
SET content = '<?php $random = rand(111111111,999999999); ?>

<table id="notcandidaterow" width="100%">
<tr class="highrow">
<td width="109">
Not a Candidate
</td>


<td width="117">
<input id="<?=$compid?>" name="data[<?php echo $step; ?>][datecomp]" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''data[<?php echo $step; ?>][datecomp]'');" onClick="<?=$caldatecomp?>.popup();"  value="example 11/11/1234" />
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
<!--
<?php if($i == 0){ ?>

<select id="stepselectedsubmit" name="stepselectedsubmit" onChange="window.onbeforeunload = null; document.page2submit.submit();">
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
-->
<input type="hidden" value="1" name="data[<?php echo $step; ?>][segmentid]" />
</td>
</tr>
</table>'
WHERE section = 'notcandidaterow';
