<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/patient_info.php';

$patientId = intval($_GET['pid']);
$docId = intval($_SESSION['docid']);

	if ($patient_info) {
		if($_GET['own']==1){
			$c_sql = "SELECT patientid
				FROM dental_patients
				WHERE (
						symptoms_status = 1 ||
						sleep_status = 1 ||
						treatments_status = 1 ||
						history_status = 1
					)
					AND patientid = '$patientId'
					AND docid = '$docId'";
			
			$changed = $db->getNumberRows($c_sql);
			$own_sql = "UPDATE dental_patients
				SET symptoms_status = 2, sleep_status = 2, treatments_status = 2, history_status = 2
				WHERE patientid = '$patientId'
					AND docid = '$docId'";
			$db->query($own_sql);
			if($_GET['own_completed']==1){
				$q1_sql = "SELECT q_page1id
					FROM dental_q_page1
					WHERE patientid = '$patientId'";

				if($db->getNumberRows($q1_sql) == 0){
					$ed_sql = "INSERT INTO dental_q_page1 SET exam_date=now(), patientid='$patientId'";
					$db->query($ed_sql);
				}else{
					$ed_sql = "UPDATE dental_q_page1 SET exam_date=now() WHERE patientid='$patientId'";
					$db->query($ed_sql);
				}
			}
?>
            <script type="text/javascript">
				<?php if($changed>0){ ?>
					alert("Warning! Patient has made changes to the Questionnaire. Please review the patient's ENTIRE questionnaire for changes.");
				<?php } ?>
                window.location = 'q_page2.php?pid=<?= $patientId ?>&addtopat=1';
            </script>
<?php
            trigger_error("Die called", E_USER_ERROR);
		}
?>

<script type="text/javascript" src="js/q_page2.js"></script>
<script type="text/javascript" src="/manage/js/form_top.js"></script>
<?php
	if($_POST['q_page2sub'] == 1) {
		$polysomnographic = $_POST['polysomnographic'];
		$sleep_center_name_text = $_POST['sleep_center_name_text'];
		$sleep_study_on = $_POST['sleep_study_on'];
		$confirmed_diagnosis = $_POST['confirmed_diagnosis'];
		$rdi = $_POST['rdi'];
		$ahi = $_POST['ahi'];
		$cpap = $_POST['cpap'];
		$cur_cpap = $_POST['cur_cpap'];
		$intolerance = $_POST['intolerance'];
		$other_intolerance = $_POST['other_intolerance'];
		$other_therapy = $_POST['other_therapy'];
		$other = $_POST['other'];
		$other_chk = $_POST['other_chk'];
		$affidavit = $_POST['affidavit'];
		$type_study = $_POST['type_study'];
		$nights_wear_cpap = $_POST['nights_wear_cpap'];
		$percent_night_cpap = $_POST['percent_night_cpap'];
		$custom_diagnosis = $_POST['custom_diagnosis'];
		$sleep_study_by = $_POST['sleep_study_by'];
		$triedquittried = $_POST['triedquittried'];
		$timesovertime = $_POST['timesovertime'];
		$dd_wearing = $_POST['dd_wearing'];
		$dd_prev = $_POST['dd_prev'];
		$dd_otc = $_POST['dd_otc'];
		$dd_fab = $_POST['dd_fab'];
		$dd_who = $_POST['dd_who'];
		$dd_experience = $_POST['dd_experience'];
	   	$surgery = $_POST['surgery'];
		$num_surgery = $_POST['num_surgery'];
		$int_arr = '';

		if(is_array($intolerance)) {
			foreach($intolerance as $val){
				if(trim($val) <> '') $int_arr .= trim($val).'~';
			}
		}
	
		if($int_arr != '') $int_arr = '~'.$int_arr;
		
		$other_arr = '';
		if(is_array($other)) {
			foreach($other as $val) {
				if(trim($val) <> '') $other_arr .= trim($val).'~';
			}
		}
	
		if($other_chk != '') $other_arr .= 'Other~';
		
		if($other_arr != '') $other_arr = '~'.$other_arr;
			
		if($polysomnographic == '') $polysomnographic = 0;	
	
		if($_POST['ed'] == '') {
			$ins_sql = " insert into dental_q_page2 set 
			patientid = '".$db->escape($_GET['pid'])."',
			polysomnographic = '".$db->escape($polysomnographic)."',
			sleep_center_name_text = '".$db->escape($sleep_center_name_text)."',
			sleep_study_on = '".$db->escape($sleep_study_on)."',
			confirmed_diagnosis = '".$db->escape($confirmed_diagnosis)."',
			rdi = '".$db->escape($rdi)."',
			ahi = '".$db->escape($ahi)."',
			cpap = '".$db->escape($cpap)."',
			cur_cpap = '".$db->escape($cur_cpap)."',
			intolerance = '".$db->escape($int_arr)."',
			other_intolerance = '".$db->escape($other_intolerance)."',
			other_therapy = '".$db->escape($other_therapy)."',
			other = '".$db->escape($other_arr)."',
			affidavit = '".$db->escape($affidavit)."',
			type_study = '".$db->escape($type_study)."',
			nights_wear_cpap = '".$db->escape($nights_wear_cpap)."',
			percent_night_cpap = '".$db->escape($percent_night_cpap)."',
			custom_diagnosis = '".$db->escape($custom_diagnosis)."',
			sleep_study_by = '".$db->escape($sleep_study_by)."',
			triedquittried = '".$db->escape($triedquittried)."',
			timesovertime = '".$db->escape($timesovertime)."',
			dd_wearing = '".$db->escape($dd_wearing)."',
			dd_prev = '".$db->escape($dd_prev)."',
			dd_otc = '".$db->escape($dd_otc)."',
			dd_fab = '".$db->escape($dd_fab)."',
			dd_who = '".$db->escape($dd_who)."',
			dd_experience = '".$db->escape($dd_experience)."',
			surgery = '".$db->escape($surgery)."',
			userid = '".$db->escape($_SESSION['userid'])."',
			docid = '".$db->escape($_SESSION['docid'])."',
			adddate = now(),
			ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
			
			$db->query($ins_sql);
			$msg = "Added Successfully";
            if(isset($_POST['q_pagebtn_proceed'])){
?>
                <script type="text/javascript">
                    window.location='q_page3.php?pid=<?= $patientId ?>&msg=<?php echo $msg;?>';
                </script>
<?php
            } else {
?>
				<script type="text/javascript">
					window.location='<?php echo $_POST['goto_p']?>.php?pid=<?= $patientId ?>&msg=<?php echo $msg;?>';
				</script>
<?php
			}
			trigger_error("Die called", E_USER_ERROR);
		} else {
			$ed_sql = " update dental_q_page2 set 
			polysomnographic = '".$db->escape($polysomnographic)."',
			sleep_center_name_text = '".$db->escape($sleep_center_name_text)."',
			sleep_study_on = '".$db->escape($sleep_study_on)."',
			confirmed_diagnosis = '".$db->escape($confirmed_diagnosis)."',
			rdi = '".$db->escape($rdi)."',
			ahi = '".$db->escape($ahi)."',
			cpap = '".$db->escape($cpap)."',
	                cur_cpap = '".$db->escape($cur_cpap)."',
			intolerance = '".$db->escape($int_arr)."',
			other_intolerance = '".$db->escape($other_intolerance)."',
			other_therapy = '".$db->escape($other_therapy)."',
			other = '".$db->escape($other_arr)."',
			affidavit = '".$db->escape($affidavit)."',
			type_study = '".$db->escape($type_study)."',
			nights_wear_cpap = '".$db->escape($nights_wear_cpap)."',
			percent_night_cpap = '".$db->escape($percent_night_cpap)."',
			custom_diagnosis = '".$db->escape($custom_diagnosis)."',
			sleep_study_by = '".$db->escape($sleep_study_by)."',
			triedquittried = '".$db->escape($triedquittried)."',
			timesovertime = '".$db->escape($timesovertime)."',
	                dd_wearing = '".$db->escape($dd_wearing)."',
	                dd_prev = '".$db->escape($dd_prev)."',
	                dd_otc = '".$db->escape($dd_otc)."',
	                dd_fab = '".$db->escape($dd_fab)."',
	                dd_who = '".$db->escape($dd_who)."',
	                dd_experience = '".$db->escape($dd_experience)."',
			surgery = '".$db->escape($surgery)."'
			where q_page2id = '".$db->escape($_POST['ed'])."'";
		
			$db->query($ed_sql);

			for ($i=0; $i<$num_surgery; $i++) {
				if($_POST['surgery_id_'.$i]==0) {
					if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
						$s = "INSERT INTO dental_q_page2_surgery (patientid, surgery_date, surgery, surgeon) VALUES ('".$db->escape($_REQUEST['pid'])."', '".$db->escape($_POST['surgery_date_'.$i])."','".$db->escape($_POST['surgery_'.$i])."','".$db->escape($_POST['surgeon_'.$i])."')";
					}
				} else {
					if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
						$s = "UPDATE dental_q_page2_surgery SET surgery_date='".$db->escape($_POST['surgery_date_'.$i])."', surgery='".$db->escape($_POST['surgery_'.$i])."', surgeon='".$db->escape($_POST['surgeon_'.$i])."' WHERE id='".$db->escape($_POST['surgery_id_'.$i])."'";
					} else {
						$s = "DELETE FROM dental_q_page2_surgery WHERE id='".$db->escape($_POST['surgery_id_'.$i])."'";
					}
				}	
				$db->query($s);
			}	
			$msg = "Edited Successfully";
            if(isset($_POST['q_pagebtn_proceed'])){
?>
                <script type="text/javascript">
                    window.location = 'q_page3.php?pid=<?= $patientId ?>&msg=<?php echo $msg;?>';
                </script>
<?php
			} else {
?>
				<script type="text/javascript">
					window.location = '<?php echo $_POST['goto_p']?>.php?pid=<?= $patientId ?>&msg=<?php echo $msg;?>';
				</script>
<?php
			}
			trigger_error("Die called", E_USER_ERROR);
		}
	}	

	$pat_sql = "select * from dental_patients where patientid='$patientId'";

	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
	if($pat_myarray['patientid'] == '') {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}
    $exist_sql = "SELECT symptoms_status, sleep_status, treatments_status, history_status FROM dental_patients WHERE patientid='$patientId'";
    
    $exist_row = $db->getRow($exist_sql);
    if($exist_row['symptoms_status'] == 0 && $exist_row['sleep_status'] == 0 && $exist_row['treatments_status'] == 0 && $exist_row['history_status'] == 0)
    {
?>
        <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It has not been edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please
            <a href="q_page2.php?pid=<?= $patientId ?>&own=1&addtopat=1">click here</a>.
        </div>
<?php
    } elseif($exist_row['symptoms_status'] != 2 && $exist_row['sleep_status'] != 2 && $exist_row['treatments_status'] != 2 && $exist_row['history_status'] != 2 &&
            $exist_row['symptoms_status'] != 3 && $exist_row['sleep_status'] != 3 && $exist_row['treatments_status'] != 3 && $exist_row['history_status'] != 3) {
?>
                <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It is currently being edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please
                    <a href="q_page2.php?pid=<?= $patientId ?>&own=1&addtopat=1">click here</a>.
                </div>
<?php } else {
		if($exist_row['history_status'] == 2 || $exist_row['sleep_status'] == 2 || $exist_row['history_status'] == 2 || $exist_row['history_status'] == 2){
?>          
			<div style="width:500px; margin:30px auto 0 auto;">This section has been edited by the patient. All patient changes are visible below. Review each page of the Questionnaire then
                <a href="q_page1.php?pid=<?= $patientId ?>&own=1&own_completed=1&addtopat=1" onclick="return confirm('I certify that I have reviewed the entire Questionnaire for accuracy.')">CLICK HERE</a> to accept the changes.
            </div>
<?php
		}
		$sql = "select * from dental_q_page2 where patientid='$patientId'";
		
		$myarray = $db->getRow($sql);
		$q_page2id = st($myarray['q_page2id']);
		$polysomnographic = st($myarray['polysomnographic']);
		$sleep_center_name_text = st($myarray['sleep_center_name_text']);
		$sleep_study_on = st($myarray['sleep_study_on']);
		$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
		$rdi = st($myarray['rdi']);
		$ahi = st($myarray['ahi']);
		$cpap = st($myarray['cpap']);
		$cur_cpap = st($myarray['cur_cpap']);
		$intolerance = st($myarray['intolerance']);
		$other_intolerance = st($myarray['other_intolerance']);
		$other_therapy = st($myarray['other_therapy']);
		$other = st($myarray['other']);
		$affidavit = st($myarray['affidavit']);
		$type_study = st($myarray['type_study']);
		$nights_wear_cpap = st($myarray['nights_wear_cpap']);
		$percent_night_cpap = st($myarray['percent_night_cpap']);
		$custom_diagnosis = st($myarray['custom_diagnosis']);
		$sleep_study_by = st($myarray['sleep_study_by']);
		$triedquittried = st($myarray['triedquittried']);
		$timesovertime = st($myarray['timesovertime']);
		$dd_wearing = st($myarray['dd_wearing']);
		$dd_prev = st($myarray['dd_prev']);
		$dd_otc = st($myarray['dd_otc']);
		$dd_fab = st($myarray['dd_fab']);
		$dd_who = st($myarray['dd_who']);
		$dd_experience = st($myarray['dd_experience']);
		$surgery = st($myarray['surgery']);

		if($cpap == '') $cpap = 'No';
?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css/questionnaire.css" type="text/css" />
	<link rel="stylesheet" href="css/form.css" type="text/css" />
	<script type="text/javascript" src="script/questionnaire.js" />

	<a name="top"></a>
	&nbsp;&nbsp;

	<?php include("includes/form_top.htm");?>

	<br />
	<br>
	<div align="center" class="red">
		<b><?php echo $_GET['msg'];?></b>
	</div>

	<form id="q_page2frm" class="q_form" name="q_page2frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?= $patientId ?>" method="post" onsubmit="return q_page2abc(this)">
		<input type="hidden" name="q_page2sub" value="1" />
		<input type="hidden" name="ed" value="<?php echo $q_page2id;?>" />
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
	        $patient_sql = "SELECT * FROM dental_q_page2 WHERE parent_patientid='$patientId'";
	        
	        $pat_row = $db->getRow($patient_sql);
	        if($db->getNumberRows($patient_sql) == 0){
				$showEdits = false;
	        } else {
				$showEdits = true;
			}
		?>

		<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		    <tr>
		        <td colspan="2" class="sub_head">
		           Sleep Center Evaluation
		        </td>
		    </tr>
		    <tr>
		        <td valign="top" class="frmhead">
		        	<ul>
		                <li id="foli8" class="complex">	
							<label class="desc" id="title0" for="Field0">Sleep Studies</label>
		                    <div>
		                        <span>
									Have you had a sleep study
									<input type="radio" class="polysomnographic_radio" id="polysomnographic_yes" name="polysomnographic" value="1" <?php if($polysomnographic == '1') echo " checked";?> onclick="chk_poly()" />
		                            	Yes
		                            <input type="radio" class="polysomnographic_radio" name="polysomnographic" value="0" <?php if($polysomnographic == '0') echo " checked";?> onclick="chk_poly()"  />
		                            	No
								    <?php
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'polysomnographic', $pat_row['polysomnographic'], $polysomnographic, true, $showEdits, 'radio');
		                            ?>
								</span>
		                    </div>
                    		<br />
		                    <div class="poly_options">
		                    	<span>
		                        	If yes where 
									<input id="sleep_center_name_text" name="sleep_center_name_text" type="text" class="field text addr tbox" value="<?php echo $sleep_center_name_text;?>"  maxlength="255" style="width:225px;" /> 
		                            <?php
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'sleep_center_name_text', $pat_row['sleep_center_name_text'], $sleep_center_name_text, true, $showEdits);
		                            ?>
									Date
		                            &nbsp;&nbsp;
		                            <input id="sleep_study_on" name="sleep_study_on" type="text" class="field text addr tbox" value="<?php echo $sleep_study_on;?>"  maxlength="10" style="width:75px;" /> 
		                            <?php   
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'sleep_study_on', $pat_row['sleep_study_on'], $sleep_study_on, true, $showEdits);
		                            ?>
								</span>
		                    </div>
							<br /><br />
                		</li>
            		</ul>
           			<script>chk_poly();</script>
        		</td>
    		</tr>
		    <tr>
		        <td valign="top" class="frmhead">
		        	<ul>
		                <li id="foli8" class="complex">	
		                    <label class="desc" id="title0" for="Field0">
		                        CPAP Intolerance
		                    </label>
		                    <div>
		                        <span>
		                        	Have you tried CPAP?
		                            <input type="radio" class="cpap_radio" id="cpap" name="cpap" value="Yes" <?php if($cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
		                            Yes
		                            <input type="radio" class="cpap_radio" name="cpap" value="No" <?php if($cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
		                            No
								    <?php
									showPatientValue('dental_q_page2', $_GET['pid'], 'cpap', $pat_row['cpap'], $cpap, true, $showEdits, 'radio');
								    ?>
								</span>
                   			</div>
		                    <div class="cpap_options">
		                        <span>
		                            Are you currently using CPAP?
		                            <input type="radio" class="cur_cpap_radio" id="cur_cpap" name="cur_cpap" value="Yes" <?php if($cur_cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
		                            	Yes
									<input type="radio" class="cur_cpap_radio" name="cur_cpap" value="No" <?php if($cur_cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
		                            	No
		                            <?php
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'cur_cpap', $pat_row['cur_cpap'], $cur_cpap, true, $showEdits, 'radio');
		                            ?>
								</span>
		                    </div>
							<div class="cpap_options2">
							    <span>
                                    If currently using CPAP, how many nights / week do you wear it?
                                    <input id="nights_wear_cpap" name="nights_wear_cpap" type="text" class="field text addr tbox" value="<?php echo $nights_wear_cpap;?>" maxlength="255" style="width:225px;" />
		                            <?php
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'nights_wear_cpap', $pat_row['nights_wear_cpap'], $nights_wear_cpap, true, $showEdits);
		                            ?>
									<br />&nbsp;
                                </span>
                            </div>
							<div class="cpap_options2">
                        		<span>
                                    How many hours each night do you wear it?
                                    <input id="percent_night_cpap" name="percent_night_cpap" type="text" class="field text addr tbox" value="<?php echo $percent_night_cpap;?>" maxlength="255" style="width:225px;" />
				                    <?php
                                		showPatientValue('dental_q_page2', $_GET['pid'], 'percent_night_cpap', $pat_row['percent_night_cpap'], $percent_night_cpap, true, $showEdits);
                            		?>
									<br />&nbsp;
                                </span>
                            </div>
							<div id="cpap_options" class="cpap_options">
                        		<span>
									What are your chief complaints about CPAP?
		                            <?php
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'intolerance', $pat_row['intolerance'], $intolerance, false, $showEdits);
		                            ?>
									<br />
                            		<?php
										$intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
										$intolerance_my = $db->getResults($intolerance_sql);
										foreach ($intolerance_my as $intolerance_myarray) {
									?>
											<input type="checkbox" id="intolerance<?php echo st($intolerance_myarray['intoleranceid'])?>" name="intolerance[]" value="<?php echo st($intolerance_myarray['intoleranceid'])?>" <?php if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
											<?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
		  										<input type="checkbox" disabled="disabled" <?php if(strpos($pat_row['intolerance'],'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
											<?php } ?>
		                                	&nbsp;&nbsp;
		                                	<?php echo st($intolerance_myarray['intolerance']);?><br />
									<?php } ?>
										<input type="checkbox" id="cpap_other" name="intolerance[]" value="0" <?php if(strpos($intolerance,'~'.st('0~')) === false) {} else { echo " checked";}?> onclick="chk_cpap_other()" /> 
                                		<?php if($intolerance != $pat_row['intolerance'] && $showEdits) { ?>
                                            <input type="checkbox" disabled="disabled" <?php if(strpos($pat_row['intolerance'],'~'.st('0~')) === false) {} else { echo " checked";}?> />
                                		<?php } ?>
										&nbsp;&nbsp; Other<br />
                       			</span>
							</div>
		                    <br />
		                    <div class="cpap_options">
		                        <span class="cpap_other_text">
		                        	<span style="color:#000000; padding-top:0px;">
		                            	Other Items<br />
		                            </span>
		                            (Enter Each on Different Line)<br />
		                            <textarea name="other_intolerance" class="field text addr tbox" style="width:650px; height:100px;" ><?php echo $other_intolerance;?></textarea>
									<br />&nbsp;
		                        </span>
		                    </div>			
							<script type="text/javascript">
								chk_cpap();
								chk_cpap_other();
							</script>
                		</li>
            		</ul>
           		</td>
    		</tr>
	        <tr>
		        <td valign="top" class="frmhead">
		            <ul>
		                <li id="foli8" class="complex">
		                    <label class="desc" id="title0" for="Field0">
		                      	Dental Devices 
		                    </label>
		                    <div>
								<span>
									Are you currently wearing a dental device specifically designed to treat sleep apnea?
		                            <input type="radio" class="dd_wearing_radio" id="dd_wearing" name="dd_wearing" value="Yes" <?php if($dd_wearing == 'Yes') echo " checked";?> onclick="chk_dd()"  />
		                            	Yes
									<input type="radio" class="dd_wearing_radio" name="dd_wearing" value="No" <?php if($dd_wearing == 'No') echo " checked";?> onclick="chk_dd()"  />
		                            	No
		                            <?php
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_wearing', $pat_row['dd_wearing'], $dd_wearing, true, $showEdits, 'radio');
		                            ?>
								</span>
			    			</div>
			    			<div> 
								<span>
					 			 	Have you previously tried a dental device for sleep apnea treatment?		
		                            <input type="radio" class="dd_prev_radio" id="dd_prev" name="dd_prev" value="Yes" <?php if($dd_prev == 'Yes') echo " checked";?> onclick="chk_dd()"  />
		                            	Yes
									<input type="radio" class="dd_prev_radio" name="dd_prev" value="No" <?php if($dd_prev == 'No') echo " checked";?> onclick="chk_dd()"  />
		                            	No
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_prev', $pat_row['dd_prev'], $dd_prev, true, $showEdits, 'radio');
		                            ?>
								</span>
			    			</div>
						    <div class="dd_options">
								<span>
									Was it over-the-counter (OTC)? 	
		                            <input type="radio" class="dd_otc_radio" id="dd_otc" name="dd_otc" value="Yes" <?php if($dd_otc == 'Yes') echo " checked";?> />
		                            	Yes
									<input type="radio" class="dd_otc_radio" name="dd_otc" value="No" <?php if($dd_otc == 'No') echo " checked";?> />
		                            	No
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_otc', $pat_row['dd_otc'], $dd_otc, true, $showEdits, 'radio');
		                            ?>
								</span>
						    </div>
						    <div class="dd_options">
								<span>
									Was it fabricated by a dentist?
		                            <input type="radio" class="dd_fab_radio" id="dd_fab" name="dd_fab" value="Yes" <?php if($dd_fab == 'Yes') echo " checked";?> />
		                            	Yes
									<input type="radio" class="dd_fab_radio" name="dd_fab" value="No" <?php if($dd_fab == 'No') echo " checked";?> />
		                            	No
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_fab', $pat_row['dd_fab'], $dd_fab, true, $showEdits, 'radio');
		                            ?>
								<span>
						    </div>
						    <div class="dd_options">
								<span>
									Who <input type="text" id="dd_who" name="dd_who" value="<?php echo  $dd_who; ?>" />
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_who', $pat_row['dd_who'], $dd_who, true, $showEdits);
		                            ?>
								</span>
					 	    </div>
						    <div class="dd_options">
								<span>
									Describe your experience<br />
									<textarea id="dd_experience" class="field text addr tbox" style="width:650px; height:100px;" name="dd_experience"><?php echo  $dd_experience; ?></textarea>
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_experience', $pat_row['dd_experience'], $dd_experience, true, $showEdits);
		                            ?>
								</span>
						    </div>
							
							<script type="text/javascript">chk_dd();</script>
				</td>
        	</tr>
        	<tr>
		        <td valign="top" class="frmhead">
		            <ul>
		                <li id="foli8" class="complex">
		                    <label class="desc" id="title0" for="Field0">Surgery</label>
		                    <div>
		                        <span>
									Have you had surgery for snoring or sleep apnea?
		                            <input type="radio" class="surgery_radio" id="surgery" name="surgery" value="Yes" <?php if($surgery == 'Yes') echo " checked";?> onclick="chk_s()" />
		                            	Yes
									<input type="radio" class="surgery_radio" name="surgery" value="No" <?php if($surgery == 'No') echo " checked";?> onclick="chk_s()" />
		                            	No
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'surgery', $pat_row['surgery'], $surgery, true, $showEdits, 'radio');
		                            ?>
								</span>
		    				</div>
		    				<div class="s_options">
                        		<span>
									Please list any nose, palatal, throat, tongue, or jaw surgeries you have had.  (each is individual text field in SW)
									<table id="surgery_table">
										<tr>
											<th>Date</th>
											<th>Surgeon</th>
											<th>Surgery</th>
											<th></th>
										</tr>

										<?php
											$s_sql = "SELECT * FROM dental_q_page2_surgery WHERE patientid='".intval($_REQUEST['pid'])."'";
											  
											$s_q = $db->getResults($s_sql);
											$s_count = 0;
											if ($s_q) foreach ($s_q as $s_row) {
										?>
												<tr id="surgery_row_<?php echo  $s_count; ?>">
													<td>
														<input type="hidden" name="surgery_id_<?php echo  $s_count; ?>" value="<?php echo  $s_row['id']; ?>" />
														<input type="text" id="surgery_date_<?php echo  $s_count; ?>" name="surgery_date_<?php echo  $s_count; ?>" value="<?php echo  $s_row['surgery_date']; ?>" />
													</td>
													<td>
														<input type="text" id="surgeon_<?php echo  $s_count; ?>" name="surgeon_<?php echo  $s_count; ?>" value="<?php echo  $s_row['surgeon']; ?>" />
													</td>
													<td>
														<input type="text" id="surgery_<?php echo  $s_count; ?>" name="surgery_<?php echo  $s_count; ?>" value="<?php echo  $s_row['surgery']; ?>" />
													</td>
													<td>
														<input type="button" name="delete_<?php echo  $s_count; ?>" value="Delete" onclick="delete_surgery('<?php echo  $s_count; ?>'); return false;" />
													</td>
												</tr>
										<?php
												$s_count++;
											}
										?>
									        <tr id="surgery_row_<?php echo  $s_count; ?>">
								                <td>
								                	<input type="hidden" name="surgery_id_<?php echo  $s_count; ?>" value="0" />
								                	<input type="text" id="surgery_date_<?php echo  $s_count; ?>" name="surgery_date_<?php echo  $s_count; ?>" />
								                </td>
								                <td>
								                	<input type="text" id="surgeon_<?php echo  $s_count; ?>" name="surgeon_<?php echo  $s_count; ?>" />
								                </td>
								                <td>
								                	<input type="text" id="surgery_<?php echo  $s_count; ?>" name="surgery_<?php echo  $s_count; ?>" />
								                </td>
												<td>
													<input type="button" name="delete_<?php echo  $s_count; ?>" value="Delete" onclick="delete_surgery('<?php echo  $s_count; ?>'); return false;" />
												</td>
									        </tr>
									</table>
									<input type="hidden" id="num_surgery" name="num_surgery" value="<?php echo  $s_count+1; ?>" />
									<input type="button" onclick="add_surgery(); return false;" value="Add Surgery" />
								</span>
		    				</div>
					    	<script type="text/javascript">chk_s();</script>
				</td>
			</tr> 
        	<tr>
        	    <td valign="top" class="frmhead">
                	<ul>
                	    <li id="foli8" class="complex">
		                    <label class="desc" id="title0" for="Field0">OTHER ATTEMPTED THERAPIES</label>
                    		<div>
                        		<span>
			    					Please comment about other therapy attempts and how each impacted your snoring and apnea and sleep quality.
                            		<br />
		                            <textarea name="other_therapy" class="field text addr tbox" style="width:650px; height:100px;" ><?php echo $other_therapy;?></textarea>
		                            <?php                                
		                                showPatientValue('dental_q_page2', $_GET['pid'], 'other_therapy', $pat_row['other_therapy'], $other_therapy, true, $showEdits);
		                            ?>
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
		<?php include("includes/form_bottom.htm");?>
	<br />

	<div id="popupRefer" style="width:750px;">
	    <a id="popupReferClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopupRef"></div>

	<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup"></div>

	<br /><br />	

<?php
	} //end treatment status check
} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}
?>

<?php include "includes/bottom.htm";?>
