<?php
	include "includes/top.htm";

	if(is_numeric($_GET['pid'])){
		$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
		
		$flowresult = $db->getResults($flowquery);
		if(count($flowresult) <= 0){
			$message = "There is no started flowsheet for the current patient.";
		}else{
		    $flow = $flowresult[0];
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

			if(count($flowresult) <= 0){
				$flowinsertqry = "INSERT INTO dental_flow_pg1 (`id`,`copyreqdate`,`referred_by`,`referreddate`,`thxletter`,`queststartdate`,`questcompdate`,`insinforec`,`rxreq`,`rxrec`,`lomnreq`,`lomnrec`,`clinnotereq`,`clinnoterec`,`contact_location`,`questsendmeth`,`questsender`,`refneed`,`refneeddate1`,`refneeddate2`,`preauth`,`preauth1`,`preauth2`,`insverbendate1`,`insverbendate2`,`pid`) VALUES (NULL,'".$copyreqdate."','".$referred_by."','".$referreddate."','".$thxletter."','".$queststartdate."','".$questcompdate."','".$insinforec."','".$rxreq."','".$rxrec."','".$lomnreq."','".$lomnrec."','".$clinnotereq."','".$clinnoterec."','".$contact_location."','".$questsendmeth."','".$questsender."','".$refneed."','".$refneeddate1."','".$refneeddate2."','".$preauth."','".$preauth1."','".$preauth2."','".$insverbendate1."','".$insverbendate2."','".$pid."');";
				
				$flowinsert = $db->query($flowinsertqry);      
				if(!$flowinsert){
					$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error inserting flowsheet record, please try again!1";
				}else{
					$message = "Successfully updated flowsheet!2";
				}  
	    	}else{
				$flowinsertqry = "UPDATE dental_flow_pg1 SET `copyreqdate` = '".$copyreqdate."',`referred_by` = '".$referred_by."',`referreddate` = '".$referreddate."',`thxletter` = '".$thxletter."',`queststartdate` = '".$queststartdate."',`questcompdate` = '".$questcompdate."',`insinforec` = '".$insinforec."',`rxreq` = '".$rxreq."',`rxrec` = '".$rxrec."',`lomnreq` = '".$lomnreq."',`lomnrec` = '".$lomnrec."',`clinnotereq` = '".$clinnotereq."',`clinnoterec` = '".$clinnoterec."',`contact_location` = '".$contact_location."',`questsendmeth` = '".$questsender."',`questsender` = '".$questsendmeth."',`refneed` = '".$refneed."',`refneeddate1` = '".$refneeddate1."',`refneeddate2` = '".$refneeddate2."',`preauth` = '".$preauth."',`preauth1` = '".$preauth1."',`preauth2` = '".$preauth2."',`insverbendate1` = '".$insverbendate1."',`insverbendate2` = '".$insverbendate2."' WHERE `pid` = '".$_GET['pid']."';";
				
				$flowinsert = $db->query($flowinsertqry);      
				if(!$flowinsert){
					$message = "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error updating flowsheet, please try again!3";
				}else{
					$message = "Successfully updated flowsheet!4";
				} 
	    	}
		}
	}
?>

	<link type="text/css" rel="stylesheet" href="/manage/css/manage_flowsheet4.css">

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
								<td>Date</td>
								<td>Referral Source</td>
								<td>Contact Location</td>
							</tr>
							<tr>
								<td>
									<input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onClick="cal1.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
								</td>
								<td>
									<?php
										$referredby_sql = "select * from dental_contact where referrer=1 and status=1 and docid='".$_SESSION['docid']."' order by firstname";
										
										$referredby_my = $db->getResults($referredby_sql);
									?>
									<select name="referred_by" class="field text addr tbox">
										<option value=""></option>
										<?php if ($referredby_my) foreach ($referredby_my as $referredby_myarray) {
											$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
										?>
											<option value="<?php echo st($referredby_myarray['contactid'])?>" <?php if($referred_by == st($referredby_myarray['contactid']) ) echo " selected";?>>
												<?php echo $ref_name;?>
											</option>
										<?php } ?>
									</select>                        
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
									<td>Dentist Name/Office</td>
									<td>Date</td>
									<td>Thank You Sent</td>
								</tr>
								<tr>
									<td>DSS Offices</td>
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
										<td>Date</td>
										<td>Method</td>	
										<td>Who Sent</td>
										<td>Completed/Uploaded</td>
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
							<div style="width:60%; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">SLEEP STUDY</div>
							<!--sleep study table-->

								<div style="width: 500px; margin: auto; display: table;" id="sleeplabtable">
									<div style="float: left; width: 180px;">
										<table id="sleeplablabels" style="border: 0; width: 100%;" cellpadding="0">
											<tr>
												<td>Test Number</td>
											</tr>
											<tr>
												<td>Needed</td>
											</tr>
											<tr>
												<td>Date Scheduled</td>
											</tr>
											<tr>
												<td>Where Scheduled</td>
											</tr>
											<tr>
												<td>Completed</td>											
											</tr>			
											<tr>											
												<td>Interpolation</td>									
											</tr>			
											<tr>											
												<td>Type</td>											
											</tr>			
											<tr>
												<td>Copy Requested</td>			
											</tr>			
											<tr>											
												<td>Sleep Study Request From</td>											
											</tr>			
											<tr>											
												<td>Copy Obtained/Scanned In</td>											
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

								<!-- START MED INS CORP TABLE -->
								<input type="submit" class="addButton" style="float:right;margin-right:20px;" name="flowsubmit" value="Update Flowsheet">
								<br /><br />
				</form>
				</div>
				<!-- END FLOWSHEET PAGE 1 ***************************** -->

				<!-- START FLOWSHEET PAGE 2 ***************************** -->
				<div id="flowsheet_page2" style="border-right: 1px solid rgb(0, 0, 0); margin-left: 20px; display: block; min-height: 400px; overflow: hidden; width: 932px;">
					<?php if(isset($_POST['stepselectedsubmit'])){
						}
					?>
					<table align="center" style="width:100%; overflow: hidden;" id="flowsheetpage2">
						<tr>
							<td width="109">Procedure</td>
							<td width="117">Date Sched/Comp</td>
							<td width="119">Correspondence</td>
							<td width="115">Generated On</td>
							<td width="26" style="text-align:center;">&#8730;&nbsp;</td>
							<td width="102">Sent via</td>                
							<td width="250">Next Appointment</td>
						</tr>

						<?php
							if(isset($_POST['stepselectedsubmit']) || isset($_POST['stepselectedsubmit2'])){
								function updateflowsheet2($patientid, $value){
									$db = new Db();

									$getstepqrysql = "SELECT * FROM `dental_flow_pg2` WHERE `patientid`='".$patientid."' LIMIT 1;";
									
									$getstepqry = $db->getResults($getstepqrysql);
							    	$posqry = "SELECT * FROM `segments_order` WHERE `patientid`='".$patientid."' LIMIT 1;";
									if(count($getstepqry) < 1){
										$insertstepqry = "INSERT INTO `dental_flow_pg2` (`patientid` , `steparray`) VALUES ('".$patientid."','".$value."')";
										
										if(!$db->query($insertstepqry)){
											$error = "MySQL error ".mysql_errno().": ".mysql_error();
											echo $error."1";
											echo "error inserting";
										}

										$insertorderqry = "INSERT INTO `segments_order` (`patientid` , `consultrow` , `sleepstudyrow` , `delayingtreatmentrow` , `refusedtreatmentrow` , `devicedeliveryrow` , `impressionrow` , `checkuprow` , `patientnoncomprow` , `homesleeptestrow` , `starttreatmentrow` , `annualrecallrow`) VALUES ('".$patientid."','1','2','3','4','5','6','7','8','9','10','11')";
										
										if(!$db->query($insertorderqry)){
											echo "error updating order";
											$error = "MySQL error ".mysql_errno().": ".mysql_error();
											echo $error."2";
										}
									}else{
										$steparray = $getstepqry[0];
										$whatsinarray = $steparray['steparray'];
										$amtinarray = count($whatsinarray);
      
         								if(in_array($_POST['stepselectedsubmit'], $whatsinarray)){
          									echo "Item in db";
         								}else{
          									$updatestepqry = "UPDATE `dental_flow_pg2` SET `steparray`='".$steparray['steparray'].",".$value."' WHERE `patientid`='".$patientid."'";
					
    										if(!$db->query($updatestepqry)){
    											echo "error updating record";
    											$error = "MySQL error ".mysql_errno().": ".mysql_error();
												echo $error."3";
    										}

											$getcurrpos1 = "UPDATE `segments_order` SET `".$_POST['formsegment']."` = '1' WHERE `patientid` ='".$patientid."'";
											
											$currpos1 = $db->query($getcurrpos1);
											if(!$currpos1){
												echo "error updating order";
												$error = "MySQL error ".mysql_errno().": ".mysql_error();
												echo $error."4";
											}

          									$pos = $db->getRow($posqry);
											foreach($pos as $key => $value){
												if($key != $_POST['formsegment'] && $value < $_POST['formsegment']){
													$updatecurrpos = "UPDATE `segments_order` SET `".$key."` = ".$key."+1 WHERE `".$key."` != 'patientid'";
													$currpos = $db->query($updatecurrpos);
													if(!$currpos){
														echo "error updating order";
														$error = "MySQL error ".mysql_errno().": ".mysql_error();
														echo $error."5";
													}
												}
											}
          			
											$updatesegments = "UPDATE `dental_flow_pg2` SET `".$_POST['formsegment']."` = 1";
											
											if(!$db->query($updatesegments)){
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
									window.location.href = 'manage_flowsheet3.php?page=2&pid='+<?php echo($_GET['pid']); ?>+'&addtopat=1';		
								</script>	
						<?php
							}
						?>

						<!-- START INITIAL CONTACT ROW  -->
						<table id="initialcontactrow" width="100%">
							<tr class="highrow">
								<td width="109">Initial Contact</td>
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

									switch($order) {
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
							$s = $db->getResults($q);
							$i = 2;
							foreach ($s as $section){
								$title = $section['section'];
								$q2 = "SELECT `consultrow`, `sleepstudyrow`, `delayingtreatmentrow`, `refusedtreatmentrow`, `devicedeliveryrow`, `checkuprow`, `patientnoncomprow`, `homesleeptestrow`, `starttreatmentrow`, `annualrecallrow`, `impressionrow` FROM `segments_order` WHERE `patientid` = '".$_GET['pid']."';";
								$a2 = $db->getRow($q2);
    							$z = 2;
							    foreach($a2 as $key => $value){
							    	echo $key ." -".  $value."<br />";
							    }

								foreach($a2 as $order){
									if($order/*["$title"]*/ == $z){
										eval('?>' . $section['content'] . '<?');
									}
									$z++;
								}    
  								$i++;
							}
						?>

						<!-- START TERMINATION ROW  -->
						<table id="startterminationrow" width="100%">
							<tr>
								<td width="109">Termination</td>
								<td width="117">
									<input id="termisched" name="termisched" type="text" class="field text addr tbox" value="<?php echo $termisched; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('termisched');"  value="example 11/11/1234" readonly="readonly" /><span id="req_0" class="req">*</span>
									<input id="termicomp" name="termicomp" type="text" class="field text addr tbox" value="<?php echo $termicomp; ?>" tabinde x="10" style="width:100px;" maxlength="255" onChange="validateDate('termicomp');"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
								</td>
								<td width="119"></td>
								<td width="115"></td>
								<td width="26"></td>
								<td width="102"></td>
								<td width="250"></td>
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
					var calendar25 = new calendar2(document.getElementById('questcompdate'));
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

<?php include "includes/bottom.htm";?>