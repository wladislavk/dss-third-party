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
		$('#q_page4frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['q_page4sub'] == 1)
{
	$family_had = $_POST['family_had'];
	$family_diagnosed = $_POST['family_diagnosed'];
	$additional_paragraph = $_POST['additional_paragraph'];
	$alcohol = $_POST['alcohol'];
	$sedative = $_POST['sedative'];
	$caffeine = $_POST['caffeine'];
	$smoke = $_POST['smoke'];
	$smoke_packs = $_POST['smoke_packs'];
	$tobacco = $_POST['tobacco'];
	
	$family_had_arr = '';
	if(is_array($family_had))
	{
		foreach($family_had as $val)
		{
			if(trim($val) <> '')
				$family_had_arr .= trim($val).'~';
		}
	}
	
	if($family_had_arr != '')
		$family_had_arr = '~'.$family_had_arr;
	
	
	/*echo "family_had - ".$family_had_arr."<br>";
	echo "family_diagnosed - ".$family_diagnosed."<br>";
	echo "additional_paragraph - ".$additional_paragraph."<br>";
	echo "alcohol - ".$alcohol."<br>";
	echo "sedative - ".$sedative."<br>";
	echo "caffeine - ".$caffeine."<br>";
	echo "smoke - ".$smoke."<br>";
	echo "smoke_packs - ".$smoke_packs."<br>";
	echo "tobacco - ".$tobacco."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_page4 set 
		formid = '".s_for($_GET['fid'])."',
		patientid = '".s_for($_GET['pid'])."',
		family_had = '".s_for($family_had_arr)."',
		family_diagnosed = '".s_for($family_diagnosed)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		alcohol = '".s_for($alcohol)."',
		sedative = '".s_for($sedative)."',
		caffeine = '".s_for($caffeine)."',
		smoke = '".s_for($smoke)."',
		smoke_packs = '".s_for($smoke_packs)."',
		tobacco = '".s_for($tobacco)."',
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
		$ed_sql = " update dental_q_page4 set 
		family_had = '".s_for($family_had_arr)."',
		family_diagnosed = '".s_for($family_diagnosed)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		alcohol = '".s_for($alcohol)."',
		sedative = '".s_for($sedative)."',
		caffeine = '".s_for($caffeine)."',
		smoke = '".s_for($smoke)."',
		smoke_packs = '".s_for($smoke_packs)."',
		tobacco = '".s_for($tobacco)."'
		where q_page4id = '".s_for($_POST['ed'])."'";
		
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
		//window.location = 'manage_forms.php?pid=<?=$_GET['pid'];?>';
	</script>
	<?
	//die();
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
$sql = "select * from dental_q_page4 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page4id = st($myarray['q_page4id']);
$family_had = st($myarray['family_had']);
$family_diagnosed = st($myarray['family_diagnosed']);
$additional_paragraph = st($myarray['additional_paragraph']);
$alcohol = st($myarray['alcohol']);
$sedative = st($myarray['sedative']);
$caffeine = st($myarray['caffeine']);
$smoke = st($myarray['smoke']);
$smoke_packs = st($myarray['smoke_packs']);
$tobacco = st($myarray['tobacco']);
?>
<!--
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>
-->
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

<form id="q_page4frm" name="q_page4frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post" >
<input type="hidden" name="q_page4sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page4id;?>" />
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
                        Family History
                    </label>
                    <div>
                        <span class="full">
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<tr>
                                	<td valign="top" width="1%">
                                    	<span>
                                        	1.
                                        </span>
                                    </td>
                                	<td valign="top" width="50%">
                                    	<span>
                                        	Have genetic members of your family had:
                                        </span>
                                    </td>
                                    <td valign="top">
                                    	<span>
                                        	<input type="checkbox" name="family_had[]" value="Heart disease" class="tbox" style="width:10px;" <? if(strpos($family_had,'~Heart disease~') === false) {} else { echo " checked";}?> />
                                            Heart disease
                                            <br />
                                            
                                            <input type="checkbox" name="family_had[]" value="High Blood Pressure" class="tbox" style="width:10px;" <? if(strpos($family_had,'~High Blood Pressure~') === false) {} else { echo " checked";}?> />
                                            High Blood Pressure
                                            <br />
                                            
                                            <input type="checkbox" name="family_had[]" value="Diabetes" class="tbox" style="width:10px;" <? if(strpos($family_had,'~Diabetes~') === false) {} else { echo " checked";}?> />
                                            Diabetes
                                            <br />
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<span>
                                        	2.
                                        </span>
                                    </td>
                                	<td valign="top">
                                    	<span>
                                        	Have any immediate genetic family members been diagnosed or treated for a sleep disorder?
                                        </span>
                                    </td>
                                    <td valign="top">
                                    	<span>
                                        	<input type="radio" name="family_diagnosed" value="Yes" class="tbox" style="width:10px;" <? if($family_diagnosed == 'Yes')  echo " checked";?> />
                                            Yes
                                            
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="family_diagnosed" value="No" class="tbox" style="width:10px;" <? if($family_diagnosed == 'No')  echo " checked";?> />
                                            No
                                        </span>
                                    </td>
                                </tr>
                            </table>
                   			<br />
                    	</span>
					</div>
                    
                    Additional Paragraph
                    /
                    <!--<button onclick="Javascript: loadPopup('select_custom1.php'); return false;">Custom Text</button>-->
		    <button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=q_page4frm&tx=additional_paragraph'); return false;">Custom Text</button>
                    <div>
                        <span>
                            <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
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
                            <input type="radio" name="tobacco" value="Yes" class="tbox" style="width:10px;" <? if($smoke == 'Yes')  echo " checked";?> />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="radio" name="tobacco" value="No" class="tbox" style="width:10px;" <? if($smoke == 'No')  echo " checked";?> />
                            No

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

<br />
<? include("includes/form_bottom.htm");?>
<br />

<div id="popupRefer" style="width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>


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
