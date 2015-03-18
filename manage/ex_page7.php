<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#ex_page7frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
function trigger_letter7($pid) {
  $letterid = '7';
	$md_list = get_mdcontactids($pid);

  $md_referral_list = get_mdreferralids($pid); 
  $contacts['mds'] = explode(",", $md_list);
  foreach ($contacts['mds'] as $contact) {
    $letter_query = "SELECT md_list FROM dental_letters WHERE md_list IS NOT NULL AND CONCAT(',', md_list, ',') LIKE CONCAT('%,', '".$contact."', ',%') AND templateid IN(".$letterid.") AND patientid = '".$pid."';";
    $letter_result = mysql_query($letter_query);
    $num_rows = mysql_num_rows($letter_result);
    if(!$letter_result) {
      print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error Selecting Letters from Database";
      trigger_error("Die called", E_USER_ERROR);
    }
    if ($num_rows == 0) {
      $recipients['mds'][] = $contact;
    }
  }
  $contacts['md_referrals'] = explode(",", $md_referral_list);
  foreach ($contacts['md_referrals'] as $contact) {
    $letter_query = "SELECT md_referral_list FROM dental_letters WHERE md_referral_list IS NOT NULL AND CONCAT(',', md_referral_list, ',') LIKE CONCAT('%,', '".$contact."', ',%') AND templateid IN(".$letterid.") AND patientid = '".$pid."';";
    $letter_result = mysql_query($letter_query);
    $num_rows = mysql_num_rows($letter_result);
    if(!$letter_result) {
      print "MYSQL ERROR:".mysql_errno().": ".mysql_error()."<br/>"."Error Selecting Letters from Database";
      trigger_error("Die called", E_USER_ERROR);
    }
    if ($num_rows == 0) {
      $recipients['md_referrals'][] = $contact;
    }
  }
	$md_list = implode(",", $recipients['mds']);
  $md_referral_list = implode(",", $recipients['md_referrals']);
  if ($md_list . $md_referral_list != "") {
    $letter = create_letter($letterid, $pid, '', '', $md_list, $md_referral_list);
    if (!is_numeric($letter)) {
      print $letter;
      trigger_error("Die called", E_USER_ERROR);
    }
  }
}

if($_POST['ex_page7sub'] == 1)
{
	$sleep_study_on = $_POST['sleep_study_on'];
	$sleep_study_by = $_POST['sleep_study_by'];
	$assessment_chkyes = $_POST['assessment_chkyes'];
	$assessment_chk = $_POST['assessment_chk'];
	$assessment = $_POST['assessment'];
	$assess_addition = $_POST['assess_addition'];
	$consultation = $_POST['consultation'];
	$evaluation_new = $_POST['evaluation_new'];
	$evaluation_est = $_POST['evaluation_est'];
	$additional_paragraph_candidate  = $_POST['additional_paragraph_candidate'];
	$additional_paragraph_suffers = $_POST['additional_paragraph_suffers'];
	
	$assessment_arr = '';
	if(is_array($assessment))
	{
		foreach($assessment as $val)
		{
			if(trim($val) <> '')
				$assessment_arr .= trim($val).'~';
		}
	}
	if($assessment_arr != '')
		$assessment_arr = '~'.$assessment_arr;
		
	$assess_addition_arr = '';
	if(is_array($assess_addition))
	{
		foreach($assess_addition as $val)
		{
			if(trim($val) <> '')
				$assess_addition_arr .= trim($val).'~';
		}
	}
	if($assess_addition_arr != '')
		$assess_addition_arr = '~'.$assess_addition_arr;
	
	$consultation_arr = '';
	if(is_array($consultation))
	{
		foreach($consultation as $val)
		{
			if(trim($val) <> '')
				$consultation_arr .= trim($val).'~';
		}
	}
	if($consultation_arr != '')
		$consultation_arr = '~'.$consultation_arr;
	
	$evaluation_new_arr = '';
	if(is_array($evaluation_new))
	{
		foreach($evaluation_new as $val)
		{
			if(trim($val) <> '')
				$evaluation_new_arr .= trim($val).'~';
		}
	}
	if($evaluation_new_arr != '')
		$evaluation_new_arr = '~'.$evaluation_new_arr;
		
	$evaluation_est_arr = '';
	if(is_array($evaluation_est))
	{
		foreach($evaluation_est as $val)
		{
			if(trim($val) <> '')
				$evaluation_est_arr .= trim($val).'~';
		}
	}
	if($evaluation_est_arr != '')
		$evaluation_est_arr = '~'.$evaluation_est_arr;
	
	/*echo "sleep_study_on - ".$sleep_study_on."<br>";
	echo "sleep_study_by - ".$sleep_study_by."<br>";
	echo "assessment_chk - ".$assessment_chk."<br>";
	echo "assessment - ".$assessment_arr."<br>";
	echo "assess_addition - ".$assess_addition_arr."<br>";
	echo "consultation - ".$consultation_arr."<br>";
	echo "evaluation_new - ".$evaluation_new_arr."<br>";
	echo "evaluation_est - ".$evaluation_est_arr."<br>";
	echo "additional_paragraph_candidate - ".$additional_paragraph_candidate."<br>";
	echo "additional_paragraph_suffers - ".$additional_paragraph_suffers."<br>";*/
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page7 set 
		patientid = '".s_for($_GET['pid'])."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		sleep_study_by = '".s_for($sleep_study_by)."',
		assessment_chk = '".s_for($assessment_chk)."',
		assessment_chkyes = '".s_for($assessment_chkyes)."',
		assessment = '".s_for($assessment_arr)."',
		assess_addition = '".s_for($assess_addition_arr)."',
		consultation = '".s_for($consultation_arr)."',
		evaluation_new = '".s_for($evaluation_new_arr)."',
		evaluation_est = '".s_for($evaluation_est_arr)."',
		additional_paragraph_candidate = '".s_for($additional_paragraph_candidate)."',
		additional_paragraph_suffers = '".s_for($additional_paragraph_suffers)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or trigger_error($ins_sql." | ".mysql_error(), E_USER_ERROR);
	        
                if ($assessment_chk) {
                  trigger_letter7($_GET['pid']);
                }
	
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
	else
	{
		$ed_sql = " update dental_ex_page7 set 
		sleep_study_on = '".s_for($sleep_study_on)."',
		sleep_study_by = '".s_for($sleep_study_by)."',
		assessment_chkyes = '".s_for($assessment_chkyes)."',
    assessment_chk = '".s_for($assessment_chk)."',
		assessment = '".s_for($assessment_arr)."',
		assess_addition = '".s_for($assess_addition_arr)."',
		consultation = '".s_for($consultation_arr)."',
		evaluation_new = '".s_for($evaluation_new_arr)."',
		evaluation_est = '".s_for($evaluation_est_arr)."',
		additional_paragraph_candidate = '".s_for($additional_paragraph_candidate)."',
		additional_paragraph_suffers = '".s_for($additional_paragraph_suffers)."'
		where ex_page7id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or trigger_error($ed_sql." | ".mysql_error(), E_USER_ERROR);
		
		if ($assessment_chk) {
                  trigger_letter7($_GET['pid']);
                }

		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($form_myarray['patientid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['firstname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['lastname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$sql = "select * from dental_ex_page7 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page7id = st($myarray['ex_page7id']);
$sleep_study_on = st($myarray['sleep_study_on']);
$sleep_study_by = st($myarray['sleep_study_by']);
$assessment_chk = st($myarray['assessment_chk']);
$assessment_chkyes = st($myarray['assessment_chkyes']);
$assessment = st($myarray['assessment']);
$assess_addition = st($myarray['assess_addition']);
$consultation = st($myarray['consultation']);
$evaluation_new = st($myarray['evaluation_new']);
$evaluation_est = st($myarray['evaluation_est']);
$additional_paragraph_candidate = st($myarray['additional_paragraph_candidate']);
$additional_paragraph_suffers = st($myarray['additional_paragraph_suffers']);

$q2_sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$q2_my = mysql_query($q2_sql);
$q2_myarray = mysql_fetch_array($q2_my);

$sleep_study_on = st($q2_myarray['sleep_study_on']);
$sleep_study_by = st($q2_myarray['sleep_study_by']);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;
<a href="manage_forms.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back To Forms</b></a>
<br />

<? include("includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<script type="text/javascript">
	function chk_normal()
	{
		fa = document.ex_page7frm;
		
		
		if(fa.assessment_chk.checked)
		{
		<?
		$assessment_sql = "select * from dental_assessment where status=1 order by sortby";
		$assessment_my = mysql_query($assessment_sql);
		
		while($assessment_myarray = mysql_fetch_array($assessment_my))
		{
		?>
			document.getElementById('assessment_<?=st($assessment_myarray['assessmentid']);?>').disabled = false;
		<?
		}?>
		
		}
		else
		{
			
		<?
		$assessment_sql = "select * from dental_assessment where status=1 order by sortby";
		$assessment_my = mysql_query($assessment_sql);
		
		while($assessment_myarray = mysql_fetch_array($assessment_my))
		{
		?>
			document.getElementById('assessment_<?=st($assessment_myarray['assessmentid']);?>').disabled = true;
		<?
		}?>	
			
		}
	}
</script>

<script type="text/javascript">
	function ex_page7abc(fa)
	{
		if(trim(fa.sleep_study_on.value) != '')
		{ 
			if(is_date(trim(fa.sleep_study_on.value)) == -1 ||  is_date(trim(fa.sleep_study_on.value)) == false)
			{
				alert("Invalid Date Format, Valid Format : (mm/dd/YYYY);");
				fa.sleep_study_on.focus();
				return false;
			}
		}
	}
</script>

<form id="ex_page7frm" name="ex_page7frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post" onsubmit="return ex_page7abc(this)">
<input type="hidden" name="ex_page7sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page7id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="ex_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        <span class="form_info">
                        	Assessment
                        </span>
                    </label>
				</li>
			</ul>
		</td>
	</tr>
    
	<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        MY CLINICAL IMPRESSION BASED ON
                    </label>
                    
                    <div>
                    	<span>
                        	Based on Sleep Study Performed On 
                            <input id="sleep_study_on" name="sleep_study_on" type="text" class="field text addr tbox" value="<?=$sleep_study_on;?>" maxlength="10" style="width:75px;" readonly="readonly" /> 
                        </span>
                    </div>
                    <br />
                    
                    <div>
                    	<span>
                        	The sleep study and the diagnosis made by 
                            <input id="sleep_study_by" name="sleep_study_by" type="text" class="field text addr tbox" value="<?=$sleep_study_by?>" maxlength="255" style="width:200px;" readonly="readonly" />
                             <!--<button onclick="Javascript: loadPopup('select_contact_name.php?fr=ex_page7frm&tx=sleep_study_by'); return false;">Use Contact List</button> -->
                        </span>
                    </div>
                    <br />
                    
                    
                    <div>
                        <span style="color:#000000; padding-top:0px;">
                        	<input type="checkbox" name="assessment_chkyes" value="1" <? if($assessment_chkyes == 1) { echo " checked";}?> onclick="chk_normal()" />
                           	Is that the patient IS a candidate for oral appliance therapy (OAT).
						</span>      <br /><br />
                        <span style="color:#000000; padding-top:0px;">
                        	<input type="checkbox" name="assessment_chk" value="1" <? if($assessment_chk == 1) { echo " checked";}?> onclick="chk_normal()" />
                           	Is that the patient IS NOT a candidate for oral appliance therapy (OAT).
						</span>
                    </div>
                    <div>
                    	<span class="full">
                        	<table width="95%" align="right">
                        	<?
							$assessment_sql = "select * from dental_assessment where status=1 order by sortby";
							$assessment_my = mysql_query($assessment_sql);
							
							while($assessment_myarray = mysql_fetch_array($assessment_my))
							{
							?>
                            	<tr>
                                	<td valign="top" width="5%">
								<input type="checkbox" id="assessment_<?=st($assessment_myarray['assessmentid'])?>" name="assessment[]" value="<?=st($assessment_myarray['assessmentid'])?>" <? if(strpos($assessment,'~'.st($assessment_myarray['assessmentid']).'~') === false) {} else { echo " checked";}?> />
                                	</td>
                                    
                                    <td valign="top" width="95%">
                                    	<span>
		                                    <?=st($assessment_myarray['assessment']);?>
                                        </span>
                                	</td>
								</tr>
							<?
							}
							?>
							</table>
                        </span>

						<label class="desc" id="title0" for="Field0">
							Additional Paragraph
							/
							<button onclick="Javascript: loadPopup('select_custom_all.php?fr=ex_page7frm&tx=additional_paragraph_candidate'); getElementById('popupContact').style.top = '400px'; return false;">Custom Text</button>
						</label>
						
						<div>
							<span>
								<textarea name="additional_paragraph_candidate" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_candidate;?></textarea>
							</span>
						</div>
						<br />

                   	</div>
                    <br />
                    
                    <div>
                        <span style="color:#000000; padding-top:0px;">
                           	IN ADDITION, I BELIEVE THAT PATIENT SUFFERS FROM:
						</span>
                    </div>
                    <div>
                    	<span class="full">
                        	<table width="95%" align="right">
                        	<?
							$assess_addition_sql = "select * from dental_assess_addition  where status=1 order by sortby";
							$assess_addition_my = mysql_query($assess_addition_sql);
							
							while($assess_addition_myarray = mysql_fetch_array($assess_addition_my))
							{
							?>
                            	<tr>
                                	<td valign="top" width="5%">
								<input type="checkbox" id="assess_addition" name="assess_addition[]" value="<?=st($assess_addition_myarray['assess_additionid'])?>" <? if(strpos($assess_addition,'~'.st($assess_addition_myarray['assess_additionid']).'~') === false) {} else { echo " checked";}?> />
                                	</td>
                                    
                                    <td valign="top" width="95%">
                                    	<span>
		                                    <?=st($assess_addition_myarray['assess_addition']);?>
                                        </span>
                                	</td>
                                </tr>
							<?
							}
							?>
							</table>
                        </span>
						
						<label class="desc" id="title0" for="Field0">
							Additional Paragraph
							/
							<button onclick="Javascript: loadPopup('select_custom_all.php?fr=ex_page7frm&tx=additional_paragraph_suffers'); getElementById('popupContact').style.top = '600px'; return false;">Custom Text</button>
						</label>
						
						<div>
							<span>
								<textarea name="additional_paragraph_suffers" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_suffers;?></textarea>
							</span>
						</div>
						<br />
                   	</div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <!--<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                       	CONSULTATION CODES
                    </label>
                    (These services will appear in Claim Forms only. They will not appear in letters)
                    <br />&nbsp;
                    
                    <div>
                        <span style="color:#000000; padding-top:0px;">
                           	for New or Established Patients
						</span>
                    </div>
                    <div>
                    	<span class="full">
                        	<table width="100%" align="right">
                        	<?
							$consultation_sql = "select * from dental_consultation where status=1 order by sortby";
							$consultation_my = mysql_query($consultation_sql);
							
							while($consultation_myarray = mysql_fetch_array($consultation_my))
							{
							?>
                            	<tr>
                                	<td valign="top" width="5%">
								<input type="checkbox" id="consultation" name="consultation[]" value="<?=st($consultation_myarray['consultationid'])?>" <? if(strpos($consultation,'~'.st($consultation_myarray['consultationid']).'~') === false) {} else { echo " checked";}?> />
                                	</td>
                                    
                                    <td valign="top" width="95%">
                                    	<span>
		                                    <?=st($consultation_myarray['consultation']);?>
                                        </span>
                                	</td>
								</tr>
							<?
							}
							?>
							</table>
                        </span>
                   	</div>
                    <br />
				</li>
                
			</ul>
		</td>
	</tr> -->
    
    <!--<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                       	EVALUATION AND MANAGEMENT CODES
                    </label>
                    
                    <div>
                    	<span class="left">
                        	<span style="color:#000000; padding-top:0px;">
                                for New Patients
                            </span>
                        	<table width="100%" align="right">
                        	<?
							$evaluation_new_sql = "select * from dental_evaluation_new where status=1 order by sortby";
							$evaluation_new_my = mysql_query($evaluation_new_sql);
							
							while($evaluation_new_myarray = mysql_fetch_array($evaluation_new_my))
							{
							?>
                            	<tr>
                                	<td valign="top" width="5%">
								<input type="checkbox" id="evaluation_new" name="evaluation_new[]" value="<?=st($evaluation_new_myarray['evaluation_newid'])?>" <? if(strpos($evaluation_new,'~'.st($evaluation_new_myarray['evaluation_newid']).'~') === false) {} else { echo " checked";}?> />
                                	</td>
                                    
                                    <td valign="top" width="95%">
                                    	<span>
		                                    <?=st($evaluation_new_myarray['evaluation_new']);?>
                                        </span>
                                	</td>
								</tr>
							<?
							}
							?>
							</table>
                        </span>
                        
                        <span class="right">
                        	<span style="color:#000000; padding-top:0px;">
                                for Established Patients
                            </span>
                        	<table width="100%" align="right">
                        	<?
							$evaluation_est_sql = "select * from dental_evaluation_est where status=1 order by sortby";
							$evaluation_est_my = mysql_query($evaluation_est_sql);
							
							while($evaluation_est_myarray = mysql_fetch_array($evaluation_est_my))
							{
							?>
                            	<tr>
                                	<td valign="top" width="5%">
								<input type="checkbox" id="evaluation_est" name="evaluation_est[]" value="<?=st($evaluation_est_myarray['evaluation_estid'])?>" <? if(strpos($evaluation_est,'~'.st($evaluation_est_myarray['evaluation_estid']).'~') === false) {} else { echo " checked";}?> />
                                	</td>
                                    
                                    <td valign="top" width="95%">
                                    	<span>
		                                    <?=st($evaluation_est_myarray['evaluation_est']);?>
                                        </span>
                                	</td>
								</tr>
							<?
							}
							?>
							</table>
                        </span>
                        
                   	</div>
                    <br />
				</li>
                
			</ul>
		</td>
	</tr> -->
    
</table>

<div align="right">
	<input type="reset" value="Reset" />
    <input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

<script type="text/javascript">
	chk_normal();
</script>

<br />
<? include("includes/form_bottom.htm");?>
<br />


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
