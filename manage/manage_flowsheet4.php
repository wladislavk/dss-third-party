<?php include "includes/top.htm";

if(is_numeric($_GET['pid'])){
$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
if(mysql_num_rows($flowresult) <= 0){
$message = "There is no started flowsheet for the current patient.";
}else{
    $flow = mysql_fetch_array($flowresult);
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $clinnotereq = $flow['clinnotereq'];
    $clinnoterec = $flow['clinnoterec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
}



if(isset($_POST['flowsubmit'])){
    $copyreqdate = s_for($_POST['copyreqdate']);
    $referred_by = s_for($_POST['referred_by']);
    $referreddate = s_for($_POST['referreddate']);
    $thxletter = s_for($_POST['thxletter']);
    $queststartdate = s_for($_POST['queststartdate']);
    $questcompdate = s_for($_POST['questcompdate']);
    $insinforec = s_for($_POST['insinforec']);
    $rxreq = s_for($_POST['rxreq']);
    $rxrec = s_for($_POST['rxrec']);
    $lomnreq = s_for($_POST['lomnreq']);
    $lomnrec = s_for($_POST['lomnrec']);
    $clinnotereq = s_for($_POST['clinnotereq']);
    $clinnoterec = s_for($_POST['clinnoterec']);
    $contact_location = s_for($_POST['contact_location']);
    $questsendmeth = s_for($_POST['questsendmeth']);
    $questsender = s_for($_POST['questsender']);
    $refneed = s_for($_POST['refneed']);
    $refneeddate1 = s_for($_POST['refneeddate1']);
    $refneeddate2 = s_for($_POST['refneeddate2']);
    $preauth = s_for($_POST['preauth']);
    $preauth1 = s_for($_POST['preauth1']);
    $preauth2 = s_for($_POST['preauth2']);
    $insverbendate1 = s_for($_POST['insverbendate1']);
    $insverbendate2 = s_for($_POST['insverbendate2']);
    $pid = $_GET['pid'];
    if(mysql_num_rows($flowresult) <= 0){
      $flowinsertqry = "INSERT INTO dental_flow_pg1 (`id`,`copyreqdate`,`referred_by`,`referreddate`,`thxletter`,`queststartdate`,`questcompdate`,`insinforec`,`rxreq`,`rxrec`,`lomnreq`,`lomnrec`,`clinnotereq`,`clinnoterec`,`contact_location`,`questsendmeth`,`questsender`,`refneed`,`refneeddate1`,`refneeddate2`,`preauth`,`preauth1`,`preauth2`,`insverbendate1`,`insverbendate2`,`pid`) VALUES (NULL,'".$copyreqdate."','".$referred_by."','".$referreddate."','".$thxletter."','".$queststartdate."','".$questcompdate."','".$insinforec."','".$rxreq."','".$rxrec."','".$lomnreq."','".$lomnrec."','".$clinnotereq."','".$clinnoterec."','".$contact_location."','".$questsendmeth."','".$questsender."','".$refneed."','".$refneeddate1."','".$refneeddate2."','".$preauth."','".$preauth1."','".$preauth2."','".$insverbendate1."','".$insverbendate2."','".$pid."');";
      $flowinsert = mysql_query($flowinsertqry);      
      if(!$flowinsert){
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting flowsheet record, please try again!1";
      }else{
        $message = "Successfully updated flowsheet!2";
      }  
    }else{
      $flowinsertqry = "UPDATE dental_flow_pg1 SET `copyreqdate` = '".$copyreqdate."',`referred_by` = '".$referred_by."',`referreddate` = '".$referreddate."',`thxletter` = '".$thxletter."',`queststartdate` = '".$queststartdate."',`questcompdate` = '".$questcompdate."',`insinforec` = '".$insinforec."',`rxreq` = '".$rxreq."',`rxrec` = '".$rxrec."',`lomnreq` = '".$lomnreq."',`lomnrec` = '".$lomnrec."',`clinnotereq` = '".$clinnotereq."',`clinnoterec` = '".$clinnoterec."',`contact_location` = '".$contact_location."',`questsendmeth` = '".$questsender."',`questsender` = '".$questsendmeth."',`refneed` = '".$refneed."',`refneeddate1` = '".$refneeddate1."',`refneeddate2` = '".$refneeddate2."',`preauth` = '".$preauth."',`preauth1` = '".$preauth1."',`preauth2` = '".$preauth2."',`insverbendate1` = '".$insverbendate1."',`insverbendate2` = '".$insverbendate2."' WHERE `pid` = '".$_GET['pid']."';";
      $flowinsert = mysql_query($flowinsertqry);      
      if(!$flowinsert){
        $message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error updating flowsheet, please try again!3";
      }else{
        $message = "Successfully updated flowsheet!4";
      } 
    }
}
}
?>


<style>
table{
/* margin-bottom:20px; */
border:1px solid #000;
}
td{
vertical-align:top;
}

.highrow{
height:35px;
}
</style>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form action="#" method="post">
<div style="margin:0 auto; width:500px; margin-bottom:10px;margin-top:10px;font-weight:bold;font-size:15px;color:#00457c;"><?php echo $message; ?></div>
<div style="width:200px; float:right;">
<input type="button" class="addButton" onclick="document.getElementById('flowsheet_page1').style.display='block';document.getElementById('flowsheet_page2').style.display='none';" value="Page 1" />
<input type="button" class="addButton" onclick="document.getElementById('flowsheet_page2').style.display='block';document.getElementById('flowsheet_page1').style.display='none';" value="Page 2" />
</div>
<div style="clear:both;height:10px;width:100%;"></div>


<!-- START FLOWSHEET PAGE 1 ***************************** -->
<div id="flowsheet_page1">
<form>
<!-- START INITIAL CONTACT TABLE -->
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">INITIAL CONTACT</div>
<table width="60%" align="center">

<tr>

<td>

Date

</td>

<td>

Referral Source

</td>

<td>

Contact Location

</td>

</tr>



<tr>

<td>

<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onClick="cal1.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>

</td>

<td>

<?php

								$referredby_sql = "select * from dental_referredby where status=1 and docid='".$_SESSION['docid']."' order by firstname";

								$referredby_my = mysql_query($referredby_sql);

								?>

								<select name="referred_by" class="field text addr tbox">

									<option value=""></option>

									<?php while($referredby_myarray = mysql_fetch_array($referredby_my)) 

									{

										$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);

									?>

										<option value="<?=st($referredby_myarray['referredbyid'])?>" <? if($referred_by == st($referredby_myarray['referredbyid']) ) echo " selected";?>>

											<?php echo $ref_name;?>

										</option>

									<? }?>

								</select>

							

                               <!-- <input id="referred_by" name="referred_by" type="text" class="field text addr tbox" value="<?=$referred_by?>" maxlength="255" style="width:300px;" /> -->

                <br /><button class="addButton" onclick="Javascript: loadPopup('add_referredby.php?addtopat=<?php echo $_GET['pid']; ?>');">Add New Referrer</button>

</td>

<td>

<select name="contact_location">

<option value="DSS Franchisee"<?php if($contact_location == "DSS Franchisee"){echo " selected='selected'";} ?>>DSS Franchisee</option>

<option value="Corporate Office"<?php if($contact_location == "Corporate Office"){echo " selected='selected'";} ?>>Corporate Office</option>

</select>

</td>

</tr>

</table>

<!-- END INITIAL CONTACT TABLE -->





<!-- START REFERRED TO DSS OFFICE TABLE -->
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">REFERRED TO DSS OFFICE</div>
<table width="50%" align="center">

<tr>

<td>

Dentist Name/Office

</td>

<td>

Date

</td>

<td>

Thank You Sent

</td>

</tr>



<tr>
<td>

 DSS Offices

</td>
<td>
<input id="referreddate" name="referreddate" type="text" class="field text addr tbox" value="<?php echo $referreddate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('referreddate');" onClick="cal2.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>



</td>
<td>
<input id="thxletter" name="thxletter" type="text" class="field text addr tbox" value="<?php echo $thxletter; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('thxletter');" onClick="cal3.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>



</td>
</tr>

</table>

<!-- END REFERRED TO DSS OFFICE TABLE -->







<!-- START SEND PATIENT QUESTIONNAIRE TABLE -->
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">SEND PATIENT QUESTIONNAIRE</div>
<table width="50%" align="center">

<tr>
<td>
Date


</td>
<td>
Method

</td>
<td>
Who Sent


</td>
<td>
Completed/Uploaded


</td>
</tr>



<tr>
<td>
<input id="queststartdate" name="queststartdate" type="text" class="field text addr tbox" value="<?php echo $queststartdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('queststartdate');" onClick="cal4.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>



</td>
<td>
<select name="questsendmeth">
<option value="Online">Online</option>
<option value="Email">Email</option>
<option value="Fax">Fax</option>
<option value="At Office">At Office</option>
</select>


</td>
<td>
<select name="questsender">
<option value="DSS Franchisee">DSS Franchisee</option>
<option value="Corporate Office">Corporate Office</option>
</select>


</td>
<td>
<input id="questcompdate" name="questcompdate" type="text" class="field text addr tbox" value="<?php echo $questcompdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('questcompdate');" onClick="cal5.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>


</td>
</tr>

</table>

<!-- END SEND PATIENT QUESTIONNAIRE TABLE -->




<!-- START SLEEP LABS TABLE -->
<style>
	#sleepstudyscrolltable tr td	{ border-bottom: 1px solid #000; height: 35px; }
	#sleeplablabels					{ /* line-height:22.6px; */ }
	#sleeplablabels 	   tr td 	{ height: 35px; padding: 0; border-bottom: 1px solid #000; font-weight: bold; text-align: right; padding-right: 10px; }
</style>

<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">SLEEP STUDY</div>

<!--sleep study table-->

<div style="width: 500px; margin: auto; display: table;" id="sleeplabtable">
	
	<div style="float: left; width: 180px;">
		<table id="sleeplablabels" style="border: 0; width: 100%;" cellpadding="0">
			<tr>
			
			<td>
			
			Test Number
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Needed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Date Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Where Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Completed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Interpolation
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Type
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Requested
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Sleep Study Request From
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Obtained/Scanned In
			
			</td>
			
			</tr>
		
		</table>
	</div>
	
	<div style=" border: medium none;float: left;height: 440px;margin-bottom: 20px;margin-top: -4px;overflow: auto;width: 300px;">
		 <table width="700" style="overflow-x: auto;">
		   <tr>
		    <td>
<!-- Begin repeat sleep study section -->
      






	<iframe src="manage_sleep_studies.php?pid=<?php echo $_GET['pid']; ?>" height="410" width="100%" style="border: medium none; overflow:hidden;">Iframes must be enabled to view this area.</iframe>









      
 
 
 
<!-- End repeat sleep study section -->
         </td>
      </tr>
		 </table>
	</div>
	
</div>


<!--
<table width="500px;" align="center" id="sleeplabtable">
<tr>
	<td style="width:200px;">
		<table width="200px" align="center" id="sleeplablabels" style="border:none; float:left;">
			<tr>
			
			<td>
			
			Test Number
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Needed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Date Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Where Scheduled
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Completed
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Interpolation
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Type
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Requested
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Sleep Study Request From
			
			</td>
			
			</tr>
			
			<tr>
			
			<td>
			
			Copy Obtained/Scanned In
			
			</td>
			
			</tr>
		
		</table>
	</td>

	<td width="300">
		<div style="width: 300px; height: 295px; overflow-x: scroll; overflow-y: hidden;">
			<div style="width: 500px; height: 295px; overflow-x: scroll; overflow-y: hidden;"> 
				<table align="center" style="border:none; float: left;width: 140px;" id="sleepstudyscrolltable">
	
					<tr>
					
					<td>
					
					<input type="text" style="width:25px;" readonly="readonly">
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input type="radio" name="needed" value="Yes">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<input type="radio" name="needed" value="No">No
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<select>
					
					<option>Sleep Lab 1</option>
					
					<option>Sleep Lab 2</option>
					
					<option>Sleep Lab 3</option>
					
					</select>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input type="radio" name="completed" value="Yes">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<input type="radio" name="completed" value="No">No
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input type="radio" name="interpretation" value="Yes">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<input type="radio" name="interpretation" value="No">No
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<select>
					
					<option>PSG</option>
					
					<option>HST</option>
					
					</select>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<select>
					
					<option>Sleep Lab 1</option>
					
					<option>Sleep Lab 2</option>
					
					<option>Sleep Lab 3</option>
					
					</select>
					
					</td>
					
					</tr>
					
					<tr>
					
					<td>
					
					<button class="addButton" onclick="">
							Upload
					</button>
					&nbsp;&nbsp;&nbsp;<a href="#"> View</a>
					
					</td>
					
					</tr>
					
				</table>

			</div>
		</div> 
	</td>

</tr>

</table>
-->

<!-- END SLEEP LABS TABLE -->




<!-- START MED INS TABLE -->
<!--
<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">MEDICAL INSURANCE</div>
<table width="50%" align="center">

<tr>

<td>
Procedure
</td>
<td>
Requested
</td>
<td>
Received
</td>

</tr>

<tr>

<td>
Insurance Information
</td>
<td>
N/A
</td>
<td>
<input id="insinforec" name="insinforec" type="text" class="field text addr tbox" value="<?php echo $insinforec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('insinforec');" onClick="cal6.popup();"value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>

</tr>

<tr>

<td>
Rx.
</td>
<td>
<input id="rxreq" name="rxreq" type="text" class="field text addr tbox" value="<?php echo $rxreq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxreq');" onClick="cal7.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="rxrec" name="rxrec" type="text" class="field text addr tbox" value="<?php echo $rxrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxrec');" onClick="cal8.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>

</tr>

<tr>

<td>
L.O.M.N.
</td>
<td>
<input id="lomnreq" name="lomnreq" type="text" class="field text addr tbox" value="<?php echo $lomnreq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnreq');" onClick="cal9.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="lomnrec" name="lomnrec" type="text" class="field text addr tbox" value="<?php echo $lomnrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnrec');" onClick="cal10.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>

</tr>

<tr>

<td>
Clinical notes
</td>
<td>
<input id="clinnotereq" name="clinnotereq" type="text" class="field text addr tbox" value="<?php echo $clinnotereq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('clinnotereq');" onClick="cal11.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="clinnoterec" name="clinnoterec" type="text" class="field text addr tbox" value="<?php echo $clinnoterec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('clinnoterec');" onClick="cal12.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>

</tr>

</table>
-->
<!-- END MED INS TABLE -->




<!-- 
START MED INS CORP TABLE 

<table width="50%" align="center">
<tr>
<td>
Referral Needed
</td>
<td>
<select name="refneed">
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
<td>
<input id="refneeddate1" name="refneeddate" type="text" class="field text addr tbox" value="<?php echo $refneeddate1; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('refneeddate1');" onClick="cal13.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="refneeddate2" name="refneeddate2" type="text" class="field text addr tbox" value="<?php echo $refneeddate2; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('refneeddate2');" onClick="cal14.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
</tr>



<tr>
<td>
Preauthorization
</td>
<td>
<select>
<option>Yes</option>
<option>No</option>
</select>
</td>
<td>
<input id="preautho1" name="preautho1" type="text" class="field text addr tbox" value="<?php echo $preautho1; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('preautho1');" onClick="cal15.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
<td>
<input id="preautho2" name="preautho2" type="text" class="field text addr tbox" value="<?php echo $preautho2; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('preautho2');" onClick="cal16.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
</tr>



<tr>
<td>
Ins. Ver. of Benefits
</td>
<td>
N/A
</td>
<td>
N/A
</td>
<td>
<input id="insverbendate" name="insverbendate" type="text" class="field text addr tbox" value="<?php echo $insverbendate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('insverbendate');" onClick="cal17.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>
</tr>


</table>

-->

<!-- START MED INS CORP TABLE -->
<input type="submit" class="addButton" style="float:right;margin-right:20px;" name="flowsubmit" value="Update Flowsheet">
<br /><br />

</form>
</div>
<!-- END FLOWSHEET PAGE 1 ***************************** -->




<!-- START FLOWSHEET PAGE 2 ***************************** -->
<div id="flowsheet_page2" style="border-right: 1px solid rgb(0, 0, 0); margin-left: 20px; display: block; min-height: 400px; overflow: hidden; width: 932px;">
<style>
#flowsheet_page2 td{
border-bottom:1px solid #000;
}
</style>






<?php
if(isset($_POST['stepselectedsubmit'])){
	
	

}
?>




<style>
	
	#flowsheetpage2{
		overflow:hidden;
	}
	#flowsheetpage2 td{
		overflow:hidden;
	}
	
</style>

<table align="center" style="width:100%; overflow: hidden;" id="flowsheetpage2">
<tr>
<td width="109">
Procedure
</td>


<td width="117">
Date Sched/Comp
</td>


<td width="119">
Correspondence
</td>


<td width="115">
Generated On
</td>


<td width="26" style="text-align:center;">
&#8730;&nbsp;
</td>


<td width="102">
Sent via
</td>
                                              

<td width="250">
Next Appointment
</td>
</tr>


<?php
if(isset($_POST['stepselectedsubmit']) || isset($_POST['stepselectedsubmit2'])){
	function updateflowsheet2($patientid, $value){
		$getstepqrysql = "SELECT * FROM `dental_flow_pg2` WHERE `patientid`='".$patientid."' LIMIT 1;";
		$getstepqry = mysql_query($getstepqrysql);
    $posqry = "SELECT * FROM `segments_order` WHERE `patientid`='".$patientid."' LIMIT 1;";
		$getposqry = mysql_query($posqry);   
		
		if(mysql_num_rows($getstepqry) < 1){
			$insertstepqry = "INSERT INTO `dentalsl_main`.`dental_flow_pg2` (`patientid` , `steparray`) VALUES ('".$patientid."','".$value."')";
			if(!mysql_query($insertstepqry)){
			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."1";
			echo "error inserting";
			}
			$insertorderqry = "INSERT INTO `dentalsl_main`.`segments_order` (`patientid` , `consultrow` , `sleepstudyrow` , `delayingtreatmentrow` , `refusedtreatmentrow` , `devicedeliveryrow` , `impressionrow` , `checkuprow` , `patientnoncomprow` , `homesleeptestrow` , `starttreatmentrow` , `annualrecallrow`) VALUES ('".$patientid."','1','2','3','4','5','6','7','8','9','10','11')";
			if(!mysql_query($insertorderqry)){
			echo "error updating order";
			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."2";
			}
		}else{
			$steparray = mysql_fetch_array($getstepqry);
			$whatsinarray = $steparray['steparray'];
			$amtinarray = count($whatsinarray);
      
      
         if(in_array($_POST['stepselectedsubmit'], $whatsinarray)){
          echo "Item in db";
         }else{
          $updatestepqry = "UPDATE `dentalsl_main`.`dental_flow_pg2` SET `steparray`='".$steparray['steparray'].",".$value."' WHERE `patientid`='".$patientid."'";
			    mysql_query($updatestepqry);
			
    			if(!mysql_query($updatestepqry)){
    			echo "error updating record";
    			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."3";
    			}
          $getcurrpos1 = "UPDATE `segments_order` SET `".$_POST['formsegment']."` = '1' WHERE `patientid` ='".$patientid."'";
          $currpos1 = mysql_query($getcurrpos1);
          if(!$currpos1){
            echo "error updating order";
            $error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."4";
          }
          $pos = mysql_fetch_array($getposqry);
          foreach($pos as $key => $value){
            if($key != $_POST['formsegment'] && $value < $_POST['formsegment']){
              $updatecurrpos = "UPDATE `segments_order` SET `".$key."` = ".$key."+1 WHERE `".$key."` != 'patientid'";
              $currpos = mysql_query($updatecurrpos);
              if(!mysql_query($currpos)){
              echo "error updating order";
              $error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."5";
              }
            }
          }
          			
    			$updatesegments = "UPDATE `dentalsl_main`.`dental_flow_pg2` SET `".$_POST['formsegment']."` = 1";
    			if(!mysql_query($updatesegments)){
    			echo "error updating order";
    			$error = "MySQL error ".mysql_errno().": ".mysql_error();
			echo $error."6";
    			}
         }       

      
			
		}
	}
	updateflowsheet2($_POST['patientid'], $_POST['stepselectedsubmit']);
	?>
	<script type="text/javascript">
		window.location.href='manage_flowsheet3.php?page=2&pid='+<?php echo($_GET['pid']); ?>+'&addtopat=1';		
	</script>	
	<?php
}

?>


<!-- START INITIAL CONTACT ROW  -->
<table id="initialcontactrow" width="100%">
<tr class="highrow">
<td width="109">
Initial Contact
</td>


<td width="117">
<input type="text" readonly="readonly" value="Complete Pg. 1" style="width:100px;">
</td>


<td width="119">
<a href="#">Welcome Letter</a>
</td>


<td width="115">
<input type="text" readonly="readonly" value="Gen Date" style="width:100px;">
</td>


<td width="26">
<input type="checkbox">
</td>


<td width="102">
<select>
<option>Emailed</option>
<option>Faxed</option>
<option>Mailed</option>
</select>
</td>









<td width="250">
<form action="#" method="POST" style="width: 200px;">
<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>" />
<input type="hidden" name="stepselectedsubmit" value="2" />	
<button class="addButton" name="stepselectedsubmit2">Start Consult</button>
</form>
</td>
</tr>
</table>
<!-- END INITIAL CONTACT ROW  -->
  



<?php
    function array_sort($array, $on, $order)
    {
      $new_array = array();
      $sortable_array = array();
 
      if (count($array) > 0) {
          foreach ($array as $k => $v) {
              if (is_array($v)) {
                  foreach ($v as $k2 => $v2) {
                      if ($k2 == $on) {
                          $sortable_array[$k] = $v2;
                      }
                  }
              } else {
                  $sortable_array[$k] = $v;
              }
          }
 
          switch($order)
          {
              case 'SORT_ASC':   
                  echo "ASC";
                  asort($sortable_array);
              break;
              case 'SORT_DESC':
                  echo "DESC";               
                  arsort($sortable_array);
              break;
          }
 
          foreach($sortable_array as $k => $v) {
              $new_array[] = $array[$k];
          }
      }
      return $new_array;
    }   
  
  
  $q = "SELECT * FROM flowsheet_segments";
  $s = mysql_query($q);
  
  
  $i = 2;
  while($section = mysql_fetch_array($s)){
  $title = $section['section'];

  $q2 = "SELECT `consultrow`, `sleepstudyrow`, `delayingtreatmentrow`, `refusedtreatmentrow`, `devicedeliveryrow`, `checkuprow`, `patientnoncomprow`, `homesleeptestrow`, `starttreatmentrow`, `annualrecallrow`, `impressionrow` FROM `segments_order` WHERE `patientid` = '".$_GET['pid']."';";
  $s2 = mysql_query($q2);
  $a2 = mysql_fetch_array($s2);
    $z = 2;



    foreach($a2 as $key => $value){
    echo $key ." -".  $value."<br />";
    } 
    
    foreach($a2 as $order){
      if($order["$title"] == $z){
      eval('?>' . $section['content'] . '<?');
      }
      $z++;
    }    
  $i++;
  }


    


?> 



<!-- START TERMINATION ROW  -->
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
<input id="termisched" name="termisched" type="text" class="field text addr tbox" value="<?php echo $termisched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('termisched');"  value="example 11/11/1234" readonly="readonly" /><span id="req_0" class="req">*</span>
<input id="termicomp" name="termicomp" type="text" class="field text addr tbox" value="<?php echo $termicomp; ?>" tabinde x="10" style="width:100px;" maxlength="255" onChange="validateDate('termicomp');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
</td>


<td width="119">

</td>


<td width="115">

</td>


<td width="26">

</td>


<td width="102">

</td>


<td width="250">

</td>
</tr>
</table>
<!-- END TERMINATION ROW  -->

</table>


</div>
<!-- END FLOWSHEET PAGE 2 ***************************** -->



<script type="text/javascript">
var cal1 = new calendar2(document.getElementById('copyreqdate'));
var cal2 = new calendar2(document.getElementById('referreddate'));
var cal3 = new calendar2(document.getElementById('thxletter'));
var cal4 = new calendar2(document.getElementById('queststartdate'));
var cal5 = new calendar2(document.getElementById('questcompdate'));
// var cal6 = new calendar2(document.getElementById('insinforec'));
// var cal7 = new calendar2(document.getElementById('rxreq'));
// var cal8 = new calendar2(document.getElementById('rxrec'));
// var cal9 = new calendar2(document.getElementById('lomnreq'));
// var cal10 = new calendar2(document.getElementById('lomnrec'));
// var cal11 = new calendar2(document.getElementById('clinnotereq'));
// var cal12 = new calendar2(document.getElementById('clinnoterec'));
// var cal13 = new calendar2(document.getElementById('refneeddate1'));
// var cal14 = new calendar2(document.getElementById('refneeddate2'));
// var cal15 = new calendar2(document.getElementById('preautho1'));
// var cal16 = new calendar2(document.getElementById('preautho2'));
// var cal17 = new calendar2(document.getElementById('insverbendate'));
</script>


<? include "includes/bottom.htm";?>