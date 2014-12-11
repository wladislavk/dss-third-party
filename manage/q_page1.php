<?php 
	include "includes/top.htm";
	require_once('includes/patient_info.php');
	if ($patient_info) {
		if(!empty($_GET['own']) && $_GET['own']==1){
			$c_sql = "SELECT patientid FROM dental_patients WHERE (symptoms_status=1 || sleep_status=1 || treatments_status=1 || history_status=1) AND patientid='".mysqli_real_escape_string($con, $_GET['pid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";  $c_q = mysql_query($c_sql);  $changed = mysql_num_rows($c_q);
			$own_sql = "UPDATE dental_patients SET symptoms_status=3, sleep_status=3, treatments_status=3, history_status=3 WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			$db->query($own_sql);

			if($_GET['own_completed']==1){
				$q1_sql = "SELECT q_page1id from dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";

				if($db->getNumberRows($q1_sql) == 0){
					$ed_sql = "INSERT INTO dental_q_page1 SET exam_date=now(), patientid='".$_GET['pid']."'";
					$db->query($ed_sql);
				}else{
					$ed_sql = "UPDATE dental_q_page1 SET exam_date=now() WHERE patientid='".$_GET['pid']."'";
					$db->query($ed_sql);
				}
			}
?>
            <script type="text/javascript">
                <?php if($changed>0) { ?>
                    alert("Warning! Patient has made changes to the Questionnaire. Please review the patient's ENTIRE questionnaire for changes.");
                <?php } ?>
                window.location = 'q_page1.php?pid=<?php echo $_GET['pid']?>&addtopat=1';
            </script>
<?php
            die();
		}

?>
		<script language="JavaScript" src="calendar1.js"></script>
		<script language="JavaScript" src="calendar2.js"></script>

		<script type="text/javascript" src="js/q_page1.js"></script>
<?php
	$todaysdate=date("m/d/Y");
	if (!empty($_POST['q_page1sub']) && $_POST['q_page1sub'] == 1) {
    	$exam_date = ($_POST['exam_date']!='')?date('Y-m-d', strtotime($_POST['exam_date'])):'';
		$ess = $_POST['ess'];
		$tss = $_POST['tss'];
        $chief_complaint_text = $_POST['chief_complaint_text'];	
		$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
		
		$complaint_my = $db->getRow($complaint_sql);
		$comp_arr = '';
	
		if ($complaint_my) foreach ($complaint_my as $complaint_myarray) {
			if ($_POST['complaint_'.$complaint_myarray['complaintid']] <> '') {
				$comp_arr .= $complaint_myarray['complaintid'].'|'.$_POST['complaint_'.$complaint_myarray['complaintid']].'~';
			}
		}

		if($_POST['complaint_0'] <> '') {
            $comp_arr .= '0|'.$_POST['complaint_0'].'~';
        }
	
		$other_complaint = $_POST['other_complaint'];
		$additional_paragraph = $_POST['additional_paragraph'];
		$energy_level = $_POST['energy_level'];
		$snoring_sound = $_POST['snoring_sound'];
		$breathing_night = $_POST['breathing_night'];
		$wake_night = $_POST['wake_night'];
		$morning_headaches = $_POST['morning_headaches'];
		$hours_sleep = $_POST['hours_sleep'];
		$quit_breathing = $_POST['quit_breathing'];
		$bed_time_partner = $_POST['bed_time_partner'];
		$sleep_qual = $_POST['sleep_qual'];
		$sleep_same_room = $_POST['sleep_same_room'];
		$told_you_snore = $_POST['told_you_snore'];
		$main_reason = $_POST['main_reason'];
		$main_reason_other = $_POST['main_reason_other'];
		$main_reason_arr = '';
		echo $main_reason;

		if(is_array($main_reason))
		{
			foreach($main_reason as $val)
			{
				if(trim($val) <> '')
					$main_reason_arr .= trim($val).'~';
			}
		}

		if($main_reason_arr != '') {
			$main_reason_arr = '~'.$main_reason_arr;
		}	
	
		if($_POST['ed'] == '') {
			$ins_sql = " insert into dental_q_page1 set 
			patientid = '".s_for($_GET['pid'])."',
	                exam_date = '".s_for($exam_date)."',
			ess = '".s_for($ess)."',
			tss = '".s_for($tss)."',
			chief_complaint_text = '".s_for($chief_complaint_text)."',
			sleep_qual = '".s_for($sleep_qual)."',
			complaintid = '".s_for($comp_arr)."',
			other_complaint = '".s_for($other_complaint)."',
			additional_paragraph = '".s_for($additional_paragraph)."',
			energy_level = '".s_for($energy_level)."',
			snoring_sound = '".s_for($snoring_sound)."',
			wake_night = '".s_for($wake_night)."',
			breathing_night = '".s_for($breathing_night)."',
			morning_headaches = '".s_for($morning_headaches)."',
			hours_sleep = '".s_for($hours_sleep)."',
			quit_breathing = '".s_for($quit_breathing)."',
			bed_time_partner = '".s_for($bed_time_partner)."',
			sleep_same_room = '".s_for($sleep_same_room)."',
			told_you_snore = '".s_for($told_you_snore)."',
			main_reason = '".s_for($main_reason_arr)."',
			main_reason_other = '".s_for($main_reason_other)."',
			userid = '".s_for($_SESSION['userid'])."',
			docid = '".s_for($_SESSION['docid'])."',
			adddate = '".date('m/d/Y')."',
			ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
			$db->query($ins_sql);		
			$msg = "Added Successfully";
            if (isset($_POST['q_pagebtn_proceed'])) {
?>
                <script type="text/javascript">
                    window.location='q_page2.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
<?php
            } else {
?>
				<script type="text/javascript">
					window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>#form';
				</script>
<?php
			}
			die();
		} else {
			$ed_sql = " update dental_q_page1 set 
	                exam_date = '".s_for($exam_date)."',
	                ess = '".s_for($ess)."',
	                tss = '".s_for($tss)."',
			chief_complaint_text = '".s_for($chief_complaint_text)."',
			complaintid = '".s_for($comp_arr)."',
			sleep_qual = '".s_for($sleep_qual)."',
			other_complaint = '".s_for($other_complaint)."',
			additional_paragraph = '".s_for($additional_paragraph)."',
			energy_level = '".s_for($energy_level)."',
			snoring_sound = '".s_for($snoring_sound)."',
			wake_night = '".s_for($wake_night)."',
			breathing_night = '".s_for($breathing_night)."',
			morning_headaches = '".s_for($morning_headaches)."',
			hours_sleep = '".s_for($hours_sleep)."',
			quit_breathing = '".s_for($quit_breathing)."',
			bed_time_partner = '".s_for($bed_time_partner)."',
			sleep_same_room = '".s_for($sleep_same_room)."',
			told_you_snore = '".s_for($told_you_snore)."',
			main_reason = '".s_for($main_reason_arr)."',
			main_reason_other = '".s_for($main_reason_other)."'
			where q_page1id = '".s_for($_POST['ed'])."'";
			
			$db->query($ed_sql);
		
			$msg = "Edited Successfully";
            if(isset($_POST['q_pagebtn_proceed'])) {
?>
                <script type="text/javascript">
	                window.location='q_page2.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
<?php
            } else {
?>
				<script type="text/javascript">
					window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>#form';
				</script>
<?php
			}
			die();
		}
	}
	$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
	if($pat_myarray['patientid'] == '') {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		die();
	}

    $exist_sql = "SELECT symptoms_status, sleep_status, treatments_status, history_status FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";
    
    $exist_row = $db->getRow($exist_sql);
    if($exist_row['symptoms_status'] == 0 && $exist_row['sleep_status'] == 0 && $exist_row['treatments_status'] == 0 && $exist_row['history_status'] == 0) {
?>
        <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It has not been edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please  
            <a href="q_page1.php?pid=<?php echo  $_GET['pid']; ?>&own=1&addtopat=1">click here</a>.
        </div>
<?php
    } elseif($exist_row['symptoms_status'] != 2 && $exist_row['sleep_status'] != 2 && $exist_row['treatments_status'] != 2 && $exist_row['history_status'] != 2 &&
            $exist_row['symptoms_status'] != 3 && $exist_row['sleep_status'] != 3 && $exist_row['treatments_status'] != 3 && $exist_row['history_status'] != 3) {
?>
        <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It is currently being edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please
            <a href="q_page1.php?pid=<?php echo  $_GET['pid']; ?>&own=1&addtopat=1">click here</a>.
        </div>
<?php
    } else {
		if($exist_row['history_status'] == 2 || $exist_row['sleep_status'] == 2 || $exist_row['history_status'] == 2 || $exist_row['history_status'] == 2) {
?>
        	<div style="width:500px; margin:30px auto 0 auto;">This section has been edited by the patient. All patient changes are visible below. Review each page of the Questionnaire then
                <a href="q_page1.php?pid=<?php echo  $_GET['pid']; ?>&own=1&own_completed=1&addtopat=1" onclick="return confirm('I certify that I have reviewed the entire Questionnaire for accuracy.')">CLICK HERE</a> to accept the changes.
            </div>
<?php
		}	  

		$sql = "select p1.*, s.analysis from dental_q_page1 p1 
				LEFT JOIN dental_q_sleep s ON s.patientid=p1.patientid
				where p1.patientid='".$_GET['pid']."'";

		$myarray = $db->getRow($sql);

		$q_page1id = st($myarray['q_page1id']);
		$exam_date = st($myarray['exam_date']);
		$ess = st($myarray['ess']);
		$tss = st($myarray['tss']);
		$analysis = $myarray['analysis'];
		$chief_complaint_text = st($myarray['chief_complaint_text']);
		$complaintid = st($myarray['complaintid']);
		$other_complaint = st($myarray['other_complaint']);
		$additional_paragraph = st($myarray['additional_paragraph']);
		$energy_level = st($myarray['energy_level']);
		$snoring_sound = st($myarray['snoring_sound']);
		$wake_night = st($myarray['wake_night']);
		$breathing_night = st($myarray['breathing_night']);
		$morning_headaches = st($myarray['morning_headaches']);
		$hours_sleep = st($myarray['hours_sleep']);
		$quit_breathing = st($myarray['quit_breathing']);
		$bed_time_partner = st($myarray['bed_time_partner']);
		$sleep_same_room = st($myarray['sleep_same_room']);
		$told_you_snore = st($myarray['told_you_snore']);
		$main_reason = st($myarray['main_reason']);
		$main_reason_other = st($myarray['main_reason_other']);
		$sleep_qual = st($myarray['sleep_qual']);

		if($complaintid <> '') {	
			$comp_arr1 = explode('~',$complaintid);
			foreach($comp_arr1 as $i => $val){
				$comp_arr2 = explode('|',$val);
				$compid[$i] = $comp_arr2[0];
				$compseq[$i] = $comp_arr2[1];
			}
		}
?>
	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />

	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css/questionnaire.css" type="text/css" />
	<link rel="stylesheet" href="css/form.css" type="text/css" />
	<script type="text/javascript" src="script/questionnaire.js" />
	<script type="text/javascript" src="script/wufoo.js"></script>

	<a name="top"></a>
	&nbsp;&nbsp;

	<?php include("includes/form_top.htm");?>

	<br />
	<br>
	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>

	<script type="text/javascript">
		function chk_chief(sel_val,comp_id)
		{
			fa = document.q_page1frm;
			same = 0;

			<?php 
				$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
				$complaint_my = $db->getResults($complaint_sql);
				
				foreach ($complaint_my as $complaint_myarray) {
			?>
					if(comp_id != <?php echo st($complaint_myarray['complaintid']);?>) {
						if(fa.complaint_<?php echo st($complaint_myarray['complaintid']);?>.value == sel_val && fa.complaint_<?php echo st($complaint_myarray['complaintid']);?>.value != '') {
							same = 1;
						}
					}
			<?php } ?>
			
			if(same == 1)
			{
				alert("Duplicate Sequence, Please Select another Sequence");
				eval("fa.complaint_" + comp_id).value = '';
				eval("fa.complaint_" + comp_id).focus();
			}
		}
	</script>

	<form id="q_page1frm"  class="q_form" name="q_page1frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post">
		<input type="hidden" name="q_page1sub" value="1" />
		<input type="hidden" name="ed" value="<?php echo $q_page1id;?>" />
		<input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />

		<div style="float:left; margin-left:10px;">
	        <input type="reset" value="Undo Changes" />
		</div>
		<div style="float:right;">
	        <input type="submit" name="q_pagebtn" value="Save" />
	        <input type="submit" name="q_pagebtn_proceed" value="Save And Proceed" />
		    &nbsp;&nbsp;&nbsp;
		</div>
		<div style="clear:both;"></div>

		<?php
		    $patient_sql = "SELECT * FROM dental_q_page1 WHERE parent_patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";    

			$pat_row = $db->getRow($patient_sql);
		    if($db->getNumberRows($patient_sql) == 0){
				$showEdits = false;
			} else {
				$showEdits = true;
			}
		?>

		<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		    <tr>
		        <td colspan="2">
		           Exam date: <input type="text" id="exam_date" name="exam_date" class="calendar" value="<?php echo  ($exam_date!='')?date('m/d/Y', strtotime($exam_date)):date('m/d/Y'); ?>" />
		           <script type="text/javascript">
		             var cal_exam = new calendar2(document.getElementById('exam_date'));
		           </script>
		        </td>
		    </tr>
		    <tr>
		        <td colspan="2" class="sub_head">
		           Additional Patient Information
		        </td>
		    </tr>
		    <tr>
				<td valign="top" class="frmhead">
			  		Baseline Epworth Sleepiness Score: <input type="text" id="ess" style="width:30px;" name="ess" onclick="window.location = 'q_sleep.php?pid=<?php echo $_GET['pid']; ?>';" readonly="readonly" value="<?php echo  $ess; ?>" />
                    <?php
						if($pat_row['ess']!='') {
                            showPatientValue('dental_q_page1', $_GET['pid'], 'ess', $pat_row['ess'], $ess, true, $showEdits);
						}
                    ?>
					<?php echo  $analysis; ?>
	  				<br /><br />
	  				Baseline Thornton Snoring Scale: <input type="text" id="tss" name="tss" style="width:30px;" onclick="window.location = 'q_sleep.php?pid=<?php echo $_GET['pid']; ?>';" readonly="readonly" value="<?php echo  $tss; ?>" />
                   
                    <?php
						if($pat_row['tss']!='') {
                            showPatientValue('dental_q_page1', $_GET['pid'], 'tss', $pat_row['tss'], $tss, true, $showEdits);
						}
                    ?>
					> 5 indicates snoring is significantly affecting quality of life.
					
					<?php
						$sleep_sql = "SELECT * FROM dental_q_sleep WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";
						if($db->getNumberRows($sleep_sql) == 0){
					?>
							<br />
							<a href="q_sleep.php?pid=<?php echo  $_GET['pid']; ?>">Complete sleep section</a>
					<?php } else { ?>
		 					<br />
                			<a href="#" onclick="$('#sleep_results').toggle(); return false;">View results</a>
							<div id="sleep_results" style="display:none;">
                  				<div style="width:48%; float:left;">
                        			<h3>Epworth</h3>

								    <?php
										$sql = "select * from dental_q_sleep where patientid='".$_GET['pid']."'";

										$myarray = $db->getRow($sql);
										$q_sleepid = st($myarray['q_sleepid']);
										$epworthid = st($myarray['epworthid']);
										$analysis = st($myarray['analysis']);

										if ($epworthid <> '') {
        									$epworth_arr1 = explode('~',$epworthid);
						        			foreach($epworth_arr1 as $i => $val)
						        			{
						                		$epworth_arr2 = explode('|',$val);
						                		$epid[$i] = $epworth_arr2[0];
						                		$epseq[$i] = $epworth_arr2[1];
						        			}
										}

                                        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
                                        $epworth_my = $db->getResults($epworth_sql);
                                        $epworth_number = count($epworth_my);
                                    
                                        foreach ($epworth_my as $epworth_myarray) {
                                            if(@array_search($epworth_myarray['epworthid'],$epid) === false) {
                                                $chk = '';
                                            } else {
                                                $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
                                            }
									?>
											<?php echo  $chk; ?>
											-	
											<?php echo st($epworth_myarray['epworth']);?>
											<br />
									<?php } ?>
									<?php echo $ess; ?> - Total
		  						</div>
								<div style="width:48%; float:left;">
									<h3>Thornton</h3>
									<?php
										$sql = "select * from dental_thorton where patientid='".$_GET['pid']."'";
										
										$myarray = $db->getRow($sql);
										$thortonid = st($myarray['thortonid']);
										$snore_1 = st($myarray['snore_1']);
										$snore_2 = st($myarray['snore_2']);
										$snore_3 = st($myarray['snore_3']);
										$snore_4 = st($myarray['snore_4']);
										$snore_5 = st($myarray['snore_5']);
									?>
									<?php echo  $snore_1; ?> - My snoring affects my relationship with my partner<br />
									<?php echo  $snore_2; ?> - My snoring causes my partner to be irritable or tired<br />
									<?php echo  $snore_3; ?> - My snoring requires us to sleep in separate rooms<br />
									<?php echo  $snore_4; ?> - My snoring is loud<br />
									<?php echo  $snore_5; ?> - My snoring affects people when I am sleeping away from home<br />
									<?php echo $tss; ?> - Total
								</div>
							</div>
                	<?php } ?>
				</td>
    		</tr>
    		<tr>
				<td valign="top" class="frmhead">
			        <label style="display:block;">What is the main reason you are seeking treatment?</label>
			        <textarea style="width:400px; height:100px;" name="chief_complaint_text" id="chief_complain_text"><?php echo  $chief_complaint_text; ?></textarea>
                    <?php
                        showPatientValue('dental_q_page1', $_GET['pid'], 'chief_complaint_text', $pat_row['chief_complaint_text'], $chief_complaint_text, true, $showEdits);
                    ?>
				</td>
    		</tr>
    		<tr>
		        <td valign="top" class="frmhead">
		        	<ul>
		                <li id="foli8" class="complex">	
							<span class="form_info">Subjective</span>
		                    <br />
		                    <label class="desc" id="title0" for="Field0">
	                        	Other Complaints
	                            <?php
	                                showPatientValue('dental_q_page1', $_GET['pid'], 'complaintid', $pat_row['complaintid'], $complaintid, false, $showEdits);
	                            ?>
                    		</label>
		                    <?php 
								$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
								
								$complaint_my = $db->getResults($complaint_sql);
								$complaint_number = count($complaint_my);
							?>
		                    <span class="form_info">
								Please check any other complaints below.
		                    </span>
                    		<br />
                    		<?php 
        						$patcomp_arr1 = explode('~',$pat_row['complaintid']);

						        foreach($patcomp_arr1 as $i => $val)
						        {
					                $patcomp_arr2 = explode('|',$val);
					                $patcompid[$i] = $patcomp_arr2[0];
					                $patcompseq[$i] = (!empty($patcomp_arr2[1]) ? $patcomp_arr2[1] : '');
						        }

								foreach ($complaint_my as $complaint_myarray)
								{
									if(@array_search($complaint_myarray['complaintid'],$compid) === false) {
										$chk = '';
									} else {
										$chk = !empty($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
									}

					        		if(@array_search($complaint_myarray['complaintid'],$patcompid) === false) {
                                        $patchk = '';
                                    } else {
                                        $patchk = 1;
                                    }	
							?>
                    			<div style="width:48%;float:left;">
                        			<span>
			    						<input type="checkbox" name="complaint_<?php echo st($complaint_myarray['complaintid']);?>" id="complaint_<?php echo st($complaint_myarray['complaintid']);?>" value="1" <?php if($chk == 1) echo 'checked="checked"'; ?> />
										<?php if($pat_row['complaintid'] !=  $complaintid && $showEdits){ ?>
											<input type="checkbox" <?php if($patchk == 1) echo 'checked="checked"'; ?> disabled="disabled" style="background:#c333;" />
										<?php } ?>
                            			&nbsp;&nbsp;
                            			<?php echo st($complaint_myarray['complaint']);?>
										<br />&nbsp;
                        			</span>
                    			</div>
                    		<?php } ?>
                    			<div style="width:48%;float:left;">
                        			<span>
										<?php
                                            if(@array_search(0,$compid) === false) {
                                                $chk = '';
                                            } else {
                                                $chk = (!empty($compseq[@array_search(0,$compid)]) ? $compseq[@array_search(0,$compid)] : '');
                                            }
										?>
			                            <input type="checkbox" id="complaint_0" onclick="chk_other_comp()" name="complaint_0" value="1" <?php if($chk == 1) echo 'checked="checked"'; ?> />
			                            &nbsp;&nbsp;
			                            Other<br />&nbsp;
                        			</span>
                    			</div>
			                    <div id="other_complaints">
			                        <span>
			                        	<span style="color:#000000; padding-top:0px;">
			                            	Additional Complaints<br />
			                            </span>
			                            (Enter Each Complaint on Different Line)<br />
			                            <textarea name="other_complaint" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_complaint;?></textarea>
			                            <?php
			                                showPatientValue('dental_q_page1', $_GET['pid'], 'other_complaint', $pat_row['other_complaint'], $other_complaint, true, $showEdits);
			                            ?>
			                        </span>
			                    </div>
                    		<br />
                		</li>
           			</ul>
					<script type="text/javascript">chk_other_comp();</script>
				</td>
			</tr>
		    <tr>
		        <td valign="top" class="frmhead">
		        	<ul>
		                <li id="foli8" class="complex">	
		                    <label class="desc" id="title0" for="Field0">Subjective Signs/Symptoms</label>
		                    <div>
		                    	<span class="full">
		                        	<table width="100%" cellpadding="3" cellspacing="1" border="0"> 
		                            	<tr>
		                                	<td valign="top" width="60%">
		                                    	Rate your overall energy level 0 -10 (10 being the highest) 
                                    		</td>
                                    		<td valign="top">
                                    			<select name="energy_level" id="energy_level" class="field text addr tbox" style="width:150px;">
                                            		<option value=""></option>
                                            		<?php for($i=0; $i<11; $i++){ ?>
                                                		<option value="<?php echo $i;?>" <?php if($energy_level!='' && $energy_level == $i) echo " selected";?>><?php echo $i;?></option>
                                            		<?php } ?>
                                        		</select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'energy_level', $pat_row['energy_level'], $energy_level, true, $showEdits);
					                            ?>
                                    		</td>
                                		</tr>
                                        <tr>
	                                        <td valign="top">
	                                        	Rate your sleep quality 0-10 (10 being the highest)
	                                    	</td>
		                                    <td valign="top">
		                                        <select name="sleep_qual" id="sleep_qual" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <?php for($i=0; $i<11; $i++) { ?>
		                                                <option value="<?php echo $i;?>" <?php if($sleep_qual!=''&&$sleep_qual == $i){echo " selected";}?>><?php echo $i;?></option>
		                                            <?php } ?>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'sleep_qual', $pat_row['sleep_qual'], $sleep_qual, true, $showEdits);
					                            ?>
                                    		</td>
                                		</tr>
                                 		<tr>
		                                	<td valign="top">
		                                    	Have you been told you snore?
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="told_you_snore" id="told_you_snore" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <option value="Yes" <?php if($told_you_snore== 'Yes') echo " selected";?>>
		                                            	Yes
		                                            </option>
		                                            <option value="No" <?php if($told_you_snore == 'No') echo " selected";?>>
		                                            	No
		                                            </option>
		                                            <option value="Sometimes" <?php if($told_you_snore == 'Sometimes') echo " selected";?>>
		                                            	Sometimes
		                                            </option>
		                                            <option value="Don't know" <?php if($told_you_snore == "Don't know") echo " selected";?>>
		                                                Don't know
		                                            </option>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'told_you_snore', $pat_row['told_you_snore'], $told_you_snore, true, $showEdits);
					                            ?>
                                    		</td>
                                		</tr>
		                                <tr>
		                                	<td valign="top">
		                                    	Rate the sound of your snoring 0 -10 (10 being the highest) 
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="snoring_sound" id="snoring_sound" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <?php for($i=0; $i<11; $i++) { ?>
		                                                <option value="<?php echo $i;?>" <?php if($snoring_sound == $i && $snoring_sound!='') echo " selected";?>><?php echo $i;?></option>
		                                            <?php } ?>
		                                            <option value="Don't know">Don't know</option>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'snoring_sound', $pat_row['snoring_sound'], $snoring_sound, true, $showEdits);
					                            ?>
		                                    </td>
		                                </tr>
		                                <tr>
		                                	<td valign="top">
		                                    	On average how many times per night do you wake up?  
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="wake_night" id="wake_night" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <?php for($i=0; $i<11; $i++) { ?>
		                                                <option value="<?php echo $i;?>" <?php if($wake_night!='' && $wake_night == $i) echo " selected";?>><?php echo $i;?></option>
		                                            <?php } ?>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'wake_night', $pat_row['wake_night'], $wake_night, true, $showEdits);
					                            ?>
		                                    </td>
		                                </tr>
                                        <tr>
		                                	<td valign="top">
		                                    	On average how many hours of sleep do you get per night?
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="hours_sleep" id="hours_sleep" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <?php for($i=0; $i<16; $i++) { ?>
		                                                <option value="<?php echo $i;?>" <?php if($hours_sleep == $i && $hours_sleep != '') echo " selected";?>><?php echo $i;?></option>
		                                            <?php }?>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'hours_sleep', $pat_row['hours_sleep'], $hours_sleep, true, $showEdits);
					                            ?>
		                                    </td>
                                		</tr>
                                        <tr>
	                                        <td valign="top">
	                                       		How often do you wake up with morning headaches?
	                                    	</td>
	                                    	<td valign="top">
												<select name="morning_headaches" id="morning_headaches" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <option value="0" <?php if($morning_headaches == '0') echo " selected";?>>
		                                                Everyday
		                                            </option>
		                                            <option value="1" <?php if($morning_headaches == '1') echo " selected";?>>
	                                                	Often
	                                            	</option>
		                                            <option value="2" <?php if($morning_headaches == '2') echo " selected";?>>
		                                                Sometimes
		                                            </option>
		                                            <option value="3" <?php if($morning_headaches == '3') echo " selected";?>>
		                                                Rarely
		                                            </option>
		                                            <option value="4" <?php if($morning_headaches == '4') echo " selected";?>>
		                                                Never
		                                            </option>
                                        		</select>          
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'morning_headaches', $pat_row['morning_headaches'], $morning_headaches, true, $showEdits);
					                            ?>
		                                    </td>
		                                </tr>
                                		<tr>
		                                	<td valign="top">
		                                    	Do you have a bed time partner?
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="bed_time_partner" id="bed_time_partner" class="field text addr tbox" style="width:150px;" onchange="disableenable()">
		                                            <option value=""></option>
		                                            <option value="Yes" <?php if($bed_time_partner== 'Yes') echo " selected";?>>
		                                            	Yes
		                                            </option>
		                                            <option value="No" <?php if($bed_time_partner == 'No') echo " selected";?>>
		                                            	No
		                                            </option>
		                                            <option value="Sometimes" <?php if($bed_time_partner == 'Sometimes') echo " selected";?>>
		                                            	Sometimes
		                                            </option>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'bed_time_partner', $pat_row['bed_time_partner'], $bed_time_partner, true, $showEdits);
					                            ?>
                                    		</td>
                                		</tr>
										<tr>
		                                	<td valign="top">
		                                    	If yes do they sleep in the same room?
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="sleep_same_room" id="sleep_same_room" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <option value="Yes" <?php if($sleep_same_room== 'Yes') echo " selected";?>>
		                                            	Yes
		                                            </option>
		                                            <option value="No" <?php if($sleep_same_room == 'No') echo " selected";?>>
		                                            	No
		                                            </option>
		                                            <option value="Sometimes" <?php if($sleep_same_room == 'Sometimes') echo " selected";?>>
		                                            	Sometimes
		                                            </option>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'sleep_same_room', $pat_row['sleep_same_room'], $sleep_same_room, true, $showEdits);
					                            ?>
		                                    </td>
		                                </tr>
		                                <tr>
		                                	<td valign="top">
		                                    	How many times per night does your bedtime partner notice you quit breathing?
		                                    </td>
		                                    <td valign="top">
		                                    	<select name="quit_breathing" id="quit_breathing" class="field text addr tbox" style="width:150px;">
		                                            <option value=""></option>
		                                            <option value="Several times per night" <?php if($quit_breathing== 'Several times per night') echo " selected";?>>
		                                            	Several times per night
		                                            </option>
		                                            <option value="One time per night" <?php if($quit_breathing == 'One time per night') echo " selected";?>>
		                                            	One time per night
		                                            </option>
		                                            <option value="Several times per week" <?php if($quit_breathing == 'Several times per week') echo " selected";?>>
		                                            	Several times per week
		                                            </option>
		                                            <option value="Occasionally" <?php if($quit_breathing == 'Occasionally') echo " selected";?>>
		                                            	Occasionally
		                                            </option>
		                                            <option value="Seldom" <?php if($quit_breathing == 'Seldom') echo " selected";?>>
		                                            	Seldom
		                                            </option>
		                                            <option value="Never" <?php if($quit_breathing == 'Never') echo " selected";?>>
		                                            	Never
		                                            </option>
		                                        </select>
					                            <?php
					                                showPatientValue('dental_q_page1', $_GET['pid'], 'quit_breathing', $pat_row['quit_breathing'], $quit_breathing, true, $showEdits);
					                            ?>
		                                    </td>
		                                </tr>
									</table>
                        		</span>
                    		</div>
                    		<br />      
		                </li>
					</ul>
				</td>
			</tr>  	   
		</table>

		<div style="float:left; margin-left:10px;">
		    <input type="reset" value="Undo Changes" />
		</div>
		<div style="float:right;">
	        <input type="submit" name="q_pagebtn" value="Save" />
	        <input type="submit" name="q_pagebtn_proceed" value="Save And Proceed" />
		    &nbsp;&nbsp;&nbsp;
		</div>
		<div style="clear:both;"></div>
	</form>
	<br />
		<?php include("includes/form_bottom.htm"); ?>
	<br />
	<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup"></div>

	<br /><br />	

<?php
	} //end symptom status check
} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}
?>

<?php include "includes/bottom.htm";?>
