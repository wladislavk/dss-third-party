<?php
include "includes/top.htm";
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input :not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#ex_page1frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['ex_page1sub'] == 1)
{
	$blood_pressure = $_POST['blood_pressure'];
	$pulse = $_POST['pulse'];
	$neck_measurement = $_POST['neck_measurement'];
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
		formid = '".s_for($_GET['fid'])."',
		patientid = '".s_for($_GET['pid'])."',
		blood_pressure = '".s_for($blood_pressure)."',
		pulse = '".s_for($pulse)."',
		neck_measurement = '".s_for($neck_measurement)."',
		bmi = '".s_for($bmi)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		tongue = '".s_for($tongue_arr)."',
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
		$ed_sql = " update dental_ex_page1 set 
		blood_pressure = '".s_for($blood_pressure)."',
		pulse = '".s_for($pulse)."',
		neck_measurement = '".s_for($neck_measurement)."',
		bmi = '".s_for($bmi)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		tongue = '".s_for($tongue_arr)."'
		where ex_page1id = '".s_for($_POST['ed'])."'";
		
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

$bmi_sql = "select * from dental_q_page1 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$bmi_my = mysql_query($bmi_sql);
$bmi_myarray = mysql_fetch_array($bmi_my);
$bmi = st($bmi_myarray['bmi']);

$sql = "select * from dental_ex_page1 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page1id = st($myarray['ex_page1id']);
$blood_pressure = st($myarray['blood_pressure']);
$pulse = st($myarray['pulse']);
$neck_measurement = st($myarray['neck_measurement']);
//$bmi = st($myarray['bmi']);
$additional_paragraph = st($myarray['additional_paragraph']);
$tongue = st($myarray['tongue']);

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

<form id="ex_page1frm" name="ex_page1frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="ex_page1sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page1id;?>" />
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
                            	<? for($i=0;$i<1000;$i++)
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
                            	<? for($i=0;$i<=29;$i+=.5)
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
                    
                    <div>
                    	<span>
                        	BMI
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;
                            <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?=$bmi;?>" tabindex="4" maxlength="255" style="width:50px;" readonly="readonly" />
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
                        AIRWAY EVALUATION
                        <br />
                        <span class="form_info">Tongue</span>
                        <br />
                    </label>
                    <div>
                        <span>
                        	<?
							$tongue_sql = "select * from dental_tongue where status=1 order by sortby";
							$tongue_my = mysql_query($tongue_sql);
							
							while($tongue_myarray = mysql_fetch_array($tongue_my))
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
						<button onclick="Javascript: loadPopup('select_custom2.php'); return false;">Custom Text</button>
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
<? include "includes/bottom.htm";?>
