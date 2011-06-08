<?php 
include "includes/top.htm";
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
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
		formid = '".s_for($_GET['fid'])."',
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
		orthodontics = '".s_for($orthodontics)."'
		where q_page3id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql;
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
$sql = "select * from dental_q_page3 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
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

<form id="q_page3frm" name="q_page3frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post" >
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
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Allergens
                    </label>
                    <div>
                        <span class="full">
                        	<? 
							$allergens_sql = "select * from dental_allergens where status=1 order by sortby";
							$allergens_my = mysql_query($allergens_sql);
							?>
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<? 
								$i=0;
								while($allergens_myarray = mysql_fetch_array($allergens_my))
								{
									if($i == 0)
									{
										echo "<tr>";
									}
									?>
                                	<td valign="top" width="33%">
                                    	<span>
                                    		<input type="checkbox" name="allergens[]" value="<?=st($allergens_myarray['allergensid']);?>" class="tbox" style="width:10px;" <? if(strpos($allergens,'~'.st($allergens_myarray['allergensid']).'~') === false) {} else { echo " checked";}?> />
                                            <?=st($allergens_myarray['allergens']);?>
                                        </span>
                                    </td>
                                    <?
									$i++;
									if($i == 3)
									{
										echo "</tr>";
										$i = 0;
									}
                                    
								 }?>   
                                </tr>
								<tr>
									<td valign="top" >
										<input type="checkbox" name="no_allergens" value="1" <? if($no_allergens == 1) echo " checked";?> class="tbox" style="width:10px;" onclick="chk_allergens()" />Patient reported no known allergens
									</td>
								</tr>
                            </table>
                        </span>
                    </div>
                    <br />
                    
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
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
                        	<? 
							$medications_sql = "select * from dental_medications where status=1 order by sortby";
							$medications_my = mysql_query($medications_sql);
							?>
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<? 
								$i=0;
								while($medications_myarray = mysql_fetch_array($medications_my))
								{
									if($i == 0)
									{
										echo "<tr>";
									}
									?>
                                	<td valign="top" width="33%">
                                    	<span>
                                    		<input type="checkbox" name="medications[]" value="<?=st($medications_myarray['medicationsid']);?>" class="tbox" style="width:10px;" <? if(strpos($medications,'~'.st($medications_myarray['medicationsid']).'~') === false) {} else { echo " checked";}?> />
                                            <?=st($medications_myarray['medications']);?>
                                        </span>
                                    </td>
                                    <?
									$i++;
									if($i == 3)
									{
										echo "</tr>";
										$i = 0;
									}
								 }?>   
                                </tr>
								<tr>
									<td valign="top" >
										<input type="checkbox" name="no_medications" value="1" <? if($no_medications == 1) echo " checked";?> class="tbox" style="width:10px;" onclick="chk_medications()" />Patient reports taking no medications
									</td>
								</tr>
                            </table>
                        </span>
                    </div>
                    <br />
                    
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
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
                        	<? 
							$history_sql = "select * from dental_history where status=1 order by history";
							$history_my = mysql_query($history_sql);
							?>
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<? 
								$i=0;
								while($history_myarray = mysql_fetch_array($history_my))
								{
									if($i == 0)
									{
										echo "<tr>";
									}
									?>
                                	<td valign="top" width="33%">
                                    	<span>
                                    		<input type="checkbox" name="history[]" value="<?=st($history_myarray['historyid']);?>" class="tbox" style="width:10px;" <? if(strpos($history,'~'.st($history_myarray['historyid']).'~') === false) {} else { echo " checked";}?> />
                                            <?=st($history_myarray['history']);?>
                                        </span>
                                    </td>
                                    <?
									$i++;
									if($i == 3)
									{
										echo "</tr>";
										$i = 0;
									}
                                    
								 }?>   
                                </tr>
								<tr>
									<td valign="top" colspan="3" >
										<input type="checkbox" name="no_history" value="1" <? if($no_history == 1) echo " checked";?> class="tbox" style="width:10px;" onclick="chk_history()" />Patient reports no past medical history conditions
									</td>
								</tr>
                            </table>
                        </span>
                    </div>
                    <br />
                    
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
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
                        <span>
							How would you describe your dental health?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="dental_health" class="field text addr tbox">
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
					
					<div>
                        <span>
							Have you had wisdom teeth extracted?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="wisdom_extraction" value="Yes" <? if($wisdom_extraction == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="wisdom_extraction" value="No" <? if($wisdom_extraction == 'No') echo " checked";?> />No
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							Do you wear removable partials or dentures?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="removable" value="Yes" <? if($removable == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="removable" value="No" <? if($removable == 'No') echo " checked";?> />No
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Orthodontics (Braces)</b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="orthodontics" value="Yes" <? if($orthodontics == 'Yes') echo " checked";?>  onclick="chk_ortho()"  />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="orthodontics" value="No" <? if($orthodontics == 'No') echo " checked";?>  onclick="chk_ortho()" />No
							<br />
							Year completed
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="year_completed" name="year_completed" type="text" class="field text addr tbox" value="<?=$year_completed;?>" maxlength="255" style="width:225px;" /> 
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>TMJ (jaw joint)</b>
							<br />
							<input type="radio" name="tmj" value="Popping or clicking" <? if($tmj == 'Popping or clicking') echo " checked";?> />Popping or clicking
							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="tmj" value="Pain in joint or muscles" <? if($tmj == 'Pain in joint or muscles') echo " checked";?> />Pain in joint or muscles
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Have you had Jaw Joint Surgery?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="jawjointsurgery" value="Yes" <? if($jawjointsurgery == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="jawjointsurgery" value="No" <? if($jawjointsurgery == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Have you had an injury to your Head?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytohead" value="Yes" <? if($injurytohead == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytohead" value="No" <? if($injurytohead == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Have you had an injury to your Face?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytoface" value="Yes" <? if($injurytoface == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytoface" value="No" <? if($injurytoface == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Have you had an injury to your Neck?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytoneck" value="Yes" <? if($injurytoneck == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytoneck" value="No" <? if($injurytoneck == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Have you had an injury to your Mouth?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytomouth" value="Yes" <? if($injurytomouth == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytomouth" value="No" <? if($injurytomouth == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Have you had any teeth injuries?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytoteeth" value="Yes" <? if($injurytoteeth == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="injurytoteeth" value="No" <? if($injurytoteeth == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Do you have morning dry mouth?</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="drymouth" value="Yes" <? if($drymouth == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="drymouth" value="No" <? if($drymouth == 'No') echo " checked";?> />No
							
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							<b>Gum problems</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="gum_problems" name="gum_problems" type="text" class="field text addr tbox" value="<?=$gum_problems;?>" maxlength="255" style="width:225px;" /> 
						</span>
					</div>
					<br />
					
					
					
					<div>
                        <span>
							Are you planning on having any dental work completed in the near future?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
	
							<input type="radio" onclick="display();" name="completed_future" value="Yes" <? if($completed_future == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" onclick="hide();" name="completed_future" value="No" <? if($completed_future == 'No') echo " checked";?> />No
							
<input type="text" class="field text addr tbox" id="future_dental_det" name="future_dental_det" />
						</span>
					</div>
					<br />
					
					<div>
                        <span>
							Do you clinch or grind your teeth?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="clinch_grind" value="Yes" <? if($clinch_grind == 'Yes') echo " checked";?> />Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" name="clinch_grind" value="No" <? if($clinch_grind == 'No') echo " checked";?> />No
						</span>
					</div>
					<br />

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
<? include "includes/bottom.htm";?>
