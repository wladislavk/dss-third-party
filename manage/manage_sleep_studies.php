<?php
session_start();
require_once('admin/includes/config.php');
require_once('includes/constants.inc');
require_once('includes/general_functions.php');
include("includes/sescheck.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script type="text/javascript" src="admin/popup/popup.js"></script>
<script src="/manage/js/add_new_sleeplab.js" type="text/javascript"></script>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('[id^=edit]').click(function() {
			var r = confirm("Do you want to replace the image on file? This cannot be undone.");
			if (r == true) {
				var edit_id = $(this).attr('id');
				var num = edit_id.replace("edit", "");
				$('#view'+num).css("display", "none");
				$('#edit'+num).css("display", "none");
				$('#file'+num).css("display", "inline");
			}
		});
		$(':input').change(function() { 
			parent.window.onbeforeunload = confirmExit;
			parent.document.form_page1.iframestatus.value = "dirty";
		});
		$('[id^=sleepstudy]').submit(function() {
			parent.document.form_page1.iframestatus.value = "clean";
		});
		function confirmExit()
		{
			return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
		}
	});
</script>
  <script type="text/javascript">
 function formshowhide(status, val)
  {
  alert('YES');
  if(status == 'Yes' || status === true){
  document.getElementById(val).scheddate.style.display='inline';
	document.getElementById(val).sleeplabwheresched.style.display='inline';
	document.getElementById(val).completed.style.display='inline';
	document.getElementById(val).interpolation.style.display='inline';
	document.getElementById(val).labtype.style.display='inline';
	document.getElementById(val).copyreqdate.style.display='inline';
  }else if(status == 'No' || status === false){
  alert('YES');
  document.getElementById(val).scheddate.style.display='none';
	document.getElementById(val).sleeplabwheresched.style.display='none';
	document.getElementById(val).completed.style.display='none';
	document.getElementById(val).interpolation.style.display='none';
	document.getElementById(val).labtype.style.display='none';
	document.getElementById(val).copyreqdate.style.display='none';
  }
  }
 </script>

<script type="text javascript">
function popitup(url) {
	newwindow=parent.window.open(url,'name','height=400,width=400');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<script language="javascript" type="text/javascript">
function autoselect(selectedOption, updateCompleted) {
	if(selectedOption.value=="No") {
		updateCompleted[0].checked=true;
	} else {
		updateCompleted[1].checked=true;
	}
}
</script>

<script type="text/javascript">
 function otherSelect(number, f) {
            var list = document.sleepstudyadd.labtype;
            var chosenItemText = list.value;
            if (chosenItemText == "PSG") {
                document.getElementById('interpretation'+number+'1').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'2').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'3').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'4').style.visibility = 'hidden';
		if($('input:radio[name=needed]:checked').val()=="Yes"){
		f.sleeplabwheresched.style.display = "block";
		}else{
		f.sleeplabwheresched.style.display = "none";
		}
		//f.sleeplabschedhome.style.display = "none";
            }
            else {
                document.getElementById('interpretation'+number+'1').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'2').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'3').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'4').style.visibility = 'visible';
                //f.sleeplabwheresched.style.display = "none";
		if($('input:radio[name=needed]:checked').val()=="Yes"){
                f.sleeplabsched.style.display = "block";
		}else{
                f.sleeplabsched.style.display = "none";
		}
            }
        }
 function otherSelect2(ss, number, f) {
						var sleeplabwheresched = document.getElementById('sleeplabwheresched'+number);
						var sleeplabschedhome = document.getElementById('sleeplabschedhome'+number);
            //var list = document.sleepstudyadd.labtype;
            var list = document.getElementById('labtype'+number);//document[ss].labtype;
            var chosenItemText = list.value;
            if (chosenItemText == "PSG") {
                document.getElementById('interpretation'+number+'1').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'2').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'3').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'4').style.visibility = 'hidden';
                if($('input:radio[name="data['+number+'][needed]"]:checked').val()=="Yes"){
                sleeplabwheresched.style.display = "block";
                }else{
                sleeplabwheresched.style.display = "none";
                }
                //sleeplabschedhome.style.display = "none";

            }
            else {
                document.getElementById('interpretation'+number+'1').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'2').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'3').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'4').style.visibility = 'visible';
                //sleeplabwheresched.style.display = "none";
                if($('input:radio[name="data['+number+'][needed]"]:checked').val()=="Yes"){
                sleeplabsched.style.display = "block";
                }else{
                sleeplabsched.style.display = "none";
                }

            }
        }

function showWhere(f){
	var id = f.formid.value;
	var sleeplabwheresched = document.getElementById('sleeplabwheresched'+id);
	var sleeplabschedhome = document.getElementById('sleeplabschedhome'+id);
	var labtype = document.getElementById('labtype'+id);
		sleeplabwheresched.style.display = "block";
}

function hideWhere(f){
	var id = f.formid.value;
	var sleeplabwheresched = document.getElementById('sleeplabwheresched'+id);
	var sleeplabschedhome = document.getElementById('sleeplabschedhome'+id);
  sleeplabwheresched.style.display = "none";
}

</script>

   
</head>

<body style="background:none;"> 
<?php
if($_SESSION['userid'] == '')
{
	?>
	<script type="text/javascript">
		alert("Members Area, Please Login");
		window.location = "login.php";
	</script>
	<?
	die();
}

// Create Filename
if(isset($_POST['deletestudy'])&&isset($_POST['sleepstudyid'])){
  $s = "DELETE FROM dental_sleepstudy where id=".mysql_real_escape_string($_POST['sleepstudyid'])." AND patientid=".mysql_real_escape_string($_POST['patientid']); 
  mysql_query($s);
}
if(isset($_POST['updatestudy']) || isset($_POST['submitnewstudy'])) {
  $sql = "SELECT firstname, lastname FROM dental_patients WHERE patientid = '".$_POST['patientid']."';";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
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
	if (!mysql_query($updslquery)){
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
	if (!mysql_query($insslquery)){
		echo "Could not add sleep lab, please try again!";
	} else {
		$sleepstudyid = mysql_insert_id();
		$inserted = true;
	}
}
if ($origfilename != '') {
	if ($inserted || $updated) {
	//print_r($_FILES);
	//print "<br />" . sys_get_temp_dir() . "<br />";
	//error_reporting(E_ALL);
	//ini_set("display_errors", 1); 
	//die();

		if ((array_search($_FILES["file"]["type"], $dss_file_types) !== false) && ($_FILES["file"]["size"] < DSS_FILE_MAX_SIZE))
		{
		if ($_FILES["file"]["error"] > 0)
			{
			 ?>
						 <script type="text/javascript">
						 alert("<?php echo($_FILES['file']['error']); ?>");
						 </script>
			 <?php
			}
		else
			{
			if (file_exists("upload/" . $_FILES["file"]["name"]))
				{
				?>
						 <script type="text/javascript">
						 alert("File Already Exists");
							</script>           
						 <?php
				}
			else
				{
				//$filename = $patientid.'-'.$random.".".$scanext;
				$scanext = end(explode('.', $origfilename));
				$fullfilename = $filename . "." . $scanext;
				$success = uploadImage($_FILES["file"],"q_file/".$fullfilename);
				//$success = move_uploaded_file($_FILES["file"]["tmp_name"],"sleepstudies/$fullfilename");
					if ($success) {
					  // Delete previous file if updating, then add reference to filename in database
						if ($updated) {
							$prevfile_qry = "SELECT filename, scanext FROM dental_sleepstudy WHERE `id` = '".$_POST['sleepstudyid']."' and `patientid` = '".$patientid."';";
							$prevfile_result = mysql_query($prevfile_qry);
							$prev_filename = mysql_result($prevfile_result, 0, 0);
							$prev_scanext = mysql_result($prevfile_result, 0, 1);
							unlink("q_file/" . $prev_filename . "." . $prev_scanext);
						}
						$filequery = "filename = '".$filename."', scanext = '".$scanext."'";
						$updateimgquery = "UPDATE `dental_sleepstudy` SET $filequery WHERE `id` = '".$sleepstudyid."' and `patientid` = '".$patientid."';";
						if (!mysql_query($updateimgquery)){
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
								if (!mysql_query($ins_sql)) {
								?>
									<script type="text/javascript">
										alert("The image could not be copied to the patient images page.");
									</script>
								<?php
								}
					 ?>
							 <script type="text/javascript">
							 alert("It's done! The file has been saved as: " + "<?php echo($fullfilename); ?>");
								</script>           
							 <?php
						}
					} else {			
						?>
						<script type="text/javascript">
							alert("<?= "q_file/$fullfilename"; ?> File could not be stored to server.");
						</script><?php
					}
				}
			}
		}
		else
		{
	 ?>
						 <script type="text/javascript">
						 alert("Invalid File Type or File too Large");
							</script>           
						 <?php
		}
	}
	?>
	<script type="text/javascript">
	window.location.href='manage_sleep_studies.php?pid=<?php echo($_POST["patientid"]); ?>';
	</script>
	<?php
	die();
}

?>


  <?php 
	$sleepstudyquery = "SELECT COUNT(id) FROM dental_sleepstudy WHERE docid=".$_SESSION['docid']." AND patientid='".$_GET['pid']."' ORDER BY id DESC;";
	$sleepstudyres = mysql_query($sleepstudyquery);
	$i = mysql_result($sleepstudyres, 0) + 1;
	$calendar_vars = array();
  $calendar_vars[$i]['scheddate_id'] = "sleepsched$i";
  $calendar_vars[$i]['copyreqdate_id'] = "copyreqdate$i" 
	?>
  <form name="sleepstudyadd" id="sleepstudyadd" style="float:left;" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?pid=<?= $_GET['pid']; ?>">
	<input id="title<?=$i?>" name="title" type="hidden" value="Sleep Study <?=$i?>" />
	<table id="sleepstudyscrolltable">

						<tr style="height:25px;">

						<td>


						</td>

						</tr>

						<tr style="height:30px;">

						<td>
            

						<input type="radio" name="needed" id="needed1" value="Yes" onclick="document.getElementById('sleepsched<?php echo $i; ?>').style.visibility='visible';showWhere(this.form);autoselect(this,document.sleepstudyadd.completed);document.getElementById('interpretation<?php echo $i; ?>1').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>2').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>3').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>4').style.visibility='visible';">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
						<input type="radio" name="needed" id="needed2" value="No" onclick="document.getElementById('sleepsched<?php echo $i; ?>').style.visibility='hidden';hideWhere(this.form);autoselect(this,document.sleepstudyadd.completed);document.getElementById('interpretation<?php echo $i; ?>1').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>2').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>3').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>4').style.visibility='hidden';">No

						</td>

						</tr>

						<tr style="height:43px;">

						<td>

						<input id="sleepsched<?php echo $i; ?>" name="scheddate" type="text" class="field text addr tbox" value="<?php echo $scheddate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('scheddate');" onclick="cal_sleepsched<?=$i?>.popup();" value="example 11/11/1234" />
						
						</td>
						
						</tr>
					<tr style="height:30px;">

                                                <td>

                                                <select id="labtype<?= $i ?>" name="labtype" onChange="otherSelect(<?php echo $i; ?>, this.form);">

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
            $sleeplabres = mysql_query($sleeplabquery);
            while($sleeplab = mysql_fetch_array($sleeplabres)){
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
						
						<input id="copyreqdate<?php echo $i; ?>" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onclick="cal_copyreqdate<?=$i?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
						
						</td>
						
						</tr>
						
						<tr style="height:29px;">
						
						<td>
						
						<select id="sleeplab" name="sleeplab">
						<?php
            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
            $sleeplabres = mysql_query($sleeplabquery);
            while($sleeplab = mysql_fetch_array($sleeplabres)){
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
            <input type="hidden" value="<?php echo $_GET['pid'] ?>" name="patientid" />
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
$sleepstudyquery = "SELECT * FROM dental_sleepstudy WHERE docid=".$_SESSION['docid']." AND patientid='".$_GET['pid']."' ORDER BY id DESC;";
$sleepstudyres = mysql_query($sleepstudyquery);
if($sleepstudyres){
$numrows = mysql_num_rows($sleepstudyres);
}
if($numrows){
 $i = $numrows;
 $di = 0; 
 while($sleepstudy = mysql_fetch_array($sleepstudyres)){
  $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
 $sleeplabres = mysql_query($sleeplabquery);
 $calendar_vars[$i]['scheddate_id'] = "scheddate$i";
 $calendar_vars[$i]['copyreqdate_id'] = "copyreqdate$i"
 ?>
 <form id="sleepstudy<?php echo $i; ?>" name="sleepstudy<?php echo $i; ?>" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?pid=<?php echo $_GET['pid']; ?>" method="POST" style="height:400px;width:150px;float:left;margin:0 7px 0 0;">
 <input id="title<?=$i?>" name="title" type="hidden" value="Sleep Study <?=$i?>" />
 <div id="sleepstudyscrolltable<?php echo $i; ?>">
 <table id="sleepstudyscrolltable" style="border-right: 1px solid #000000;float: left;margin-right: 27px;width: 150px;">

						<tr style="height:25px;">

						<td style="text-align:center;">

             <?php echo $i; ?>
						</td>

						</tr>

						<tr style="height:30px;">

						<td>

						<input type="radio" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';showWhere(this.form);autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?= $i; ?>][completed]']);" name="data[<?= $i ?>][needed]" value="Yes"<?php if($sleepstudy['needed'] == "Yes"){ echo " checked='checked'";} ?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="radio" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';hideWhere(this.form);autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?= $i; ?>][completed]']);" name="data[<?= $i ?>][needed]" value="No"<?php if($sleepstudy['needed'] == "No"){ echo " checked='checked'";} ?>>No

						</td>

						</tr>

						<tr style="height:43px;">
            <div id="hideifno<?php echo $i; ?>">
						<td>
            
            
						<input id="scheddate<?php echo $i; ?>" name="data[<?= $i ?>][scheddate]" type="text" class="field text addr tbox" value="<?php echo $sleepstudy['scheddate']; ?>" tabindex="10" style="width:100px;" maxlength="255" onClick="cal_scheddate<?=$i?>.popup();" onChange="validateDate('scheddate');"  value="example 11/11/1234" />
						
						<script id="js<?php echo $i; ?>" type="text/javascript">
                var cal<?php echo $i; ?> = new CalendarPopup();
            </script>
						
						</td>
						
						</tr>
						
                                                <tr style="height:30px;">

                                                <td name="data[<?= $i; ?>][labtype]">

                                                <select name="data[<?= $i; ?>][labtype]" id="labtype<?php echo $i; ?>" onChange="otherSelect2('sleepstudy<?php echo $i; ?>',<?php echo $i; ?>, this.form);">

                                                <option value="PSG" <?php if($sleepstudy['labtype'] == "PSG"){echo " selected='selected'";} ?>>PSG</option>

                                                <option value="HST" <?php if($sleepstudy['labtype'] == "HST"){echo " selected='selected'";} ?>>HST</option>

                                                </select>

                                                </td>

                                                </tr>

						<tr style="height:30px;">
						
						<td name="sleeplabwheresched">
						<select id="sleeplabwheresched<?php echo $i; ?>" name="data[<?= $i ?>][sleeplabwheresched]" >
						<option value="add new sleeplab">Add new sleeplab</option>
						<?php
            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
            $sleeplabres = mysql_query($sleeplabquery);

            while($sleeplab = mysql_fetch_array($sleeplabres)){
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
						
						<input type="radio" id="completed<?php echo $i."1"; ?>" name="data[<?= $i ?>][completed]" value="Yes" <?php if($sleepstudy['completed'] == "Yes"){echo " checked='checked'";} ?>><span id="completed<?php echo $i."3"; ?>">Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<input type="radio" id="completed<?php echo $i."2"; ?>" name="data[<?= $i ?>][completed]" value="No" <?php if($sleepstudy['completed'] == "No"){echo " checked='checked'";} ?>><span id="completed<?php echo $i."4"; ?>">No</span>
            </div>						
						</td>
						
						</tr>
						<?php if($sleepstudy['needed'] == "Yes"){
             ?>
             <script type="text/javascript">
             	document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';
							autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?= $i ?>][completed]']);
             </script>
             <?php
            }else{
            ?>
             <script type="text/javascript">
             	document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';
							document.getElementById('sleeplabschedhome<?php echo $i; ?>').style.display='none';
							document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.display='none';
							autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?= $i ?>][completed]']);
             </script>
             <?php            
             }?>
						<tr style="height:44px;">
						
						<td name="interpolation">
						
						<input type="radio" id="interpretation<?php echo $i; ?>1" name="data[<?= $i ?>][interpolation]" value="Yes" <?php if($sleepstudy['interpolation'] == "Yes"){echo " checked='checked'";} ?>><span id="interpretation<?php echo $i; ?>3">Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<input type="radio" id="interpretation<?php echo $i; ?>2" name="data[<?= $i ?>][interpolation]" value="No"<?php if($sleepstudy['interpolation'] == "No"){echo " checked='checked'";} ?>><span id="interpretation<?php echo $i; ?>4">No</span>						
						</td>
						
						</tr>
						
						<script type="text/javascript">
            <?php if($sleepstudy['labtype'] == "PSG"){ ?>
						    document.getElementById('interpretation<?php echo $i; ?>1').style.visibility = 'hidden';
                document.getElementById('interpretation<?php echo $i; ?>2').style.visibility = 'hidden';
                document.getElementById('interpretation<?php echo $i; ?>3').style.visibility = 'hidden';
                document.getElementById('interpretation<?php echo $i; ?>4').style.visibility = 'hidden';
            <?php
            }else{
            ?>
                document.getElementById('interpretation<?php echo $i; ?>1').style.visibility = 'visible';
                document.getElementById('interpretation<?php echo $i; ?>2').style.visibility = 'visible';
                document.getElementById('interpretation<?php echo $i; ?>3').style.visibility = 'visible';
                document.getElementById('interpretation<?php echo $i; ?>4').style.visibility = 'visible';
            <?php } ?>
            </script> 
						
						<tr style="height:40px;">
						
						<td name="copyreqdate">
						
						<input id="copyreqdate<?=$i?>" name="data[<?= $i ?>][copyreqdate]" type="text" class="field text addr tbox" value="<?php echo $sleepstudy['copyreqdate']; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onclick="cal_copyreqdate<?=$i?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
						
						</td>
						
						</tr>
						
						<tr style="height:25px;">
						
						<td name="sleeplab">
						
						<select id="sleeplab" name="data[<?= $i ?>][sleeplab]">
						<?php
            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
            $sleeplabres = mysql_query($sleeplabquery);
            while($sleeplab = mysql_fetch_array($sleeplabres)){
            ?>
						
						<option value="<?php echo $sleeplab['sleeplabid']; ?>" <?php if($sleeplab['sleeplabid'] == $sleepstudy['sleeplab']){ echo " selected='selected'";}?>><?php echo $sleeplab['company']; ?></option>
						<?php } ?>
						<option value="add new sleeplab">Add new sleeplab</option>
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:39px;">
						
						<td>
						

						<?php 
						if ($sleepstudy['testnumber'] != null && $sleepstudy['scanext'] != null) {
							print "<input type=\"button\" id=\"view$i\" value=\"View\" title=\"View Scan\" onClick=\"window.open('q_file/".$sleepstudy['filename'].".".$sleepstudy['scanext']."','windowname1','width=400, height=400');return false;\" />";
							print "<input type=\"button\" id=\"edit$i\" value=\"Edit\" title=\"Edit Scan\" />";
							print "<input id=\"file$i\" style=\"display:none;\" name=\"file\" type=\"file\" size=\"4\" />";
							/*<a style="font-weight:bold; font-size:15px;" href="javascript: void(0)" onClick="window.open('sleepstudies/<?=$_GET['pid']?>-<?php echo $sleepstudy['testnumber']; ?>.<?php echo $sleepstudy['scanext']; ?>','windowname1','width=400, height=400');return false;">View Scan</a>*/
						} else {
							print "<input id=\"file$i\" name=\"file\" type=\"file\" size=\"4\" />";
						}
						?>
						</td>
						</div>
						</tr>
						<tr style="height:30px;">
						
						<td>
						<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
						<input type="hidden" name="formid" value="<?= $i ?>">
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

<?php if($sleepstudy['needed'] == "Yes"){
 ?>
 <script type="text/javascript">
	document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';
	document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='visible';
	autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?= $i; ?>][completed]']);
 </script>
 <?php
}else{
?>
 <script type="text/javascript">
	document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';
	document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='hidden';`
	autoselect(this,document.sleepstudy<?php echo $i; ?>.elements['data[<?= $i; ?>][completed]');
 </script>
 <?php            
} ?>

 <script type="text/javascript">
 <!--var cal<?php echo($i); ?> = new calendar2(document.forms['sleepstudy<?php echo($i); ?>'].elements['scheddate']);-->
 </script>
 <?php
 
 
 $i--;
 }
 }
 ?>

<script type="text/javascript">
	<?php
	foreach ($calendar_vars as $key => $calid) {
		print "var cal_" . $calid['scheddate_id'] . " = new calendar2(document.getElementById('" . $calid['scheddate_id'] . "'));";
		print "var cal_" . $calid['copyreqdate_id'] . " = new calendar2(document.getElementById('" . $calid['copyreqdate_id'] . "'));";
	}
	?>
</script> 

				
				</body>
				</html>
