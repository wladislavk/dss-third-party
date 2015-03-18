<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include "includes/patient_nav.php";
?>
<ul class="nav nav-tabs nav-justified">
        <li>
            <a href="patient_clinical_exam.php?pid=<?php echo  $_GET['pid']; ?>" id="link_summ">Dental Exam</a>
        </li>
        <li>
            <a href="patient_clinical_exam2.php?pid=<?php echo  $_GET['pid']; ?>" id="link_notes">Vital Data/Tongue</a>
        </li>
        <li class="active">
            <a href="patient_clinical_exam3.php?pid=<?php echo  $_GET['pid']; ?>" id="link_treatment">Mallampati/Tonsils</a>
        </li>
        <li>
            <a href="patient_clinical_exam4.php?pid=<?php echo  $_GET['pid']; ?>" id="link_treatment">Airway Evaluation</a>
        </li>
        <li>
            <a href="patient_clinical_exam5.php?pid=<?php echo  $_GET['pid']; ?>" id="link_treatment">TMJ/ROM</a>
        </li>
    </ul>

    <p>&nbsp;</p>

<?php
if(!empty($_POST['ex_page2sub']) && $_POST['ex_page2sub'] == 1)
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
		additional_notes = '".mysql_real_escape_string($_POST['additional_notes'])."',
		tonsils = '".s_for($tonsils_arr)."',
		tonsils_grade = '".s_for($tonsils_grade)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysqli_query($con,$ins_sql) or trigger_error($ins_sql." | ".mysql_error(), E_USER_ERROR);
		
		$msg = "Added Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?php echo $msg;?>");
                        window.location='ex_page3.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
		</script>
		<?
		}
		trigger_error("Die called", E_USER_ERROR);
	}
	else
	{
		$ed_sql = " update dental_ex_page2 set 
		mallampati = '".s_for($mallampati)."',
                additional_notes = '".mysql_real_escape_string($_POST['additional_notes'])."',
		tonsils = '".s_for($tonsils_arr)."',
		tonsils_grade = '".s_for($tonsils_grade)."'
		where ex_page2id = '".s_for($_POST['ed'])."'";
		
		mysqli_query($con,$ed_sql) or trigger_error($ed_sql." | ".mysql_error(), E_USER_ERROR);
		
		$msg = "Edited Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?php echo $msg;?>");
                        window.location='ex_page3.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
		</script>
		<?
		}
		trigger_error("Die called", E_USER_ERROR);
	}
}



$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con,$pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$sql = "select * from dental_ex_page2 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$ex_page2id = st($myarray['ex_page2id']);
$mallampati = st($myarray['mallampati']);
$additional_notes = $myarray['additional_notes'];
$tonsils = st($myarray['tonsils']);
$tonsils_grade = st($myarray['tonsils_grade']);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

<?php include("../includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form id="ex_page2frm" class="ex_form" name="ex_page2frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post">
<input type="hidden" name="ex_page2sub" value="1" />
<input type="hidden" name="ed" value="<?php echo $ex_page2id;?>" />
<input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />

<table width="98%" style="clear:both;" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
                                    	<img src="../images/class1.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class I" <?php if($mallampati == 'Class I') echo " checked";?> /> Class I
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="../images/class2.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class II" <?php if($mallampati == 'Class II') echo " checked";?> /> Class II
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="../images/class3.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class III" <?php if($mallampati == 'Class III') echo " checked";?> /> Class III
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="../images/class4.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class IV" <?php if($mallampati == 'Class IV') echo " checked";?> /> Class IV
                                    </td>
                                </tr>
                            </table>
                        </span>
			<span>
				Additional Notes<br />
				<textarea name="additional_notes" style="width:350px; height:187px"><?php echo  $additional_notes; ?></textarea></span>
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
                        	<input type="checkbox" id="tonsils" name="tonsils[]" value="Present" <?php if(strpos($tonsils,'~Present~') === false) {} else { echo " checked";}?> />
                            Present
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="tonsils" name="tonsils[]" value="Obstructive" <?php if(strpos($tonsils,'~Obstructive~') === false) {} else { echo " checked";}?> />
                            Obstructive
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="tonsils" name="tonsils[]" value="Purulent" <?php if(strpos($tonsils,'~Purulent~') === false) {} else { echo " checked";}?> />
                            Purulent
                        </span>
                   </div>   
                   <br />
                   
                   <div>
                    	<span>
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<tr>
                                	<td valign="top" width="20%" align="center">
                                    	<img src="../images/grade0.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 0" <?php if($tonsils_grade == 'Grade 0') echo " checked";?> /> Grade 0
                                        <br /><br />
                                        Absent
                                    </td>
                                	<td valign="top" width="20%" align="center">
                                    	<img src="../images/grade1.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 1" <?php if($tonsils_grade == 'Grade 1') echo " checked";?> /> Grade 1
                                        <br /><br />
                                        Small within the tonsillar fossa
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="../images/grade2.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 2" <?php if($tonsils_grade == 'Grade 2') echo " checked";?> /> Grade 2
                                        <br /><br />
                                        Extends beyond the tonsillar pillar
                                    </td>
                                	<td valign="top" width="25%" align="center">
                                    	<img src="../images/grade3.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 3" <?php if($tonsils_grade == 'Grade 3') echo " checked";?> /> Grade 3
                                        <br /><br />
                                        Hypertrophic but not touching in midline
                                    </td>
                                	<td valign="top" width="20%" align="center">
                                    	<img src="../images/grade4.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 4" <?php if($tonsils_grade == 'Grade 4') echo " checked";?> /> Grade 4 
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

</form>

<br />
<?php include("../includes/form_bottom.htm");?>
<br />



<?php include "includes/bottom.htm";?>
