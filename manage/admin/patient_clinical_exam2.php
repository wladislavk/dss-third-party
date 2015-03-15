<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include "includes/patient_nav.php";
?>
<ul class="nav nav-tabs nav-justified">
        <li>
            <a href="patient_clinical_exam.php?pid=<?= $_GET['pid']; ?>" id="link_summ">Dental Exam</a>
        </li>
        <li class="active">
            <a href="patient_clinical_exam2.php?pid=<?= $_GET['pid']; ?>" id="link_notes">Vital Data/Tongue</a>
        </li>
        <li>
            <a href="patient_clinical_exam3.php?pid=<?= $_GET['pid']; ?>" id="link_treatment">Mallampati/Tonsils</a>
        </li>
        <li>
            <a href="patient_clinical_exam4.php?pid=<?= $_GET['pid']; ?>" id="link_treatment">Airway Evaluation</a>
        </li>
        <li>
            <a href="patient_clinical_exam5.php?pid=<?= $_GET['pid']; ?>" id="link_treatment">TMJ/ROM</a>
        </li>
    </ul>

    <p>&nbsp;</p>

<?php
if(!empty($_POST['ex_page1sub']) && $_POST['ex_page1sub'] == 1)
{
	$blood_pressure = $_POST['blood_pressure'];
	$pulse = $_POST['pulse'];
	$neck_measurement = $_POST['neck_measurement'];
	$feet = $_POST['feet'];
	$inches = $_POST['inches'];
	$weight = $_POST['weight'];
	$bmi = $_POST['bmi'];
	$additional_paragraph = $_POST['additional_paragraph'];
	$tongue = $_POST['tongue'];
	
	$tongue_arr = '';
	if(is_array($tongue))
	{
		foreach($tongue as $val)
		{
			if(trim($val) <> '')
				$tongue_arr .= trim($val).'~';
		}
	}
	
	if($tongue_arr != '')
		$tongue_arr = '~'.$tongue_arr;
	
	/*echo "blood_pressure - ".$blood_pressure."<br>";
	echo "pulse - ".$pulse."<br>";
	echo "bmi - ".$bmi."<br>";
	echo "neck_measurement - ".$neck_measurement."<br>";
	echo "additional_paragraph - ".$additional_paragraph."<br>";
	echo "tongue - ".$tongue_arr."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page1 set 
		patientid = '".s_for($_GET['pid'])."',
		blood_pressure = '".s_for($blood_pressure)."',
		pulse = '".s_for($pulse)."',
		neck_measurement = '".s_for($neck_measurement)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		tongue = '".s_for($tongue_arr)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysqli_query($con,$ins_sql) or die($ins_sql." | ".mysql_error());

		$pat_sql = "UPDATE dental_patients SET
		feet = '".s_for($feet)."',
                inches = '".s_for($inches)."',
                weight = '".s_for($weight)."',
                bmi = '".s_for($bmi)."'
		WHERE patientid='".s_for($_GET['pid'])."'";
		mysqli_query($con,$pat_sql);
		
		$msg = "Added Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='ex_page2.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
	}
	else
	{
		$ed_sql = " update dental_ex_page1 set 
		blood_pressure = '".s_for($blood_pressure)."',
		pulse = '".s_for($pulse)."',
		neck_measurement = '".s_for($neck_measurement)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		tongue = '".s_for($tongue_arr)."'
		where ex_page1id = '".s_for($_POST['ed'])."'";
		
		mysqli_query($con,$ed_sql) or die($ed_sql." | ".mysql_error());

                $pat_sql = "UPDATE dental_patients SET
                feet = '".s_for($feet)."',
                inches = '".s_for($inches)."',
                weight = '".s_for($weight)."',
                bmi = '".s_for($bmi)."'
                WHERE patientid='".s_for($_GET['pid'])."'";
                mysqli_query($con,$pat_sql);
	
		$msg = "Edited Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='ex_page2.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
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
	die();
}

$bmi_sql = "select * from dental_patients where patientid='".$_GET['pid']."'";
$bmi_my = mysqli_query($con,$bmi_sql);
$bmi_myarray = mysqli_fetch_array($bmi_my);
$bmi = st($bmi_myarray['bmi']);
$feet = st($bmi_myarray['feet']);
$inches = st($bmi_myarray['inches']);
$weight = st($bmi_myarray['weight']);

$sql = "select * from dental_ex_page1 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$ex_page1id = st($myarray['ex_page1id']);
$blood_pressure = st($myarray['blood_pressure']);
$pulse = st($myarray['pulse']);
$neck_measurement = st($myarray['neck_measurement']);
//$bmi = st($myarray['bmi']);
$additional_paragraph = st($myarray['additional_paragraph']);
$tongue = st($myarray['tongue']);

?>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

<? include("../includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form id="ex_page1frm" class="ex_form" name="ex_page1frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="ex_page1sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page1id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<table width="98%" cellpadding="5" cellspacing="1" style="clear:both;" bgcolor="#FFFFFF" align="center">
    <tr>
        <td valign="top" class="frmhead">
        	<ul style="width:48%; float:left;">
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        VITAL DATA
                    </label>
                    
                    <div>
                    	<span>
                        	Blood Pressure
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            <input id="blood_pressure" name="blood_pressure" type="text" class="field text addr tbox" value="<?=$blood_pressure;?>" tabindex="1" maxlength="255" style="width:75px;" />
                        </span>
                   	</div>
                    <br />
                    
                    <div>    
                        <span>
                        	Pulse
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            <select name="pulse" id="pulse" class="field text addr tbox" style="width:50px;" tabindex="2">
                            	<? for($i=50;$i<=150;$i++)
								{
								?>
									<option value="<?=$i?>" <? if($pulse == $i) echo " selected";?>><?=$i?></option>
								<?
								}?>
                            </select>
                        </span>
                	</div>
                    <br />
                    
                    <div>    
                        <span>
                        	Neck Measurement
                            &nbsp;&nbsp;&nbsp;
                            <select name="neck_measurement" id="neck_measurement" class="field text addr tbox" style="width:50px;" tabindex="3">
                            	<? for($i=5;$i<=29;$i+=.5)
								{
								?>
									<option value="<?=$i?>" <? if($neck_measurement == $i) echo " selected";?>><?=$i?></option>
								<?
								}?>
                            </select>
                            inches
                        </span>
                	</div>
                    <br />
                    
                   	
                </li>
            </ul>
                <script type="text/javascript">
                                function cal_bmi()
                                {
                                        fa = document.ex_page1frm;
                                        if(fa.feet.value != 0 && fa.inches.value != -1 && fa.weight.value != 0)
                                        {
                                                var inc = (parseInt(fa.feet.value) * 12) + parseInt(fa.inches.value);
                                                //alert(inc);
                                                
                                                var inc_sqr = parseInt(inc) * parseInt(inc);
                                                var wei = parseInt(fa.weight.value) * 703;
                                                var bmi = parseInt(wei) / parseInt(inc_sqr);
                                                
                                                //alert("BMI " + bmi.toFixed(2));
                                                fa.bmi.value = bmi.toFixed(1);
                                        }
                                        else
                                        {
                                                fa.bmi.value = '';
                                        }
                                }
                        </script>

                    <label class="desc" id="title0" for="Field0">
                       HEIGHT/WEIGHT 
                    </label>
    <ul style="width:50%; float:left;">
		<li>
                            <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                                <option value="0">Feet</option>
                                <? for($i=1;$i<9;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($feet == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <?php
                                showPatientValue('dental_patients', $_GET['pid'], 'feet', (!empty($pat_row['feet']) ? $pat_row['feet'] : ''), $feet, true, (!empty($showEdits) ? $showEdits : ''));
                            ?>
                            <label for="feet">Feet</label>
		</li>
		<li>
                            <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                                <option value="-1">Inches</option>
                                <? for($i=0;$i<12;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($inches!='' && $inches == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <label for="inches">Inches</label>
		</li>
		<li>
                            <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                                <option value="0">Weight</option>
                                <? for($i=80;$i<=500;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($weight == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>

                            <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
		</li>
		<li>
                                <span style="color:#000000; padding-top:2px;">BMI</span>
                                <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?=$bmi?>" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
		<li>
                                <label for="inches">
                                &lt; 18.5 is Underweight
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                18.5 - 24.9 is Normal
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                25 - 29.9 is Overweight
                                <br />
                                &gt; 30 is Obese
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
                        AIRWAY EVALUATION
                        <br />
                        <span class="form_info">Tongue</span>
                        <br />
                    </label>
                    <div>
                        <span>
                        	<?
							$tongue_sql = "select * from dental_tongue where status=1 order by sortby";
							$tongue_my = mysqli_query($con,$tongue_sql);
							
							while($tongue_myarray = mysqli_fetch_array($tongue_my))
							{
							?>
								<input type="checkbox" id="tongue" name="tongue[]" value="<?=st($tongue_myarray['tongueid'])?>" tabindex="9" <? if(strpos($tongue,'~'.st($tongue_myarray['tongueid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($tongue_myarray['tongue']);?><br />
							<?
							}
							?>
                        </span>
                   </div>   
				   
				   	<br />
					<label class="desc" id="title0" for="Field0">
						Additional Paragraph
						/
						<button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=ex_page1frm&tx=additional_paragraph'); return false;">Custom Text</button>
					</label>
					
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
         
</table>

</form>


<br />
<? include("../includes/form_bottom.htm");?>
<br />




<? include "includes/bottom.htm";?>
