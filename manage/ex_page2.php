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
		$('#ex_page2frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['ex_page2sub'] == 1)
{
	$mallampati = $_POST['mallampati'];
	$tonsils = $_POST['tonsils'];
	$tonsils_grade = $_POST['tonsils_grade'];
	
	$tonsils_arr = '';
	if(is_array($tonsils))
	{
		foreach($tonsils as $val)
		{
			if(trim($val) <> '')
				$tonsils_arr .= trim($val).'~';
		}
	}
	
	if($tonsils_arr != '')
		$tonsils_arr = '~'.$tonsils_arr;
	
	/*echo "mallampati - ".$mallampati."<br>";
	echo "tonsils - ".$tonsils_arr."<br>";
	echo "tonsils_grade - ".$tonsils_grade."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page2 set 
		patientid = '".s_for($_GET['pid'])."',
		mallampati = '".s_for($mallampati)."',
		tonsils = '".s_for($tonsils_arr)."',
		tonsils_grade = '".s_for($tonsils_grade)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
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
		$ed_sql = " update dental_ex_page2 set 
		mallampati = '".s_for($mallampati)."',
		tonsils = '".s_for($tonsils_arr)."',
		tonsils_grade = '".s_for($tonsils_grade)."'
		where ex_page2id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
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

$sql = "select * from dental_ex_page2 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page2id = st($myarray['ex_page2id']);
$mallampati = st($myarray['mallampati']);
$tonsils = st($myarray['tonsils']);
$tonsils_grade = st($myarray['tonsils_grade']);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

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

<form id="ex_page2frm" name="ex_page2frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="ex_page2sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page2id;?>" />
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
                        AIRWAY EVALUATION(continued)
                        <br />
                        <span class="form_info">Mallampati Classification</span>
                        <br />
                    </label>
                    
                    <div>
                    	<span>
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<tr>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="images/class1.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class I" <? if($mallampati == 'Class I') echo " checked";?> /> Class I
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="images/class2.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class II" <? if($mallampati == 'Class II') echo " checked";?> /> Class II
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="images/class3.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class III" <? if($mallampati == 'Class III') echo " checked";?> /> Class III
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="images/class4.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class IV" <? if($mallampati == 'Class IV') echo " checked";?> /> Class IV
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
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        TONSILS
                    </label>
                    <div>
                        <span>
                        	<input type="checkbox" id="tonsils" name="tonsils[]" value="Present" <? if(strpos($tonsils,'~Present~') === false) {} else { echo " checked";}?> />
                            Present
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="tonsils" name="tonsils[]" value="Obstructive" <? if(strpos($tonsils,'~Obstructive~') === false) {} else { echo " checked";}?> />
                            Obstructive
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="tonsils" name="tonsils[]" value="Purulent" <? if(strpos($tonsils,'~Purulent~') === false) {} else { echo " checked";}?> />
                            Purulent
                        </span>
                   </div>   
                   <br />
                   
                   <div>
                    	<span>
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<tr>
                                	<td valign="top" width="20%" align="center">
                                    	<img src="images/grade0.jpg" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 0" <? if($tonsils_grade == 'Grade 0') echo " checked";?> /> Grade 0
                                        <br /><br />
                                        Absent
                                    </td>
                                	<td valign="top" width="20%" align="center">
                                    	<img src="images/grade1.jpg" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 1" <? if($tonsils_grade == 'Grade 1') echo " checked";?> /> Grade 1
                                        <br /><br />
                                        Small within the tonsillar fossa
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="images/grade0.jpg" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 2" <? if($tonsils_grade == 'Grade 2') echo " checked";?> /> Grade 2
                                        <br /><br />
                                        Extends beyond the tonsillar pillar
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="images/grade0.jpg" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 3" <? if($tonsils_grade == 'Grade 3') echo " checked";?> /> Grade 3
                                        <br /><br />
                                        Hypertrophic but not touching in midline
                                    </td>
                                	<td valign="top" width="20%" align="center">
                                    	<img src="images/grade0.jpg" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 4" <? if($tonsils_grade == 'Grade 4') echo " checked";?> /> Grade 4 
                                        <br /><br />
                                        Hypertrophic and touching in midline
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

<div align="right">
	<input type="reset" value="Reset" />
    <input type="submit" name="q_pagebtn" value="Save" />
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

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>



<? include "includes/bottom.htm";?>
