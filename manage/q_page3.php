<?php 
include "includes/top.htm";
require_once('includes/patient_info.php');
if ($patient_info) {

?>
<script type="text/javascript">
edited = false;
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			edited = true;
			//window.onbeforeunload = confirmExit;
		});
		$('#q_page3frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['q_page3sub'] == 1)
{
	$allergens = $_POST['allergens'];
	$other_allergens = $_POST['other_allergens'];
	$medications = $_POST['medications'];
	$other_medications = $_POST['other_medications'];
	$history = $_POST['history'];
	$other_history = $_POST['other_history'];
	$dental_health = $_POST['dental_health'];
	$removable = $_POST['removable'];
	$year_completed = $_POST['year_completed'];
	$tmj = $_POST['tmj'];
	$gum_problems = $_POST['gum_problems'];
	$dental_pain = $_POST['dental_pain'];
	$dental_pain_describe = $_POST['dental_pain_describe'];
	$completed_future = $_POST['completed_future'];
	$clinch_grind = $_POST['clinch_grind'];
	$wisdom_extraction = $_POST['wisdom_extraction'];
	$jawjointsurgery = $_POST['jawjointsurgery'];
$injurytohead = $_POST['injurytohead'];
	$injurytoface = $_POST['injurytoface'];
	$injurytoneck = $_POST['injurytoneck'];
	$injurytoteeth = $_POST['injurytoteeth'];
	$injurytomouth = $_POST['injurytomouth'];
	$drymouth = $_POST['drymouth'];
	$no_allergens = $_POST['no_allergens'];
	$no_medications = $_POST['no_medications'];
	$no_history = $_POST['no_history'];
	$orthodontics = $_POST['orthodontics'];
        $premedcheck = $_POST["premedcheck"];
 	$premed = $_POST["premeddet"];
	$family_hd = $_POST['family_hd'];
	$family_bp = $_POST['family_bp'];
	$family_dia = $_POST['family_dia'];
	$family_sd = $_POST['family_sd'];
	$alcohol = $_POST['alcohol'];
	$sedative = $_POST['sedative'];
	$caffeine = $_POST['caffeine'];
	$smoke = $_POST['smoke'];
	$smoke_packs = $_POST['smoke_packs'];
	$tobacco = $_POST['tobacco'];
	$additional_paragraph = $_POST['additional_paragraph'];
	$wisdom_extraction_text = $_POST['wisdom_extraction_text']; 
        $removable_text  = $_POST['removable_text'];
        $dentures  = $_POST['dentures'];
        $dentures_text  = $_POST['dentures_text'];
        $tmj_cp  = $_POST['tmj_cp'];
        $tmj_cp_text  = $_POST['tmj_cp_text'];
        $tmj_pain  = $_POST['tmj_pain'];
        $tmj_pain_text  = $_POST['tmj_pain_text'];
        $tmj_surgery  = $_POST['tmj_surgery'];
        $tmj_surgery_text  = $_POST['tmj_surgery_text'];
        $injury  = $_POST['injury'];
        $injury_text  = $_POST['injury_text'];
        $gum_prob  = $_POST['gum_prob'];
        $gum_prob_text  = $_POST['gum_prob_text'];
        $gum_surgery  = $_POST['gum_surgery'];
        $gum_surgery_text  = $_POST['gum_surgery_text'];
        $clinch_grind_text  = $_POST['clinch_grind_text'];
        $future_dental_det = $_POST['future_dental_det'];
	$drymouth_text = $_POST['drymouth_text'];


	
	$allergens_arr = '';
	if(is_array($allergens))
	{
		foreach($allergens as $val)
		{
			if(trim($val) <> '')
				$allergens_arr .= trim($val).'~';
		}
	}
	
	if($allergens_arr != '')
		$allergens_arr = '~'.$allergens_arr;
		
	$medications_arr = '';
	if(is_array($medications))
	{
		foreach($medications as $val)
		{
			if(trim($val) <> '')
				$medications_arr .= trim($val).'~';
		}
	}
	
	if($medications_arr != '')
		$medications_arr = '~'.$medications_arr;
		
	$history_arr = '';
	if(is_array($history))
	{
		foreach($history as $val)
		{
			if(trim($val) <> '')
				$history_arr .= trim($val).'~';
		}
	}
	
	if($history_arr != '')
		$history_arr = '~'.$history_arr;
	
	
	/*echo "allergens - ".$allergens_arr."<br>";
	echo "other_allergens - ".$other_allergens."<br>";
	echo "medications - ".$medications_arr."<br>";
	echo "other_medications - ".$other_medications."<br>";
	echo "history - ".$history_arr."<br>";
	echo "other_history - ".$other_history."<br>";
	echo "dental_health - ".$dental_health."<br>";
	echo "removable - ".$removable."<br>";
	echo "year_completed - ".$year_completed."<br>";
	echo "tmj - ".$tmj."<br>";
	echo "gum_problems - ".$gum_problems."<br>";
	echo "dental_pain - ".$dental_pain."<br>";
	echo "dental_pain_describe - ".$dental_pain_describe."<br>";
	echo "completed_future - ".$completed_future."<br>";
	echo "clinch_grind - ".$clinch_grind."<br>";
	echo "wisdom_extraction - ".$wisdom_extraction."<br>";
	echo "no_allergens - ".$no_allergens."<br>";
	echo "no_medications - ".$no_medications."<br>";
	echo "no_history - ".$no_history."<br>";
	echo "orthodontics - ".$orthodontics."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_page3 set 
		patientid = '".s_for($_GET['pid'])."',
		allergens = '".s_for($allergens_arr)."',
		other_allergens = '".s_for($other_allergens)."',
		medications = '".s_for($medications_arr)."',
		other_medications = '".s_for($other_medications)."',
		history = '".s_for($history_arr)."',
		other_history = '".s_for($other_history)."',
		dental_health = '".s_for($dental_health)."',
		removable = '".s_for($removable)."',
		injurytohead = '".s_for($injurytohead)."',
    injurytoface = '".s_for($injurytoface)."',
	  injurytoneck = '".s_for($injurytoneck)."',
	  injurytoteeth = '".s_for($injurytoteeth)."',
	  injurytomouth = '".s_for($injurytomouth)."',
	  drymouth = '".s_for($drymouth)."',
		year_completed = '".s_for($year_completed)."',
		tmj = '".s_for($tmj)."',
		gum_problems = '".s_for($gum_problems)."',
		dental_pain = '".s_for($dental_pain)."',
		dental_pain_describe = '".s_for($dental_pain_describe)."',
		completed_future = '".s_for($completed_future)."',
		clinch_grind = '".s_for($clinch_grind)."',
		wisdom_extraction = '".s_for($wisdom_extraction)."',
		jawjointsurgery = '".s_for($jawjointsurgery)."',
		no_allergens = '".s_for($no_allergens)."',
		no_medications = '".s_for($no_medications)."',
		no_history = '".s_for($no_history)."',
		orthodontics = '".s_for($orthodontics)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		family_hd = '".s_for($family_hd)."',
                family_bp = '".s_for($family_bp)."',
                family_dia = '".s_for($family_dia)."',
	        family_sd = '".s_for($family_sd)."',	
		alcohol = '".s_for($alcohol)."',
                sedative = '".s_for($sedative)."',
                caffeine = '".s_for($caffeine)."',
                smoke = '".s_for($smoke)."',
                smoke_packs = '".s_for($smoke_packs)."',
                tobacco = '".s_for($tobacco)."',
                additional_paragraph = '".s_for($additional_paragraph)."',
		wisdom_extraction_text  = '".s_for($wisdom_extraction_text)."',
		removable_text  = '".s_for($removable_text)."',
		dentures  = '".s_for($dentures)."',
		dentures_text  = '".s_for($dentures_text)."',
		tmj_cp  = '".s_for($tmj_cp)."',
		tmj_cp_text  = '".s_for($tmj_cp_text)."',
		tmj_pain  = '".s_for($tmj_pain)."',
		tmj_pain_text  = '".s_for($tmj_pain_text)."',
		tmj_surgery  = '".s_for($tmj_surgery)."',
		tmj_surgery_text  = '".s_for($tmj_surgery_text)."',
		injury  = '".s_for($injury)."',
		injury_text  = '".s_for($injury_text)."',
		gum_prob  = '".s_for($gum_prob)."',
		gum_prob_text  = '".s_for($gum_prob_text)."',
		gum_surgery  = '".s_for($gum_surgery)."',
		gum_surgery_text  = '".s_for($gum_surgery_text)."',
		clinch_grind_text  = '".s_for($clinch_grind_text)."',
		future_dental_det = '".s_for($future_dental_det)."',
		drymouth_text = '".s_for($drymouth_text)."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());

		$ped_sql = "update dental_patients 
                	set		
			premedcheck = '".s_for($_POST["premedcheck"])."',
                	premed = '".s_for($_POST["premeddet"])."'
                	where 
                	patientid='".$_GET["pid"]."'";
                mysql_query($ped_sql) or die($ped_sql." | ".mysql_error());

		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page3 set 
		allergens = '".s_for($allergens_arr)."',
		other_allergens = '".s_for($other_allergens)."',
		medications = '".s_for($medications_arr)."',
		other_medications = '".s_for($other_medications)."',
		history = '".s_for($history_arr)."',
		other_history = '".s_for($other_history)."',
		dental_health = '".s_for($dental_health)."',
		injurytohead = '".$injurytohead."',
		injurytoface = '".s_for($injurytoface)."',
	  injurytoneck = '".s_for($injurytoneck)."',
	  injurytoteeth = '".s_for($injurytoteeth)."',
	  injurytomouth = '".s_for($injurytomouth)."',
	  drymouth = '".s_for($drymouth)."',
		removable = '".s_for($removable)."',
		year_completed = '".s_for($year_completed)."',
		tmj = '".s_for($tmj)."',
		gum_problems = '".s_for($gum_problems)."',
		dental_pain = '".s_for($dental_pain)."',
		dental_pain_describe = '".s_for($dental_pain_describe)."',
		completed_future = '".s_for($completed_future)."',
		clinch_grind = '".s_for($clinch_grind)."',
		wisdom_extraction = '".s_for($wisdom_extraction)."',
		jawjointsurgery = '".s_for($jawjointsurgery)."',
		no_allergens = '".s_for($no_allergens)."',
		no_medications = '".s_for($no_medications)."',
		no_history = '".s_for($no_history)."',
		orthodontics = '".s_for($orthodontics)."',
                family_hd = '".s_for($family_hd)."',
                family_bp = '".s_for($family_bp)."',
                family_dia = '".s_for($family_dia)."',
		family_sd = '".s_for($family_sd)."',
                alcohol = '".s_for($alcohol)."',
                sedative = '".s_for($sedative)."',
                caffeine = '".s_for($caffeine)."',
                smoke = '".s_for($smoke)."',
                smoke_packs = '".s_for($smoke_packs)."',
                tobacco = '".s_for($tobacco)."',
                additional_paragraph = '".s_for($additional_paragraph)."',
                wisdom_extraction_text  = '".s_for($wisdom_extraction_text)."',
                removable_text  = '".s_for($removable_text)."',
                dentures  = '".s_for($dentures)."',
                dentures_text  = '".s_for($dentures_text)."',
                tmj_cp  = '".s_for($tmj_cp)."',
                tmj_cp_text  = '".s_for($tmj_cp_text)."',
                tmj_pain  = '".s_for($tmj_pain)."',
                tmj_pain_text  = '".s_for($tmj_pain_text)."',
                tmj_surgery  = '".s_for($tmj_surgery)."',
                tmj_surgery_text  = '".s_for($tmj_surgery_text)."',
                injury  = '".s_for($injury)."',
                injury_text  = '".s_for($injury_text)."',
                gum_prob  = '".s_for($gum_prob)."',
                gum_prob_text  = '".s_for($gum_prob_text)."',
                gum_surgery  = '".s_for($gum_surgery)."',
                gum_surgery_text  = '".s_for($gum_surgery_text)."',
                clinch_grind_text  = '".s_for($clinch_grind_text)."',
                future_dental_det = '".s_for($future_dental_det)."',
                drymouth_text = '".s_for($drymouth_text)."'
		where q_page3id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		$ped_sql = "update dental_patients 
                        set             
                        premedcheck = '".s_for($_POST["premedcheck"])."',
                        premed = '".s_for($_POST["premeddet"])."' 
                        where 
                        patientid='".$_GET["pid"]."'";
                mysql_query($ped_sql) or die($ped_sql." | ".mysql_error());
		//echo $ed_sql;
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
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
$sql = "select * from dental_q_page3 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page3id = st($myarray['q_page3id']);
$allergens = st($myarray['allergens']);
$other_allergens = st($myarray['other_allergens']);
$medications = st($myarray['medications']);
$other_medications = st($myarray['other_medications']);
$history = st($myarray['history']);
$other_history = st($myarray['other_history']);
$dental_health = st($myarray['dental_health']);
$injurytohead = st($myarray['injurytohead']);
	$injurytoface = st($myarray['injurytoface']);
	$injurytoneck = st($myarray['injurytoneck']);
	$injurytoteeth = st($myarray['injurytoteeth']);
	$injurytomouth = st($myarray['injurytomouth']);
	$drymouth = st($myarray['drymouth']);
$removable = st($myarray['removable']);
$year_completed = st($myarray['year_completed']);
$tmj = st($myarray['tmj']);
$gum_problems = st($myarray['gum_problems']);
$dental_pain = st($myarray['dental_pain']);
$dental_pain_describe = st($myarray['dental_pain_describe']);
$completed_future = st($myarray['completed_future']);
$clinch_grind = st($myarray['clinch_grind']);
$wisdom_extraction = st($myarray['wisdom_extraction']);
$jawjointsurgery = st($myarray['jawjointsurgery']);
$no_allergens = st($myarray['no_allergens']);
$no_medications = st($myarray['no_medications']);
$no_history = st($myarray['no_history']);
$orthodontics = st($myarray['orthodontics']);
$psql = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'";
$pmy = mysql_query($psql);
$pmyarray = mysql_fetch_array($pmy);
$premedcheck = st($pmyarray["premedcheck"]);
$premeddet = st($pmyarray["premed"]);
$family_hd = st($myarray["family_hd"]);
$family_bp = st($myarray["family_bp"]);
$family_dia = st($myarray["family_dia"]);
$family_sd = st($myarray["family_sd"]);
$alcohol = st($myarray['alcohol']);
$sedative = st($myarray['sedative']);
$caffeine = st($myarray['caffeine']);
$smoke = st($myarray['smoke']);
$smoke_packs = st($myarray['smoke_packs']);
$tobacco = st($myarray['tobacco']);
$additional_paragraph = st($myarray['additional_paragraph']);
        $wisdom_extraction_text = $myarray['wisdom_extraction_text'];
        $removable_text  = $myarray['removable_text'];
        $dentures  = $myarray['dentures'];
        $dentures_text  = $myarray['dentures_text'];
        $tmj_cp  = $myarray['tmj_cp'];
        $tmj_cp_text  = $myarray['tmj_cp_text'];
        $tmj_pain  = $myarray['tmj_pain'];
        $tmj_pain_text  = $myarray['tmj_pain_text'];
        $tmj_surgery  = $myarray['tmj_surgery'];
        $tmj_surgery_text  = $myarray['tmj_surgery_text'];
        $injury  = $myarray['injury'];
        $injury_text  = $myarray['injury_text'];
        $gum_prob  = $myarray['gum_prob'];
        $gum_prob_text  = $myarray['gum_prob_text'];
        $gum_surgery  = $myarray['gum_surgery'];
        $gum_surgery_text  = $myarray['gum_surgery_text'];
        $clinch_grind_text  = $myarray['clinch_grind_text'];
        $future_dental_det = $myarray['future_dental_det'];
	$drymouth_text = $myarray['drymouth_text'];

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>
<style type="text/css">
label {
  width: 250px;
  float:left;
}
</style>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

<? include("includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<script type="text/javascript">
	function chk_allergens()
	{
		fa = document.q_page3frm;
		
		chk_l = document.getElementsByName('allergens[]').length;
		
		if(fa.no_allergens.checked)
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('allergens[]')[i].disabled = true;
			}
			fa.other_allergens.disabled = true;
		}
		else
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('allergens[]')[i].disabled = false;
			}
			fa.other_allergens.disabled = false;
		}
	}
	
	function chk_medications()
	{
		fa = document.q_page3frm;
		
		chk_l = document.getElementsByName('medications[]').length;
		
		if(fa.no_medications.checked)
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('medications[]')[i].disabled = true;
			}
			fa.other_medications.disabled = true;
		}
		else
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('medications[]')[i].disabled = false;
			}
			fa.other_medications.disabled = false;
		}
	}
	
	function chk_history()
	{
		fa = document.q_page3frm;
		
		chk_l = document.getElementsByName('history[]').length;
		
		if(fa.no_history.checked)
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('history[]')[i].disabled = true;
			}
			fa.other_history.disabled = true;
		}
		else
		{
			for(var i=0; i<chk_l; i++)
			{
				document.getElementsByName('history[]')[i].disabled = false;
			}
			fa.other_history.disabled = false;
		}
	}
	
	function chk_ortho()
	{
		fa = document.q_page3frm;
		if(fa.orthodontics[1].checked)
		{
			fa.year_completed.disabled = true;
		}
		else
		{
			fa.year_completed.disabled = false;
		}
	}
	
</script>

<form id="q_page3frm" name="q_page3frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post" >
<input type="hidden" name="q_page3sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page3id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
<tr>
                <td valign="top" colspan="2" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">     
                        <label class="desc" id="title0" for="Field0" style="width:90%;">
                            Premedication
                            <span id="req_0" class="req">*</span>
                        </label><br />
                        <div>
                            <span>
                                Have you been told you should receive pre medication before dental procedures?
				<input id="premedcheck" name="premedcheck" tabindex="5" type="radio"  <?php if($premedcheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='block'" value="1" /> Yes 
				<input id="premedcheck" name="premedcheck" tabindex="5" type="radio"  <?php if($premedcheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='none'" value="0" /> No 
                                
                            </span>
                            <span id="pm_det" <?php if($premedcheck == 0){ echo 'style="display:none;"';} ?>>
				I require pre-medication due to:<br />
                                <textarea name="premeddet" id="premeddet" class="field text addr tbox" style="width:610px;" tabindex="18" ><?=$premeddet;?></textarea>
                            </span>
                          
                       </div>   
                    </li>
                </ul>
            </td>
        </tr>
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Allergens
                    </label>
                    <div>
                        <span class="full">
                        	<span style="color:#000000; padding-top:0px;">
                            	Please list everything you are allergic to: <br />
                            </span><br />
                            <textarea name="other_allergens" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_allergens;?></textarea>
                        </span>
                    </div>
                   	<br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Medications currently being taken
                    </label>
                    <div>
                        <span class="full">
                        	<span style="color:#000000; padding-top:0px;">
                            	Please list all medication you are currently taking: <br />
                            </span><br />
                            <textarea name="other_medications" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_medications;?></textarea>
                        </span>
                    </div>
                   	<br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Medical History
                    </label>
                    <div>
                        <span class="full">
                        	<span style="color:#000000; padding-top:0px;">
                            	List all other medical diagnoses and surgeries from birth until now:<br />
                            </span><br />
                            <textarea name="other_history" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_history;?></textarea>
                        </span>
                    </div>
                   	<br />
                    
                </li>
            </ul>
        </td>
    </tr>
	
	 <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Dental History
                    </label>
                    <div>
                        <span class="full">
							How would you describe your dental health?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="dental_health" style="width:250px;">
                            	<option value=""></option>
                                <option value="Excellent" <? if($dental_health == 'Excellent' ) echo " selected";?>>
                                	Excellent
                                </option>
                                <option value="Good" <? if($dental_health == 'Good' ) echo " selected";?>>
                                	Good
                                </option>
                                <option value="Fair" <? if($dental_health == 'Fair' ) echo " selected";?>>
                                	Fair
                                </option>
                                <option value="Poor" <? if($dental_health == 'Poor' ) echo " selected";?>>
                                	Poor
                                </option>
                            </select>
						</span>
					</div>
					<br />
					<script type="text/javascript">

						$('document').ready( function(){

							$('.extra').each(function(){
								var v = $(this).val();
								var n = $(this).attr('name');
								var c = $(this).attr('checked');
								if(v=="Yes"){
									if(c){
										$('#'+n+'_extra').css('display', 'inline');
									}else{
										$('#'+n+'_extra').css('display', 'none');
									}
								}
										
							});

						});
						$(function(){
						$('.extra').click(function(e){
							var v = e.target.value;
							var n = e.target.name;
							if(v=="Yes"){
								$('#'+n+'_extra').css('display', 'inline');
							}else{
                                                                $('#'+n+'_extra').css('display', 'none');
							}
						});
						})

					</script>
					<div>
                        <span>
							<label>Have you ever had teeth extracted?</label>
							
							<input type="radio" class="extra" name="wisdom_extraction" value="Yes" <? if($wisdom_extraction == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="wisdom_extraction" value="No" <? if($wisdom_extraction == 'No') echo " checked";?> />No
                                                        <span id="wisdom_extraction_extra">Please describe: <input type="text" class="field text addr tbox" id="wisdom_extraction_text" name="wisdom_extraction_text" value="<?= $wisdom_extraction_text; ?>" />
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<label>Do you wear removable partials?</label>
							
							<input type="radio" class="extra" name="removable" value="Yes" <? if($removable == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="removable" value="No" <? if($removable == 'No') echo " checked";?> />No
                                                        <span id="removable_extra">Please describe: <input type="text" class="field text addr tbox" id="removable_text" name="removable_text" value="<?= $removable_text; ?>" /></span>
						</span>
					</div>
					<br />
                                       <div>
                        <span>
                                                        <label>Do you wear dentures?</label>

                                                        <input type="radio" class="extra" name="dentures" value="Yes" <? if($dentures == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="dentures" value="No" <? if($dentures == 'No') echo " checked";?> />No
                                                        <span id="dentures_extra">Please describe: <input type="text" class="field text addr tbox" id="dentures_text" name="dentures_text" value="<?= $dentures_text; ?>" /></span>
                                                </span>
                                        </div>
                                        <br />

					
					<div>
                        <span>
							<label>Have you worn orthodontics (braces)?</label>
							
							<input type="radio" class="extra" name="orthodontics" value="Yes" <? if($orthodontics == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="orthodontics" value="No" <? if($orthodontics == 'No') echo " checked";?>  />No
                            				<span id="orthodontics_extra">Year completed: <input id="year_completed" name="year_completed" type="text" class="field text addr tbox" value="<?=$year_completed;?>" maxlength="255" style="width:225px;" /></span> 
						</span>
					</div>
					<br />
					
                                        <div>
                        <span>
                                                        <label>Does your TMJ (jaw joint) click or pop?</label>
                                                        <input type="radio" class="extra" name="tmj_cp" value="Yes" <? if($tmj_cp == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="tmj_cp" value="No" <? if($tmj_cp == 'No') echo " checked";?> />No
                                                        <span id="tmj_cp_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_cp_text" name="tmj_cp_text" value="<?= $tmj_cp_text; ?>" /></span>
                                                </span>
                                        </div>
                                        <br />
                                        <div>
                        <span>
							<label>Do you have pain In this joint?</label>
                                                        <input type="radio" class="extra" name="tmj_pain" value="Yes" <? if($tmj_pain == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="tmj_pain" value="No" <? if($tmj_pain == 'No') echo " checked";?> />No
                                                        <span id="tmj_pain_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_pain_text" name="tmj_pain_text" value="<?= $tmj_pain_text; ?>" /></span>
                                                </span>
                                        </div>
                                        <br />

					<div>
                        <span>
							<label>Have you had TMJ (jaw joint) surgery?</label>
							<input type="radio" class="extra" name="tmj_surgery" value="Yes" <? if($tmj_surgery == 'Yes') echo " checked";?> />Yes
							
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" class="extra" name="tmj_surgery" value="No" <? if($tmj_surgery == 'No') echo " checked";?> />No
							<span id="tmj_surgery_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_surgery_text" name="tmj_surgery_text" value="<?= $tmj_surgery_text; ?>" /></span>

						</span>
					</div>
					<br />
				                                        <div>
                        <span>
                                                        <label>Have you ever had injury to your head, face, neck, mouth, or teeth?</label>

                                                        <input type="radio" class="extra" name="injury" value="Yes" <? if($injury == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="injury" value="No" <? if($injury == 'No') echo " checked";?> />No
							<span id="injury_extra">Please describe: <input type="text" class="field text addr tbox" id="injury_text" name="injury_text" value="<?= $injury_text; ?>" /></span>
                                                </span>
                                        </div>
                                        <br />	
					<div>
                        <span>
							<label>Do you have morning dry mouth?</label>
							
							<input type="radio" class="extra" name="drymouth" value="Yes" <? if($drymouth == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="drymouth" value="No" <? if($drymouth == 'No') echo " checked";?> />No
                                                        <span id="drymouth_extra">Please describe: <input type="text" class="field text addr tbox" id="drymouth_text" name="drymouth_text" value="<?= $drymouth_text; ?>" /></span>							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<label>Have you ever had gum problems?</label>
                            <input id="gum_prob" name="gum_prob" type="radio" class="extra" value="Yes" <?= ($gum_prob=='Yes')?'checked="checked"':'';?> /> Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="gum_prob" name="gum_prob" type="radio" class="extra" value="No" <?= ($gum_prob=='No')?'checked="checked"':'';?> /> No 
                                                        <span id="gum_prob_extra">Please describe: <input type="text" class="field text addr tbox" id="gum_prob_text" name="gum_prob_text"  value="<?= $gum_prob_text; ?>" /></span> 
						</span>
					</div>
					<br />
					
					                                        
                                        <div>
                        <span>
                                                        <label>Have you ever had gum surgery?</label>

                                                        <input type="radio" class="extra" name="gum_surgery" value="Yes" <? if($gum_surgery == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="gum_surgery" value="No" <? if($gum_surgery == 'No') echo " checked";?> />No
							<span id="gum_surgery_extra">Please describe: <input type="text" class="field text addr tbox" id="gum_surgery_text" name="gum_surgery_text" value="<?= $gum_surgery_text; ?>" /></span>
                                                </span>
                                        </div>
                                        <br />

					
					<div>
                        <span>
							<label>Are you planning to have dental work done in the near future?</label>
							
	
							<input type="radio" class="extra" name="completed_future" value="Yes" <? if($completed_future == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="completed_future" value="No" <? if($completed_future == 'No') echo " checked";?> />No
							
<span id="completed_future_extra">Please describe: <input type="text" class="field text addr tbox" id="future_dental_det" name="future_dental_det"  value="<?= $future_dental_det; ?>" /></span>
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<label>Do you clinch or grind your teeth?</label>
							
							<input type="radio" class="extra" name="clinch_grind" value="Yes" <? if($clinch_grind == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="clinch_grind" value="No" <? if($clinch_grind == 'No') echo " checked";?> />No
							<span id="clinch_grind_extra">Please describe: <input type="text" class="field text addr tbox" id="clinch_grind_text" name="clinch_grind_text" value="<?= $clinch_grind_text; ?>" /></span>
						</span>
					</div>
					<br />

					<br />
					
				</li>
			</ul>
		</td>
	</tr>
	<tr>
        <td valign="top" class="frmhead">
                <ul>
                                <li id="foli8" class="complex">
                    <label class="desc" id="title0" for="Field0">
                        Family History
                    </label>
                    <div>
                        <span class="full">
				<label>Have genetic members of your family had Heart Disease?</label>
                                                <input type="radio" name="family_hd" value="Yes" style="width:10px;" <?= ($family_hd == "Yes")?'checked="checked"':''; ?> /> Yes
						<input type="radio" name="family_hd" value="No" style="width:10px;" <?= ($family_hd == "No")?'checked="checked"':''; ?> /> No
			</span>
		    </div>
		    <div>
			<span>					                                            
				<label>High Blood Pressure?</label>
                                                <input type="radio" name="family_bp" value="Yes" style="width:10px;" <?= ($family_bp == "Yes")?'checked="checked"':''; ?> /> Yes
                                                <input type="radio" name="family_bp" value="No" style="width:10px;" <?= ($family_bp == "No")?'checked="checked"':''; ?> /> No
			</span>
		    </div>
		    <div>
			<span>
			     <label>Diabetes?</label>
                                                <input type="radio" name="family_dia" value="Yes" style="width:10px;" <?= ($family_dia == "Yes")?'checked="checked"':''; ?> /> Yes
                                                <input type="radio" name="family_dia" value="No" style="width:10px;" <?= ($family_dia == "No")?'checked="checked"':''; ?> /> No
                                        </span>
		</div>
		<div>
			<span>
				<label>Have any genetic members of your family been diagnosed or treated for a sleep disorder?</label>
				<input type="radio" name="family_sd" value="Yes" style="width:10px;" <?= ($family_sd == "Yes")?'checked="checked"':''; ?> /> Yes
                                <input type="radio" name="family_sd" value="No" style="width:10px;" <?= ($family_sd == "No")?'checked="checked"':''; ?> /> No
                        </span>

    </li>
	</ul>
	</td>
</tr>
    <tr>
        <td valign="top" class="frmhead">
                <ul>
                                <li id="foli8" class="complex">
                    <label class="desc" id="title0" for="Field0">
                        SOCIAL HISTORY
                    </label>
                    <div>
                        <span class="full">
                                Alcohol consumption: How often do you consume alcohol within 2-3 hours of bedtime?
                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="alcohol" value="Daily" class="tbox" style="width:10px;" <? if($alcohol == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="1/day" class="tbox" style="width:10px;" <? if($alcohol == '1/day')  echo " checked";?> />
                            1/Day
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="several days/week" class="tbox" style="width:10px;" <? if($alcohol == 'several days/week')  echo " checked";?> />
                            Several Days/Week
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="occasionally" class="tbox" style="width:10px;" <? if($alcohol == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="never" class="tbox" style="width:10px;" <? if($alcohol == 'never')  echo " checked";?> />
                            Never
                            <br /><br />

                            Sedative Consumption: How often do you take sedatives within 2-3 hours of bedtime?
                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="sedative" value="Daily" class="tbox" style="width:10px;" <? if($sedative == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="sedative" value="1/day" class="tbox" style="width:10px;" <? if($sedative == '1/day')  echo " checked";?> />
                            1/Day
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="several days/week" class="tbox" style="width:10px;" <? if($sedative == 'several days/week')  echo " checked";?> />
                            Several Days/Week
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="occasionally" class="tbox" style="width:10px;" <? if($sedative == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="never" class="tbox" style="width:10px;" <? if($sedative == 'never')  echo " checked";?> />
                            Never
                            <br /><br />


                            Caffeine consumption: How often do you consume caffeine within 2-3 hours of bedtime?
                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="caffeine" value="Daily" class="tbox" style="width:10px;" <? if($caffeine == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="1/day" class="tbox" style="width:10px;" <? if($caffeine == '1/day')  echo " checked";?> />
                            1/Day
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="several days/week" class="tbox" style="width:10px;" <? if($caffeine == 'several days/week')  echo " checked";?> />
                            Several Days/Week
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="occasionally" class="tbox" style="width:10px;" <? if($caffeine == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="never" class="tbox" style="width:10px;" <? if($caffeine == 'never')  echo " checked";?> />
                            Never
                            <br /><br />
                            Do you Smoke?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="smoke" value="Yes" class="tbox" style="width:10px;" <? if($smoke == 'Yes')  echo " checked";?>  onclick="displaysmoke();" />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="smoke" value="No" class="tbox" style="width:10px;" <? if($smoke == 'No')  echo " checked";?> onclick="hidesmoke();" />
                            No
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div id="smoke">If Yes, number of packs per day
                            <input type="text" name="smoke_packs" value="<?=$smoke_packs?>" class="tbox" style="width:50px;" />
                            </div>
                            <br /><br />

                            Do you use Chewing Tobacco?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="tobacco" value="Yes" class="tbox" style="width:10px;" <? if($tobacco == 'Yes')  echo " checked";?> />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="tobacco" value="No" class="tbox" style="width:10px;" <? if($tobacco == 'No')  echo " checked";?> />
                            No

                        </span>
                                        </div>
		<br /><br />
                    <div>
                        <span>
				Additional Paragraph<br />
                            <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                        </span>
                    </div>

                    <br />
                                </li>
                        </ul>
                </td>
        </tr>

</table>

<div align="right">
	<input type="reset" value="Reset" />
    <input type="submit" name="q_pagebtn" value="Save" tabindex="12" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

<script type="text/javascript">
	chk_allergens();
	chk_medications();
	chk_history();
	chk_ortho();
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

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>

<? include "includes/bottom.htm";?>
