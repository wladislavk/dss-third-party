<?php namespace Ds3\Libraries\Legacy; ?><?php
$consultstep
$sleepstudystep
$impressionsstep
$delayingtreatmentstep
$refusedtreatmentstep
$devicedelivery
$checkfollowupstep
$noncompliantstep
$homesleepteststep
$treatmentcompletestep
$annualrecallstep
$terminationstep

$getstepqry = "SELECT * FROM `dental_flow_pg2` WHERE `patientid`='".$_GET['patientid']."'";
if(!mysqli_query($con, $getstepqry)){

$insertstepqry = "INSERT INTO `dental_flow_pg2` (`patientid`,`steparray`) VALUES ('".$_POST['patientid']."','".$_POST['steparray']."';
}else{

$updatestepqry = "UPDATE `dental_flow_pg2` SET `steparray`='".$_POST['steparray']."' WHERE `patientid`='".$_POST['patientid']."'";
}

?>

<form method="post" action="#" style="margin:0 auto;width:315px;">
<input type="button" name="stepselectedsubmit" class="addButton" value="Go to Step" />
<select name="stepselector">
	
<option value="consultstep">Consult</option>
<option value="sleepstudystep">Sleep Study</option>
<option value="impressionsstep">Impressions</option>
<option value="delayingtreatmentstep">Delaying Treatment / Waiting</option>
<option value="refusedtreatmentstep">Refused Treatment</option>
<option value="devicedelivery">Device Delivery</option>
<option value="checkfollowupstep">Follow-Up / Check-Up</option>
<option value="noncompliantstep">Patient Non-Compliant</option>
<option value="homesleepteststep">Home Sleep Test</option>
<option value="treatmentcompletestep">Treatment Complete</option>
<option value="annualrecallstep">Annual Recall</option>

</select>
</form>
