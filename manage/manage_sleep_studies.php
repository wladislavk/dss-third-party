<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include_once('includes/constants.inc');
	include_once('includes/general_functions.php');
	include("includes/sescheck.php");
?>

	<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
	
<?php
	include("includes/calendarinc.php");
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script type="text/javascript" src="admin/popup/popup.js"></script>
		<script src="/manage/js/add_new_sleeplab.js" type="text/javascript"></script>
		<script language="JavaScript" src="calendar1.js"></script>
		<script language="JavaScript" src="calendar2.js"></script>
		<script type="text/javascript" src="/manage/js/manage_sleep_studies.js"></script>
	</head>

	<body style="background:none;"> 
		<?php if($_SESSION['userid'] == '') { ?>
			<script type="text/javascript">
				alert("Members Area, Please Login");
				window.location = "login.php";
			</script>
		<?php 
			die();
		}

		// Create Filename
		if(isset($_POST['deletestudy'])&&isset($_POST['sleepstudyid'])){
			$s = "DELETE FROM dental_sleepstudy where id=".mysqli_real_escape_string($con,$_POST['sleepstudyid'])." AND patientid=".mysqli_real_escape_string($con,$_POST['patientid']); 
			
			$db->query($s);
		}
		if(isset($_POST['updatestudy']) || isset($_POST['submitnewstudy'])) {
  			$sql = "SELECT firstname, lastname FROM dental_patients WHERE patientid = '".$_POST['patientid']."';";
			$result = $db->getResults($sql);
			if ($result) foreach ($result as $row) {
				$patient = $row;
			}
			$date = date("Y-m-d-H-i-s");
			$filename = "Sleepstudy_Scan_".$patient['lastname']."_".$patient['firstname']."_$date";
		}
		if(isset($_POST['updatestudy']) && isset($_POST['sleepstudyid'])){
			$i = $_POST['formid'];
			$sleepstudyid = $_POST['sleepstudyid'];
			$docid = $_SESSION['docid'];
			$patientid = $_POST['patientid'];
			$needed = $_POST['data'][$i]['needed'];
			$scheddate = $_POST['data'][$i]['scheddate'];
			$sleeplabwheresched = $_POST['data'][$i]['sleeplabwheresched'];
			$completed = $_POST['data'][$i]['completed'];
			$interpolation = $_POST['data'][$i]['interpolation'];
			$labtype = $_POST['data'][$i]['labtype'];
			$copyreqdate = $_POST['data'][$i]['copyreqdate'];
			$sleeplab = $_POST['data'][$i]['sleeplab'];
			$origfilename = $_FILES["file"]["name"];
			$date = date("Ymd");
			$updslquery = "UPDATE `dental_sleepstudy` SET `docid` = '".$docid."', `patientid` = '".$_POST['patientid']."', `needed` = '".$needed."',`scheddate` = '".$scheddate."',`sleeplabwheresched` = '".$sleeplabwheresched."',`completed` = '".$completed."',`interpolation` = '".$interpolation."',`labtype` = '".$labtype."',`copyreqdate` = '".$copyreqdate."',`sleeplab` = '".$sleeplab."',`date` = '".$date."' $filequery WHERE `id` = '".$_POST['sleepstudyid']."' and `patientid` = '".$patientid."';";
			
			if (!$db->query($updslquery)){
				echo "Could not update sleep study, please try again!";
			} else {
				$updated = true;
			}
		}

		if(isset($_POST['submitnewstudy'])){
			$docid = $_SESSION['docid'];
			$patientid = $_POST['patientid'];
			$needed = $_POST['needed'];
			$scheddate = $_POST['scheddate'];
			$sleeplabwheresched = $_POST['sleeplabwheresched'];
			$completed = $_POST['completed'];
			$interpolation = $_POST['interpolation'];
			$labtype = $_POST['labtype'];
			$copyreqdate = $_POST['copyreqdate'];
			$sleeplab = $_POST['sleeplab'];
			$date = date("Ymd");
			$origfilename = $_FILES["file"]["name"];
			$random = rand(111111111,999999999);
			//$scanext = end(explode('.', $origfilename));
			$insslquery = "INSERT INTO `dental_sleepstudy` (`id`,`testnumber`,`docid`,`patientid`,`needed`,`scheddate`,`sleeplabwheresched`,`completed`,`interpolation`,`labtype`,`copyreqdate`,`sleeplab`,`date`) VALUES (NULL,'".$random."','".$docid."','".$_POST['patientid']."','".$needed."','".$scheddate."','".$sleeplabwheresched."','".$completed."','".$interpolation."','".$labtype."','".$copyreqdate."','".$sleeplab."','".$date."');";
			//echo $insslquery;

			$sleepstudyid = $db->getInsertId($insslquery);

			if (!$sleepstudyid){
				echo "Could not add sleep lab, please try again!";
			} else {
				$inserted = true;
			}
		}

		if (isset($origfilename) && $origfilename != '') {
			if ($inserted || $updated) {
				if ((array_search($_FILES["file"]["type"], $dss_file_types) !== false) && ($_FILES["file"]["size"] < DSS_FILE_MAX_SIZE)) {
					if ($_FILES["file"]["error"] > 0) {
		?>
						<script type="text/javascript">
							alert("<?php echo($_FILES['file']['error']); ?>");
						</script>
		<?php
					} else {
						if (file_exists("upload/" . $_FILES["file"]["name"])) {
		?>
							<script type="text/javascript">
						 		alert("File Already Exists");
							</script>           
		<?php
						} else {
							//$filename = $patientid.'-'.$random.".".$scanext;
							$scanext = end(explode('.', $origfilename));
							$fullfilename = $filename . "." . $scanext;
							$success = uploadImage($_FILES["file"],"../../../shared/q_file/".$fullfilename);
							//$success = move_uploaded_file($_FILES["file"]["tmp_name"],"sleepstudies/$fullfilename");
							if ($success) {
					  			// Delete previous file if updating, then add reference to filename in database
								if ($updated) {
									$prevfile_qry = "SELECT filename, scanext FROM dental_sleepstudy WHERE `id` = '".$_POST['sleepstudyid']."' and `patientid` = '".$patientid."';";
									$prevfile_result = $db->getRow($prevfile_qry);
									$prev_filename = $prevfile_result['filename'];
									$prev_scanext = $prevfile_result['scanext'];
									unlink("../../../shared/q_file/" . $prev_filename . "." . $prev_scanext);
								}
								$filequery = "filename = '".$filename."', scanext = '".$scanext."'";
								$updateimgquery = "UPDATE `dental_sleepstudy` SET $filequery WHERE `id` = '".$sleepstudyid."' and `patientid` = '".$patientid."';";
								if (!$db->query($updateimgquery)){
		?>
									<script type="text/javascript">
										alert("The file saved as: " + "<?php echo($fullfilename); ?>" + " But it could not be stored in the database");
									</script> 
		<?php
								} else {
									// copy file to patient images page
									$ins_sql = " insert into dental_q_image set 
										patientid = '".s_for($patientid)."',
										title = '".s_for($_POST['title'])."',
										imagetypeid = '1',
										image_file = '".s_for($fullfilename)."',
										userid = '".s_for($_SESSION['userid'])."',
										docid = '".s_for($_SESSION['docid'])."',
										adddate = now(),
										ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
									
									if (!$db->query($ins_sql)) {
								?>
										<script type="text/javascript">
											alert("The image could not be copied to the patient images page.");
										</script>
								<?php } ?>
									<script type="text/javascript">
										alert("It's done! The file has been saved as: " + "<?php echo($fullfilename); ?>");
									</script>           
						<?php
								}
							} else {			
						?>
								<script type="text/javascript">
									alert("<?php echo  "q_file/$fullfilename"; ?> File could not be stored to server.");
								</script>
						<?php
							}
						}
					}
				} else {
	 	?>
					<script type="text/javascript">
						alert("Invalid File Type or File too Large");
					</script>           
		<?php
				}
			}
		?>
			<script type="text/javascript">
				window.location.href = 'manage_sleep_studies.php?pid=<?php echo($_POST["patientid"]); ?>';
			</script>
		<?php
			die();
		}
		?>
		
		<?php 
			$sleepstudyquery = "SELECT COUNT(id) FROM dental_sleepstudy WHERE docid=".$_SESSION['docid']." AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY id DESC;";
			$sleepstudyres = $db->getRow($sleepstudyquery);
			$i = $sleepstudyres['COUNT(id)'] + 1;
			$calendar_vars = array();
			$calendar_vars[$i]['scheddate_id'] = "sleepsched$i";
			$calendar_vars[$i]['copyreqdate_id'] = "copyreqdate$i" 
		?>
  			<form name="sleepstudyadd" id="sleepstudyadd" style="float:left;" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
				<input id="title<?php echo $i?>" name="title" type="hidden" value="Sleep Study <?php echo $i?>" />
				<table id="sleepstudyscrolltable">
					<tr style="height:25px;">
						<td></td>
					</tr>
					<tr style="height:30px;">
						<td>
							<input type="radio" name="needed" id="needed1" value="Yes" onclick="document.getElementById('sleepsched<?php echo $i; ?>').style.visibility='visible';showWhere(this.form);autoselect(this,document.sleepstudyadd.completed);document.getElementById('interpretation<?php echo $i; ?>1').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>2').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>3').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>4').style.visibility='visible';">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="needed" id="needed2" value="No" onclick="document.getElementById('sleepsched<?php echo $i; ?>').style.visibility='hidden';hideWhere(this.form);autoselect(this,document.sleepstudyadd.completed);document.getElementById('interpretation<?php echo $i; ?>1').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>2').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>3').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>4').style.visibility='hidden';">No
						</td>
					</tr>
					<tr style="height:43px;">
						<td>
							<input id="sleepsched<?php echo $i; ?>" name="scheddate" type="text" class="field text addr tbox calendar" value="<?php echo (isset($scheddate) ? $scheddate : ''); ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('scheddate');" />
						</td>
					</tr>
					<tr style="height:30px;">
                        <td>
							<select id="labtype<?php echo  $i ?>" name="labtype" onChange="otherSelect(<?php echo $i; ?>, this.form);">
								<option value="HST">HST</option>
        						<option value="PSG">PSG</option>
							</select>
						</td>
					</tr>
					<tr style="height:30px;">
						<td>
							<select name="sleeplabwheresched" id="sleeplabwheresched<?php echo $i; ?>" onclick="Javascript: scroll(0,0);loadPopup('add_patient_to.php?ed=51');">
								<?php
						            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
						            
						            $sleeplabres = $db->getResults($sleeplabquery);
						            if ($sleeplabres) foreach ($sleeplabres as $sleeplab){
					            ?>
										<option value="<?php echo $sleeplab['sleeplabid']; ?>"><?php echo $sleeplab['company']; ?></option>
								<?php } ?>
								<option value="add new sleeplab">Add new sleeplab</option>
							</select>
						</td>
					</tr>
					<tr style="height:30px;">
						<td>
							<input type="radio" id="completed<?php echo $i; ?>1" name="completed" value="Yes"><span id="completed<?php echo $i; ?>3">Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
							<input type="radio" id="completed<?php echo $i; ?>2" name="completed" value="No"><span id="completed<?php echo $i; ?>4">No</span>
						</td>	
					</tr>						
					<tr style="height:44px;">
						<td>
							<input type="radio" id="interpretation<?php echo $i; ?>1" name="interpolation" value="Yes"><span id="interpretation<?php echo $i; ?>3">Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" id="interpretation<?php echo $i; ?>2" name="interpolation" value="No"><span id="interpretation<?php echo $i; ?>4">No</span>
						</td>
					</tr>						
					<tr style="height:40px;">
						<td>
							<input id="copyreqdate<?php echo $i; ?>" name="copyreqdate" type="text" class="field text addr tbox calendar" value="<?php echo (isset($copyreqdate) ? $copyreqdate : ''); ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" /><span id="req_0" class="req">*</span>
						</td>
					</tr>	
					<tr style="height:29px;">
						<td>
							<select id="sleeplab" name="sleeplab">
								<?php
						            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
						            
						            $sleeplabres = $db->getResults($sleeplabquery);
						            if ($sleeplabres) foreach ($sleeplabres as $sleeplab){
					            ?>
										<option value="<?php echo $sleeplab['sleeplabid']; ?>"><?php echo $sleeplab['company']; ?></option>
								<?php } ?>
								<option value="add new sleeplab">Add new sleeplab</option>
							</select>
						</td>
					</tr>
					<tr style="height:39px;">
						<td>
							<input type="hidden" value="<?php echo $i; ?>" name="formid" />
        					<input type="hidden" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>" name="patientid" />
							<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
        					<input name="file" type="file" size="4" />
						</td>
					</tr>
					<tr style="height:30px;">
						<td>
							<input type="submit" name="submitnewstudy" value="Add Study" />
						</td>
					</tr>
				</table>
			</form>

		<?php
			$sleepstudyquery = "SELECT * FROM dental_sleepstudy WHERE docid=".$_SESSION['docid']." AND patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY id DESC;";
			
			$sleepstudyres = $db->getResults($sleepstudyquery);
			if($sleepstudyres){
				$numrows = count($sleepstudyres);
			}

			if($numrows){
				$i = $numrows;
				$di = 0; 
				foreach ($sleepstudyres as $sleepstudy){
					$sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
					
					$sleeplabres = $db->query($sleeplabquery);
					$calendar_vars[$i]['scheddate_id'] = "scheddate$i";
					$calendar_vars[$i]['copyreqdate_id'] = "copyreqdate$i"
 		?>
					<form id="sleepstudy<?php echo $i; ?>" name="sleepstudy<?php echo $i; ?>" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" method="POST" style="height:400px;width:150px;float:left;margin:0 7px 0 0;">
						<input id="title<?php echo $i?>" name="title" type="hidden" value="Sleep Study <?php echo $i?>" />
						<div id="sleepstudyscrolltable<?php echo $i; ?>">
							<table id="sleepstudyscrolltable" style="border-right: 1px solid #000000;float: left;margin-right: 27px;width: 150px;">
								<tr style="height:25px;">
									<td style="text-align:center;">
            							<?php echo $i; ?>
									</td>
								</tr>
								<tr style="height:30px;">
									<td>
										<input type="radio" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';showWhere(this.form);autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?php echo  $i; ?>][completed]']);" name="data[<?php echo  $i ?>][needed]" value="Yes"<?php if($sleepstudy['needed'] == "Yes"){ echo " checked='checked'";} ?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';hideWhere(this.form);autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?php echo  $i; ?>][completed]']);" name="data[<?php echo  $i ?>][needed]" value="No"<?php if($sleepstudy['needed'] == "No"){ echo " checked='checked'";} ?>>No
									</td>
								</tr>
								<tr style="height:43px;">
            						<div id="hideifno<?php echo $i; ?>">
									<td>            
										<input id="scheddate<?php echo $i; ?>" name="data[<?php echo  $i ?>][scheddate]" type="text" class="field text addr tbox calendar" value="<?php echo $sleepstudy['scheddate']; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('scheddate');"  value="example 11/11/1234" />
										<script id="js<?php echo $i; ?>" type="text/javascript">
            								//var cal<?php echo $i; ?> = new CalendarPopup();
        								</script>
									</td>
								</tr>
                                <tr style="height:30px;">
                                    <td name="data[<?php echo  $i; ?>][labtype]">
	                                    <select name="data[<?php echo  $i; ?>][labtype]" id="labtype<?php echo $i; ?>" onChange="otherSelect2('sleepstudy<?php echo $i; ?>',<?php echo $i; ?>, this.form);">
		                                    <option value="PSG" <?php if($sleepstudy['labtype'] == "PSG"){echo " selected='selected'";} ?>>PSG</option>
		                                    <option value="HST" <?php if($sleepstudy['labtype'] == "HST"){echo " selected='selected'";} ?>>HST</option>
	                                    </select>
                                    </td>
                                </tr>
								<tr style="height:30px;">
									<td name="sleeplabwheresched">
										<select id="sleeplabwheresched<?php echo $i; ?>" name="data[<?php echo  $i ?>][sleeplabwheresched]" >
											<option value="add new sleeplab">Add new sleeplab</option>
											<?php
												$sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
												
												$sleeplabres = $db->getResults($sleeplabquery);
												if ($sleeplabres) foreach ($sleeplabres as $sleeplab){
											?>
												<option value="<?php echo $sleeplab['sleeplabid']; ?>" <?php if($sleepstudy['sleeplabwheresched'] == $sleeplab['sleeplabid']){echo " selected='selected'";} ?>><?php echo $sleeplab['company']; ?></option>
											<?php } ?>
											<option value="add new sleeplab">Add new sleeplab</option>
										</select>
									</td>
								</tr>
								<tr style="height:30px;">
									<td>
										<div id="completed">
											<input type="radio" id="completed<?php echo $i."1"; ?>" name="data[<?php echo  $i ?>][completed]" value="Yes" <?php if($sleepstudy['completed'] == "Yes"){echo " checked='checked'";} ?>><span id="completed<?php echo $i."3"; ?>">Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="completed<?php echo $i."2"; ?>" name="data[<?php echo  $i ?>][completed]" value="No" <?php if($sleepstudy['completed'] == "No"){echo " checked='checked'";} ?>><span id="completed<?php echo $i."4"; ?>">No</span>
            							</div>						
									</td>
								</tr>
								<?php if($sleepstudy['needed'] == "Yes") { ?>
									<script type="text/javascript">
										document.getElementById('scheddate<?php echo $i; ?>').style.visibility = 'visible';
										autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?php echo  $i ?>][completed]']);
									</script>
             					<?php } else { ?>
									<script type="text/javascript">
										document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';
										if (document.getElementById('sleeplabschedhome<?php echo $i; ?>')) {
											document.getElementById('sleeplabschedhome<?php echo $i; ?>').style.display='none';
										}
										document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.display='none';
										autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?php echo  $i ?>][completed]']);
									</script>
             					<?php } ?>
								<tr style="height:44px;">
									<td name="interpolation">
										<input type="radio" id="interpretation<?php echo $i; ?>1" name="data[<?php echo  $i ?>][interpolation]" value="Yes" <?php if($sleepstudy['interpolation'] == "Yes"){echo " checked='checked'";} ?>><span id="interpretation<?php echo $i; ?>3">Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" id="interpretation<?php echo $i; ?>2" name="data[<?php echo  $i ?>][interpolation]" value="No"<?php if($sleepstudy['interpolation'] == "No"){echo " checked='checked'";} ?>><span id="interpretation<?php echo $i; ?>4">No</span>						
									</td>
								</tr>
								
						        <?php if($sleepstudy['labtype'] == "PSG"){ ?>
						            <script type="text/javascript">
										document.getElementById('interpretation<?php echo $i; ?>1').style.visibility = 'hidden';
						                document.getElementById('interpretation<?php echo $i; ?>2').style.visibility = 'hidden';
						                document.getElementById('interpretation<?php echo $i; ?>3').style.visibility = 'hidden';
						                document.getElementById('interpretation<?php echo $i; ?>4').style.visibility = 'hidden';
						            </script>
						        <?php } else { ?>
						            <script type="text/javascript">
						                document.getElementById('interpretation<?php echo $i; ?>1').style.visibility = 'visible';
						                document.getElementById('interpretation<?php echo $i; ?>2').style.visibility = 'visible';
						                document.getElementById('interpretation<?php echo $i; ?>3').style.visibility = 'visible';
						                document.getElementById('interpretation<?php echo $i; ?>4').style.visibility = 'visible';
            						</script>
            					<?php } ?>

								<tr style="height:40px;">
									<td name="copyreqdate">
										<input id="copyreqdate<?php echo $i?>" name="data[<?php echo  $i ?>][copyreqdate]" type="text" class="field text addr tbox calendar" value="<?php echo $sleepstudy['copyreqdate']; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
									</td>
								</tr>
								<tr style="height:25px;">
									<td name="sleeplab">
										<select id="sleeplab" name="data[<?php echo  $i ?>][sleeplab]">
											<?php
									            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
									            
									            $sleeplabres = $db->getResults($sleeplabquery);
									            if ($sleeplabres) foreach ($sleeplabres as $sleeplab){
								            ?>
													<option value="<?php echo $sleeplab['sleeplabid']; ?>" <?php if($sleeplab['sleeplabid'] == $sleepstudy['sleeplab']){ echo " selected='selected'";}?>><?php echo $sleeplab['company']; ?></option>
											<?php } ?>
											<option value="add new sleeplab">Add new sleeplab</option>
										</select>
									</td>
								</tr>
								<tr style="height:39px;">
									<td>
										<?php if ($sleepstudy['testnumber'] != null && $sleepstudy['scanext'] != null) { ?>
												<a href="display_file.php?f=<?php echo  $sleepstudy['filename'].".".$sleepstudy['scanext']; ?>" target="_blank" class="button">View Scan</a>
										<?php
												print "<input type=\"button\" id=\"edit$i\" value=\"Edit\" title=\"Edit Scan\" />";
												print "<input id=\"file$i\" style=\"display:none;\" name=\"file\" type=\"file\" size=\"4\" />";
											} else {
												print "<input id=\"file$i\" name=\"file\" type=\"file\" size=\"4\" />";
											}
										?>
									</td>
									</div>
								</tr>
								<tr style="height:30px;">
									<td>
										<input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
										<input type="hidden" name="formid" value="<?php echo  $i ?>">
										<input type="hidden" name="sleepstudyid" value="<?php echo $sleepstudy['id']; ?>">
            							<input type="submit" name="updatestudy" value="Save Study" />
	    								<input type="submit" name="deletestudy" value="Delete" onclick="return confirm('Are you sure you want to delete this sleep study?');" />
									</td>
								</tr>
							</table>
						</div>
					</form>				
		<?php
 			$di++;
 		?>

		<?php if($sleepstudy['needed'] == "Yes") { ?>
			<script type="text/javascript">
				document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';
				document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='visible';
				autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?php echo  $i; ?>][completed]']);
			</script>
 		<?php }else{ ?>
			<script type="text/javascript">
				document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';
				document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='hidden';
				autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?php echo  $i; ?>][completed]']);
			</script>
 		<?php } ?>

		<script type="text/javascript">
		// <!--var cal<?php echo($i); ?> = new calendar2(document.forms['sleepstudy<?php echo($i); ?>'].elements['scheddate']);-->
		</script>

		<?php
					$i--;
				}
	 		}
 		?>

		<script type="text/javascript">
			<?php
				foreach ($calendar_vars as $key => $calid) {
					//print "var cal_" . $calid['scheddate_id'] . " = new calendar2(document.getElementById('" . $calid['scheddate_id'] . "'));";
					//print "var cal_" . $calid['copyreqdate_id'] . " = new calendar2(document.getElementById('" . $calid['copyreqdate_id'] . "'));";
				}
			?>
		</script> 

	</body>
</html>
