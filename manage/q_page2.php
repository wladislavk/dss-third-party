<? 
include "includes/top.htm";

if($_POST['q_page2sub'] == 1)
{
	$polysomnographic = $_POST['polysomnographic'];
	$sleep_center_name = $_POST['sleep_center_name'];
	$sleep_study_on = $_POST['sleep_study_on'];
	$confirmed_diagnosis = $_POST['confirmed_diagnosis'];
	$rdi = $_POST['rdi'];
	$ahi = $_POST['ahi'];
	$cpap = $_POST['cpap'];
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
	
	/*echo "polysomnographic - ".$polysomnographic."<br>";
	echo "sleep_center_name - ".$sleep_center_name."<br>";
	echo "sleep_study_on - ".$sleep_study_on."<br>";
	echo "confirmed_diagnosis - ".$confirmed_diagnosis."<br>";
	echo "rdi - ".$rdi."<br>";
	echo "ahi - ".$ahi."<br>";
	echo "cpap - ".$cpap."<br>";
	echo "intolerance - ".$intolerance."<br>";
	echo "other_intolerance - ".$other_intolerance ."<br>";
	echo "other_therapy - ".$other_therapy ."<br>";
	echo "int_arr - ".$int_arr ."<br>";
	echo "other - ".$other_arr ."<br>";
	echo "affidavit - ".$affidavit ."<br>";
	echo "type_study - ".$type_study ."<br>";
	echo "nights_wear_cpap - ".$nights_wear_cpap ."<br>";
	echo "percent_night_cpap - ".$percent_night_cpap ."<br>";
	echo "custom_diagnosis - ".$custom_diagnosis ."<br>";
	echo "sleep_study_by - ".$sleep_study_by."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_page2 set 
		formid = '".s_for($_GET['fid'])."',
		patientid = '".s_for($_GET['pid'])."',
		polysomnographic = '".s_for($polysomnographic)."',
		sleep_center_name = '".s_for($sleep_center_name)."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		confirmed_diagnosis = '".s_for($confirmed_diagnosis)."',
		rdi = '".s_for($rdi)."',
		ahi = '".s_for($ahi)."',
		cpap = '".s_for($cpap)."',
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
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page2 set 
		polysomnographic = '".s_for($polysomnographic)."',
		sleep_center_name = '".s_for($sleep_center_name)."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		confirmed_diagnosis = '".s_for($confirmed_diagnosis)."',
		rdi = '".s_for($rdi)."',
		ahi = '".s_for($ahi)."',
		cpap = '".s_for($cpap)."',
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
		timesovertime = '".s_for($timesovertime)."'
		where q_page2id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


$form_sql = "select * from dental_forms where formid='".s_for($_GET['fid'])."'";
$form_my = mysql_query($form_sql);
$form_myarray = mysql_fetch_array($form_my);

if($form_myarray['formid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_forms.php?pid=<?=$_GET['pid'];?>';
	</script>
	<?
	die();
}

$pat_sql = "select * from dental_patients where patientid='".s_for($form_myarray['patientid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}
$sql = "select * from dental_q_page2 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page2id = st($myarray['q_page2id']);

$polysomnographic = st($myarray['polysomnographic']);
$sleep_center_name = st($myarray['sleep_center_name']);
$sleep_study_on = st($myarray['sleep_study_on']);
$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
$rdi = st($myarray['rdi']);
$ahi = st($myarray['ahi']);
$cpap = st($myarray['cpap']);
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

if($cpap == '')
	$cpap = 'No';
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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

<script>
	function chk_poly()
	{ 	
		fa = document.q_page2frm;
		
		if(fa.polysomnographic[0].checked)
		{
			fa.sleep_center_name.disabled = false;
			fa.sleep_study_on.disabled = false;
			fa.type_study.disabled = false;
			fa.confirmed_diagnosis.disabled = false;
			fa.custom_diagnosis.disabled = false;
			fa.rdi.disabled = false;
			fa.ahi.disabled = false;
		}
		else
		{
			fa.sleep_center_name.disabled = true;
			fa.sleep_study_on.disabled = true;
			fa.type_study.disabled = true;
			fa.confirmed_diagnosis.disabled = true;
			fa.custom_diagnosis.disabled = true;
			fa.rdi.disabled = true;
			fa.ahi.disabled = true;
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
	
	function chk_cpap()
	{ 	
		fa = document.q_page2frm;
		
		chk_l = document.getElementsByName('intolerance[]').length;
		
		if(fa.cpap[1].checked)
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('intolerance[]')[i].disabled = true;
			}
			fa.nights_wear_cpap.disabled = true;
			fa.percent_night_cpap.disabled = true;
		}
		else
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('intolerance[]')[i].disabled = false;
			}
			fa.nights_wear_cpap.disabled = false;
			fa.percent_night_cpap.disabled = false;
		}
		
	}
	
	function q_page2abc(fa) {
	    var errorMsg = '';
	    
		if (trim(fa.sleep_study_on.value) != '') { 
			if (is_date(trim(fa.sleep_study_on.value)) == -1 ||  is_date(trim(fa.sleep_study_on.value)) == false) {
				errorMsg += "- Invalid Date Format, Valid Format : (mm/dd/YYYY);\n";
				fa.sleep_study_on.focus();
			}
		}
		
		if (trim(fa.confirmed_diagnosis.selectedIndex) < 1) {
		    errorMsg += "- Missing Confirmed Diagnosis\n";
		}
		
		if (errorMsg != '') {
		    alert(errorMsg);
		}
		
		return (errorMsg == '');
	}
</script>

<form name="q_page2frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post" onsubmit="return q_page2abc(this)">
<input type="hidden" name="q_page2sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page2id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
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
                    <div>
                        <span>
							Have you had a sleep study
							
							<input type="radio" name="polysomnographic" value="1" <? if($polysomnographic == '1') echo " checked";?> onclick="chk_poly()" />
                            Yes
                            
                            <input type="radio" name="polysomnographic" value="0" <? if($polysomnographic == '0') echo " checked";?> onclick="chk_poly()"  />
                            No
							
                        	<!--<input type="checkbox" name="polysomnographic" value="1" class="tbox" style="width:10px;"  onclick="chk_poly()" <? if($polysomnographic == 1) echo " checked";?> />
                            A polysomnographic evaluation was performed at a sleep disorder center -->
                        </span>
                    </div>
                    
                    <br />
                    <div>
                    	<span>
                        	If yes where 
							<?
							$sleep_sql = "select * from dental_sleeplab where status=1 and docid='".$_SESSION['docid']."' order by company";
							$sleep_my = mysql_query($sleep_sql);
							?>
							
							<select name="sleep_center_name" class="field text addr tbox">
                            	<option value=""></option>
								<? while($sleep_myarray = mysql_fetch_array($sleep_my)) {?>
                                <option value="<?=st($sleep_myarray['sleeplabid'])?>" <? if($sleep_center_name == st($sleep_myarray['sleeplabid']) ) echo " selected";?>>
                                	<?=st($sleep_myarray['company'])?>
                                </option>
								<? }?>
                            </select>
							
                            <!--<input id="sleep_center_name" name="sleep_center_name" type="text" class="field text addr tbox" value="<?=$sleep_center_name;?>"  maxlength="255" style="width:225px;" />  -->
							
							Date
                            &nbsp;&nbsp;
                            <input id="sleep_study_on" name="sleep_study_on" type="text" class="field text addr tbox" value="<?=$sleep_study_on;?>"  maxlength="10" style="width:75px;" /> 
                        </span>
                    </div>
					<br />
					
					<div>
                    	<span>
                        	The sleep study and the diagnosis made by 
                            <input id="sleep_study_by" name="sleep_study_by" type="text" class="field text addr tbox" value="<?=$sleep_study_by?>" maxlength="255" style="width:200px;" />
                             <button onclick="Javascript: loadPopup('select_contact_name.php?fr=q_page2frm&tx=sleep_study_by'); return false;">Use Contact List</button>
                        </span>
                    </div>
                    
                    <br />
                    <div>
                    	<span>
                        	
                            <u>Office use only:</u>
							<br />
							Type of Study
							&nbsp;&nbsp;
                            <select name="type_study" class="field text addr tbox" >
                            	<option value=""></option>
                                <option value="PSG" <? if($type_study == 'PSG' ) echo " selected";?>>
                                	PSG
                                </option>
                                <option value="Ambulatory" <? if($type_study == 'Ambulatory' ) echo " selected";?>>
                                	Ambulatory
                                </option>
                            </select>
							
							<br /><br />
							
                            Diagnosis 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="confirmed_diagnosis" class="field text addr tbox" >
                            	<option value="">SELECT</option>
                                <option value="327.23" <? if($confirmed_diagnosis == '327.23' ) echo " selected";?>>
                                	327.23 - Obstructive Sleep Apnea
                                </option>
                                <option value="750.15" <? if($confirmed_diagnosis == '750.15' ) echo " selected";?>>
                                	750.15 - Macroglossia Congenital Hypertrophy of Tongue
                                </option>
                                <option value="786.09" <? if($confirmed_diagnosis == '786.09' ) echo " selected";?>>
                                	786.09 - UARS
                                </option>
                                <option value="519.80" <? if($confirmed_diagnosis == 'Severe Obstructive Sleep Apnea' ) echo " selected";?>>
                                	519.80 - UARS
                                </option>
                            </select>
                            <span style="color:red; float:none">*</span>
							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input id="custom_diagnosis" name="custom_diagnosis" type="text" class="field text addr tbox" value="<?=$custom_diagnosis;?>" maxlength="255" style="width:225px;" /> 
							 
                        </span>
                    </div>
                    
                    <br />
                    <div>
                    	<span>
                        	RDI
                            &nbsp;&nbsp;
                            <input id="rdi" name="rdi" type="text" class="field text addr tbox" value="<?=$rdi;?>"  maxlength="3" style="width:60px;" />
                            
                            &nbsp;&nbsp;
                            And 
							AHI
                            &nbsp;&nbsp; 
                            
                            <input id="ahi" name="ahi" type="text" class="field text addr tbox" value="<?=$ahi;?>"  maxlength="4" style="width:80px;" />
                           
                        </span>
                    </div>  
                    <br />
                    
                </li>
            </ul>
           <script>
				chk_poly();
		   </script>
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
                            <input type="radio" name="cpap" value="Yes" <? if($cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
                            Yes
                            
                            <input type="radio" name="cpap" value="Yes" <? if($cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No
                        </span>
                   	</div>
                   
                   	<br />
                   	<div>
                        <span>
                   			The Patient has attempted treatment with a CPAP but they could not tolerate it's use due to:	
                            <br />
                            
                            <?
							$intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
							$intolerance_my = mysql_query($intolerance_sql);
							
							while($intolerance_myarray = mysql_fetch_array($intolerance_my))
							{
							?>
								<input type="checkbox" id="intolerance" name="intolerance[]" value="<?=st($intolerance_myarray['intoleranceid'])?>" <? if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($intolerance_myarray['intolerance']);?><br />
							<?
							}
							?>
                       	</span>
					</div>
                    <br />
                    
                    
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_intolerance" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_intolerance;?></textarea>
							<br />&nbsp;
                        </span>
                    </div>
                   						
					<div>
                        <span>
							On average how many nights per week do you wear your CPAP?
							<input id="nights_wear_cpap" name="nights_wear_cpap" type="text" class="field text addr tbox" value="<?=$nights_wear_cpap;?>" maxlength="255" style="width:225px;" />
							<br />&nbsp;
						</span>
					</div>
					
					<div>
                        <span>
							On average how many hours each night do you wear your CPAP?
							<input id="percent_night_cpap" name="percent_night_cpap" type="text" class="field text addr tbox" value="<?=$percent_night_cpap;?>" maxlength="255" style="width:225px;" />
							<br />&nbsp;
						</span>
					</div>
					<div>
                        <span>
							How many times have you tried CPAP for a period of time, quit and then tried CPAP again?<input id="triedquittried" name="triedquittried" type="text" class="field text addr tbox" value="<?=$triedquittried;?>" maxlength="255" style="width:225px;" />
							<br />&nbsp;
						</span>
					</div>
					
					<div>
                        <span>
							On average how long of time period did you try the CPAP during each of these time periods?<input id="timesovertime" name="timesovertime" type="text" class="field text addr tbox" value="<?=$timesovertime;?>" maxlength="255" style="width:225px;" />
							<br />&nbsp;
						</span>
					</div>
					
                    
					<input type="checkbox" name="affidavit" value="1" <? if($affidavit == 1) echo " checked";?> />
					I have enclosed a signed affidavit by the patient attesting to CPAP intolerance 
					
					<script type="text/javascript">
						chk_cpap();
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
                        OTHER THERAPY ATTEMPTS
                    </label>
                    <div>
                        <span>
                        	What other therapies have you had? (<!--weight loss attempts, smoking cessation for at least one month, surgeries, --> Weight loss, Positional therapy, Gastric Bypass, UPPP (Palatal Surgery), Other.
                            <br />
							
							<input type="checkbox" id="other" name="other[]" value="Weight loss" <? if(strpos($other,'~Weight loss~') === false) {} else { echo " checked";}?> />
							&nbsp;&nbsp; Weight loss<br />
							
							<input type="checkbox" id="other" name="other[]" value="Positional therapy" <? if(strpos($other,'~Positional therapy~') === false) {} else { echo " checked";}?> />
							&nbsp;&nbsp; Positional therapy<br />
							
							<input type="checkbox" id="other" name="other[]" value="Gastric Bypass" <? if(strpos($other,'~Gastric Bypass~') === false) {} else { echo " checked";}?> />
							&nbsp;&nbsp; Gastric Bypass<br />
							
							<input type="checkbox" id="other" name="other[]" value="UPPP (Palatal Surgery)" <? if(strpos($other,'~UPPP (Palatal Surgery)~') === false) {} else { echo " checked";}?> />
							&nbsp;&nbsp; UPPP (Palatal Surgery)<br />
							
							<input type="checkbox" id="other" name="other_chk" value="1" <? if(strpos($other,'~Other~') === false) {} else { echo " checked";}?> onclick="Javscript: other_chk1();" />
							&nbsp;&nbsp; Other<br />
							
                            <textarea name="other_therapy" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_therapy;?></textarea>
                        </span>
							<script>
								other_chk1();
						   </script>
                   	</div>
                    <br />
				</li>
			</ul>
		</td>
	</tr>                    
</table>

<div align="right">
	<input type="reset" value="Reset" />
    <input type="submit" name="q_pagebtn" value="Save"  />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

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