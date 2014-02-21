<?php 
include "includes/header.php";
include 'includes/questionnaire_sections.php';
?>

<?php
if($_POST['q_page2sub'] == 1)
{
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
	if(is_array($intolerance))
	{
		foreach($intolerance as $val)
		{
			if(trim($val) <> '')
				$int_arr .= trim($val).'~';
		}
	}
	
	if($int_arr != '')
		$int_arr = '~'.$int_arr;
		
	$other_arr = '';
	if(is_array($other))
	{
		foreach($other as $val)
		{
			if(trim($val) <> '')
				$other_arr .= trim($val).'~';
		}
	}
	
	if($other_chk != '')
		$other_arr .= 'Other~';
	
	if($other_arr != '')
		$other_arr = '~'.$other_arr;
	
		
	if($polysomnographic == '')
		$polysomnographic = 0;
	
	
        $exist_sql = "SELECT patientid FROM dental_q_page2 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
        $exist_q = mysql_query($exist_sql);
        if(mysql_num_rows($exist_q) == 0)
	{
		$ins_sql = " insert into dental_q_page2 set 
		patientid = '".s_for($_SESSION['pid'])."',
		polysomnographic = '".s_for($polysomnographic)."',
		sleep_center_name_text = '".s_for($sleep_center_name_text)."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		confirmed_diagnosis = '".s_for($confirmed_diagnosis)."',
		rdi = '".s_for($rdi)."',
		ahi = '".s_for($ahi)."',
		cpap = '".s_for($cpap)."',
		cur_cpap = '".s_for($cur_cpap)."',
		intolerance = '".s_for($int_arr)."',
		other_intolerance = '".s_for($other_intolerance)."',
		other_therapy = '".s_for($other_therapy)."',
		other = '".s_for($other_arr)."',
		affidavit = '".s_for($affidavit)."',
		type_study = '".s_for($type_study)."',
		nights_wear_cpap = '".s_for($nights_wear_cpap)."',
		percent_night_cpap = '".s_for($percent_night_cpap)."',
		custom_diagnosis = '".s_for($custom_diagnosis)."',
		sleep_study_by = '".s_for($sleep_study_by)."',
		triedquittried = '".s_for($triedquittried)."',
		timesovertime = '".s_for($timesovertime)."',
		dd_wearing = '".s_for($dd_wearing)."',
		dd_prev = '".s_for($dd_prev)."',
		dd_otc = '".s_for($dd_otc)."',
		dd_fab = '".s_for($dd_fab)."',
		dd_who = '".s_for($dd_who)."',
		dd_experience = '".s_for($dd_experience)."',
		surgery = '".s_for($surgery)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
                for($i=0;$i<$num_surgery;$i++){
                        if($_POST['surgery_id_'.$i]==0){
                                if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
                                        $s = "INSERT INTO dental_q_page2_surgery (patientid, surgery_date, surgery, surgeon) VALUES ('".$_SESSION['pid']."', '".$_POST['surgery_date_'.$i]."','".$_POST['surgery_'.$i]."','".$_POST['surgeon_'.$i]."')";
                                }
                                else{ $s=''; }
                        }else{
                                if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
                                        $s = "UPDATE dental_q_page2_surgery SET surgery_date='".$_POST['surgery_date_'.$i]."', surgery='".$_POST['surgery_'.$i]."', surgeon='".$_POST['surgeon_'.$i]."' WHERE id='".$_POST['surgery_id_'.$i]."'";
                                }else{
                                        $s = "DELETE FROM dental_q_page2_surgery WHERE id='".$_POST['surgery_id_'.$i]."'";
                                }
                        }
                        mysql_query($s);
                }
		mysql_query("UPDATE dental_patients SET treatments_status=1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
                mysql_query("UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p'];?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page2 set 
		polysomnographic = '".s_for($polysomnographic)."',
		sleep_center_name_text = '".s_for($sleep_center_name_text)."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		confirmed_diagnosis = '".s_for($confirmed_diagnosis)."',
		rdi = '".s_for($rdi)."',
		ahi = '".s_for($ahi)."',
		cpap = '".s_for($cpap)."',
                cur_cpap = '".s_for($cur_cpap)."',
		intolerance = '".s_for($int_arr)."',
		other_intolerance = '".s_for($other_intolerance)."',
		other_therapy = '".s_for($other_therapy)."',
		other = '".s_for($other_arr)."',
		affidavit = '".s_for($affidavit)."',
		type_study = '".s_for($type_study)."',
		nights_wear_cpap = '".s_for($nights_wear_cpap)."',
		percent_night_cpap = '".s_for($percent_night_cpap)."',
		custom_diagnosis = '".s_for($custom_diagnosis)."',
		sleep_study_by = '".s_for($sleep_study_by)."',
		triedquittried = '".s_for($triedquittried)."',
		timesovertime = '".s_for($timesovertime)."',
                dd_wearing = '".s_for($dd_wearing)."',
                dd_prev = '".s_for($dd_prev)."',
                dd_otc = '".s_for($dd_otc)."',
                dd_fab = '".s_for($dd_fab)."',
                dd_who = '".s_for($dd_who)."',
                dd_experience = '".s_for($dd_experience)."',
		surgery = '".s_for($surgery)."'
		where patientid = '".s_for($_SESSION['pid'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

                for($i=0;$i<$num_surgery;$i++){
                        if($_POST['surgery_id_'.$i]==0){
                                if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
                                        $s = "INSERT INTO dental_q_page2_surgery (patientid, surgery_date, surgery, surgeon) VALUES ('".$_SESSION['pid']."', '".$_POST['surgery_date_'.$i]."','".$_POST['surgery_'.$i]."','".$_POST['surgeon_'.$i]."')";
                                }
				else{ $s=''; }
                        }else{
                                if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
                                        $s = "UPDATE dental_q_page2_surgery SET surgery_date='".$_POST['surgery_date_'.$i]."', surgery='".$_POST['surgery_'.$i]."', surgeon='".$_POST['surgeon_'.$i]."' WHERE id='".$_POST['surgery_id_'.$i]."'";
                                }else{
                                        $s = "DELETE FROM dental_q_page2_surgery WHERE id='".$_POST['surgery_id_'.$i]."'";
                                }
                        }
                        mysql_query($s);
                }
		mysql_query("UPDATE dental_patients SET treatments_status=1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
                mysql_query("UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p'];?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


        $exist_sql = "SELECT treatments_status FROM dental_patients WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
        $exist_q = mysql_query($exist_sql);
        $exist_row = mysql_fetch_assoc($exist_q);
        if($exist_row['treatments_status'] == 0)
        {


$pat_sql = "select * from dental_patients where patientid='".s_for($_SESSION['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

$sql = "select * from dental_q_page2 where patientid='".$_SESSION['pid']."' ";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

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

if($cpap == '')
	$cpap = 'No';
?>
<link rel="stylesheet" href="css/questionnaire.css" />
<a name="top"></a>
<?php include 'includes/questionnaire_header.php'; ?>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<script>
	function chk_poly()
	{ 	
		fa = document.q_page2frm;
		
		if(fa.polysomnographic[0].checked)
		{
			$('.poly_options').show();
		}
		else
		{
			$('.poly_options').hide();
		}
	}
	
	function other_chk1()
	{ 	
		fa = document.q_page2frm;
		
		if(fa.other_chk.checked)
		{
			fa.other_therapy.disabled = false;
		}
		else
		{
			fa.other_therapy.disabled = true;
		}
	}
 	function chk_cpap_other(){
		if($('#cpap_other').attr('checked')){
		  $('.cpap_other_text').show();
		}else{
		  $('.cpap_other_text').hide();
		}

	}	
	function chk_who(){
                fa = document.q_page2frm;
                
                if(fa.dd_fab[1].checked)
                {
                        $('.dd_fab_options').hide();
                }
                else
                {
                        $('.dd_fab_options').show();
                }

	}

        function chk_dd()
        {       
                fa = document.q_page2frm;
                
                
                if(fa.dd_wearing[0].checked || fa.dd_prev[0].checked)
                {
                        $('.dd_options').show();
                }
                else
		{
			$('.dd_options').hide();
		}
	}
	function chk_s()
        {       
                fa = document.q_page2frm;
                
                
                if(fa.surgery[0].checked)
                {
                        $('.s_options').show();
                }
                else
                {
                        $('.s_options').hide();
                }
        }
	function chk_cpap()
	{ 	
		fa = document.q_page2frm;
		
		chk_l = document.getElementsByName('intolerance[]').length;
		
		if(fa.cpap[1].checked)
		{
			$('.cpap_options').hide();
			$('.cpap_options2').hide();
		}
		else
		{
			$('.cpap_options').show();
                  if(fa.cur_cpap[0].checked)
                  {
                        $('.cpap_options2').show();
                  }
                  else
                  {
                        $('.cpap_options2').hide();
                  }
		}
	}
	
	function q_page2abc(fa) {
	    var errorMsg = '';
	    
		if (fa.sleep_study_on.value != '') { 
			if (is_date(trim(fa.sleep_study_on.value)) == -1 ||  is_date(trim(fa.sleep_study_on.value)) == false) {
				errorMsg += "- Invalid Date Format, Valid Format : (mm/dd/YYYY);\n";
				fa.sleep_study_on.focus();
			}
		}
		
		if (document.getElementById('polysomnographic_yes').checked && trim(fa.confirmed_diagnosis.selectedIndex) < 1) {
		    errorMsg += "- Missing Confirmed Diagnosis\n";
		}
		if (errorMsg != '') {
		    alert(errorMsg);
		}
		
		return (errorMsg == '');
	}
</script>

<form id="q_page2frm" class="q_form" name="q_page2frm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
<input type="hidden" name="q_page2sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page2id;?>" />
<input type="hidden" id="goto_p" name="goto_p" value="history.php" />

<div class="formEl_a">
           <h3>Sleep Studies</h3>
                    <div class="sepH_b">
			<label class="lbl_a">Have you had a sleep study</label>
			<input type="radio" id="polysomnographic_yes" name="polysomnographic" value="1" <? if($polysomnographic == '1') echo " checked";?> onclick="chk_poly()" />
                            Yes
                            
                            <input type="radio" name="polysomnographic" value="0" <? if($polysomnographic == '0') echo " checked";?> onclick="chk_poly()"  />
                            No
							
                        	<!--<input type="checkbox" name="polysomnographic" value="1" class="tbox" style="width:10px;"  onclick="chk_poly()" <? if($polysomnographic == 1) echo " checked";?> />
                            A polysomnographic evaluation was performed at a sleep disorder center -->
                    <br />
                    <div class="poly_options">
                        <label class="lbl_in">If yes where:</label> 
                        <input id="sleep_center_name_text" name="sleep_center_name_text" type="text" class="inpt_a" value="<?=$sleep_center_name_text;?>"  maxlength="255" /> 
						
			<label class="lbl_in">Date:</label>
                            <input id="sleep_study_on" name="sleep_study_on" type="text" class="inpt_a" value="<?=$sleep_study_on;?>"  maxlength="10" style="width:75px;" /> 
                    </div>
			</div>
					
           <script>
				chk_poly();
		   </script>
          <h3>CPAP Intolerance</h3>
                    <div class="sepH_b">
                        <label class="lbl_a">Have you tried CPAP?</label>
                            <input type="radio" name="cpap" value="Yes" <? if($cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
                            Yes
                            
                            <input type="radio" name="cpap" value="No" <? if($cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No
		    </div>
                    <div class="sepH_b cpap_options">
                            <label class="lbl_a">Are you currently using CPAP?</label>
                            <input type="radio" name="cur_cpap" value="Yes" <? if($cur_cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />                            Yes

                            <input type="radio" name="cur_cpap" value="No" <? if($cur_cpap == 'No') echo " checked";?> onclick="chk_cpap();$('#nights_wear_cpap').val(0);$('#percent_night_cpap').val(0);"  />
                            No
                        </div>
                   
                                        <div class="sepH_b half cpap_options2">                     
                                            <label class="lbl_a">If currently using CPAP, how many nights / week do you wear it?</label>
						<input id="nights_wear_cpap" name="nights_wear_cpap" type="text" class="inpt_a" value="<?=$nights_wear_cpap;?>" maxlength="255" />
                                        </div>

                                        <div class="sepH_b half cpap_options2">
                                            <label class="lbl_a">How many hours each night do you wear it?</label>
						<input id="percent_night_cpap" name="percent_night_cpap" type="text" class="inpt_a" value="<?=$percent_night_cpap;?>" maxlength="255" />
                                                </span>
                                        </div>

                   			<h5>What are your chief complaints about CPAP?</h5>	
                            
                            <?
							$intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
							$intolerance_my = mysql_query($intolerance_sql);
							
							while($intolerance_myarray = mysql_fetch_array($intolerance_my))
							{
							?>
							<div class="sepH_b half">
								<input type="checkbox" id="intolerance" name="intolerance[]" value="<?=st($intolerance_myarray['intoleranceid'])?>" <? if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
                                <label><?=st($intolerance_myarray['intolerance']);?></label>
							</div>
							<?
							}
							?>
					<div class="sepH_b half">
					<input type="checkbox" id="cpap_other" name="intolerance[]" value="0" <? if(strpos($intolerance,'~'.st('0~')) === false) {} else { echo " checked";}?> onclick="chk_cpap_other()" /> &nbsp;&nbsp; Other
					</div>
                    <div class="sepH_b cpap_options">
                        <span class="cpap_other_text">
                            	<label class="lbl_a">Other Items</label>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_intolerance" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_intolerance;?></textarea>
							<br />&nbsp;
                        </span>
                    </div>
                   						
					<script type="text/javascript">
						chk_cpap();
						chk_cpap_other();
					</script>
                      	<h3 class="clear">Dental Devices</h3> 
			<div class="sepH_b half">
				<label class="lbl_a">Are you currently wearing a dental device specifically designed to treat sleep apnea?</label>
                            <input type="radio" name="dd_wearing" value="Yes" <? if($dd_wearing == 'Yes') echo " checked";?> onclick="chk_dd()"  />
                            Yes

                            <input type="radio" name="dd_wearing" value="No" <? if($dd_wearing == 'No') echo " checked";?> onclick="chk_dd()"  />
                            No

		    </div>
		    <div class="sepH_b half">
 				<label class="lbl_a">Have you previously tried a dental device for sleep apnea treatment?</label>
                            <input type="radio" name="dd_prev" value="Yes" <? if($dd_prev == 'Yes') echo " checked";?> onclick="chk_dd()"  />
                            Yes

                            <input type="radio" name="dd_prev" value="No" <? if($dd_prev == 'No') echo " checked";?> onclick="chk_dd()"  />
                            No

			</span>
		    </div>
		    <div class="dd_options sepH_b half">
			<label class="lbl_a">Was it over-the-counter (OTC)?</label> 	
                            <input type="radio" name="dd_otc" value="Yes" <? if($dd_otc == 'Yes') echo " checked";?> />
                            Yes

                            <input type="radio" name="dd_otc" value="No" <? if($dd_otc == 'No') echo " checked";?> />
                            No
		    </div>
		    <div class="dd_options sepH_b half">
			<label class="lbl_a">Was it fabricated by a dentist?</label>
                            <input type="radio" name="dd_fab" value="Yes" <? if($dd_fab == 'Yes') echo " checked";?> onclick="chk_who();" />
                            Yes

                            <input type="radio" name="dd_fab" value="No" <? if($dd_fab == 'No') echo " checked";?> onclick="chk_who();" />
                            No
				<br /><br />
				<div class="dd_fab_options">
				<label class="lbl_a">Who?</label>
				<input class="inpt_a" type="text" id="dd_who" name="dd_who" value="<?= $dd_who; ?>" />
				</div>
<script type="text/javascript">
  chk_who();
</script>
	 	    </div>
		    <div class="dd_options">
			<label class="lbl_a">Describe your experience</label>
				<textarea id="dd_experience" name="dd_experience"><?= $dd_experience; ?></textarea>
		    </div>
			<script type="text/javascript">
				chk_dd();
			</script>
                        <h3 class="clear">Surgery</h3>
			<div class="sepH_b">
				<label class="lbl_a">Have you had surgery for snoring or sleep apnea?</label>
                            <input type="radio" name="surgery" value="Yes" <? if($surgery == 'Yes') echo " checked";?> onclick="chk_s()" />
                            Yes

                            <input type="radio" name="surgery" value="No" <? if($surgery == 'No') echo " checked";?> onclick="chk_s()" />
                            No
		    </div>
		    <div class="sepH_b s_options">
			<label class="lbl_a">Please list any nose, palatal, throat, tongue, or jaw surgeries you have had.  (each is individual text field in SW)</label>
	<table id="surgery_table">
	<tr><th>Date</th><th>Surgeon</th><th>Surgery</th><th></th></tr>	
		<?php
		  $s_sql = "SELECT * FROM dental_q_page2_surgery WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
		  $s_q = mysql_query($s_sql);
		  $s_count = 0;
		  while($s_row = mysql_fetch_assoc($s_q)){
		?>
	  <tr id="surgery_row_<?= $s_count; ?>">
		<td><input type="hidden" name="surgery_id_<?= $s_count; ?>" value="<?= $s_row['id']; ?>" />
			<input type="text" id="surgery_date_<?= $s_count; ?>" name="surgery_date_<?= $s_count; ?>" value="<?= $s_row['surgery_date']; ?>" /></td>
		<td><input type="text" id="surgeon_<?= $s_count; ?>" name="surgeon_<?= $s_count; ?>" value="<?= $s_row['surgeon']; ?>" /></td>
		<td><input type="text" id="surgery_<?= $s_count; ?>" name="surgery_<?= $s_count; ?>" value="<?= $s_row['surgery']; ?>" /></td>
		<td><input type="button" name="delete_<?= $s_count; ?>" class="next btn btn_b" value="Delete" onclick="delete_surgery('<?= $s_count; ?>'); return false;" /></td>
	  </tr>
		<?php
			$s_count++;
			}
		?>
          <tr id="surgery_row_<?= $s_count; ?>">
                <td><input type="hidden" name="surgery_id_<?= $s_count; ?>" value="0" /><input type="text" id="surgery_date_<?= $s_count; ?>" name="surgery_date_<?= $s_count; ?>" /></td>
                <td><input type="text" id="surgeon_<?= $s_count; ?>" name="surgeon_<?= $s_count; ?>" /></td>
                <td><input type="text" id="surgery_<?= $s_count; ?>" name="surgery_<?= $s_count; ?>" /></td>
		<td><input type="button" name="delete_<?= $s_count; ?>" class="next btn btn_b" value="Delete" onclick="delete_surgery('<?= $s_count; ?>'); return false;" /></td>
          </tr>
	</table>
		<input type="hidden" id="num_surgery" name="num_surgery" value="<?= $s_count+1; ?>" />
		<input type="button" onclick="add_surgery(); return false;" class="next btn btn_d" value="Add Surgery" />
			</span>
		    </div>
		    <script type="text/javascript">
			chk_s();
			function add_surgery(){
				n = $('#num_surgery').attr('value');
				$('#surgery_table').append('<tr id="surgery_row_'+n+'"><td><input type="hidden" name="surgery_id_'+n+'" value="0" /><input type="text" id="surgery_date_'+n+'" name="surgery_date_'+n+'" /></td><td><input type="text" id="surgeon_'+n+'" name="surgeon_'+n+'" /></td><td><input type="text" id="surgery_'+n+'" name="surgery_'+n+'" /></td><td><input type="button" class="next btn btn_b" name="delete_'+n+'" value="Delete" onclick="delete_surgery(\''+n+'\'); return false;" /></td></tr>');				
				$('#num_surgery').attr('value', (parseInt(n,10)+1));
			}
                        function delete_surgery(n){
                                $('#surgery_date_'+n).val('');
                                $('#surgeon_'+n).val('');
                                $('#surgery_'+n).val('');
                                $('#surgery_row_'+n).hide();
                        }
		    </script>
                        <h3>OTHER ATTEMPTED THERAPIES</h3>
			<div class="sepH_b">
			    <label clas="lbl_a">Please comment about other therapy attempts and how each impacted your snoring and apnea and sleep quality.</label>
                            <textarea name="other_therapy" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_therapy;?></textarea>
                                                        <script>
                                                                other_chk1();
                                                   </script>
                        </div>
<p class="confirm_text">Thank you for completing the Treatments Questionnaire! Please click the box below to confirm and record your answers.</p>
<div align="right">
    <input type="submit" name="q_pagebtn" class="next btn btn_d" value="Save and Proceed"  />
    &nbsp;&nbsp;&nbsp;
</div>
</div>
</form>

<?php }else{
show_section_completed($_SESSION['pid']);
} ?>

<? include "includes/footer.php";?>

