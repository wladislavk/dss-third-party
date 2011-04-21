INSERT INTO flowsheet_segments (id, section, content, sortby)
VALUES (1, 'initialcontactrow',

'<?php $random = rand(111111111,999999999); ?>

<table id="initialcontactrow" width="100%">
<tr class="highrow">
<td width="109">
Initital Contact
</td>


<td width="117">
<input id="initcontactdatecomp" name="initcontactdatecomp" type="text" class="field text addr tbox" value="<?php echo $datecomp; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate(''initcontactdatecomp'');"  value="example 11/11/1234" />
</td>


<td width="119">
<a href="/manage/dss_welcome.php?fid=<?php echo $_GET[''pid'']; ?>&pid=<?php echo $_GET[''pid'']; ?>&lid=<?php echo $lid; ?>">Welcome Letter</a>
</td>


<td width="115">
<input type="text" readonly="readonly" value="<?php echo $gendate; ?>" style="width:100px;">
</td>


<td width="26">
<input type="checkbox">
</td>


<td width="102">
<select <?php echo ($i > 0) ? "disabled" : ""; ?>>
<option <?php echo $emailed; ?> value="">Emailed</option>
<option <?php echo $faxed; ?> value="">Faxed</option>
<option <?php echo $mailed; ?> value="">Mailed</option>
</select>
</td>


<td width="250">

<?php if($i == 0){ ?>

<form action="<?php echo substr($_SERVER["SCRIPT_NAME"], 8, -4).".php"; ?>?pid=<?php echo $_GET[''pid'']; ?>&addtopat=1&page=page2" method="POST" name="consultform<?php echo $random; ?>" style="width: 200px;">
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />	
<select name="stepselectedsubmit" onChange="document.consultform<?php echo $random; ?>.submit();">
<option>Next Step</option>
<option value="4">Impressions</option>
<option value="5">Delaying Treatment / Waiting</option>
<option value="6">Refused Treatment</option>
<option value="3">Sleep Study</option>
<option value="8">Follow-Up / Check</option>
<option value="9">Patient Non-Compliant</option>
<option value="2">Consult</option>
<option value="10">Home Sleep Test</option>
<option value="11">Treatment Complete</option>
<option value="12">Annual Recall</option>
<option value="13">Termination</option>
</select>
<input type="hidden" value="consultrow" name="formsegment" />
<input type="hidden" name="stepident" value="<?php echo $random; ?>" />
<input type="hidden" name="patientid" value="<?php echo $_GET[''pid'']; ?>" />

</form>

<?php } ?>

</td>
</tr>
</table>',

0
)
