<?php namespace Ds3\Libraries\Legacy; ?><?php

use Illuminate\Support\Facades\App;

$dentalexpage1 = App::make('Ds3\Contracts\DentalExPage1Interface');

    include "includes/top.htm";
    require_once('includes/patient_info.php');
    if ($patient_info) {
?>
<script type="text/javascript" src="js/ex_page1.js"></script>
<?php
    if(!empty($_POST['ex_page1sub']) && $_POST['ex_page1sub'] == 1) {
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
    	
    	if($tongue_arr != '') $tongue_arr = '~'.$tongue_arr;
	
    	if($_POST['ed'] == '') {
//    		$ins_sql = " insert into dental_ex_page1 set 
//    		patientid = '".s_for($_GET['pid'])."',
//    		blood_pressure = '".s_for($blood_pressure)."',
//    		pulse = '".s_for($pulse)."',
//    		neck_measurement = '".s_for($neck_measurement)."',
//    		additional_paragraph = '".s_for($additional_paragraph)."',
//    		tongue = '".s_for($tongue_arr)."',
//    		userid = '".s_for($_SESSION['userid'])."',
//    		docid = '".s_for($_SESSION['docid'])."',
//    		adddate = now(),
//    		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
            
            $data = array(
    		'patientid' 			=> s_for($_GET['pid']),
    		'blood_pressure' 		=> s_for($blood_pressure),
    		'pulse' 				=> s_for($pulse),
    		'neck_measurement' 		=> s_for($neck_measurement),
    		'additional_paragraph' 	=> s_for($additional_paragraph),
    		'tongue' 				=> s_for($tongue_arr),
    		'userid' 				=> s_for($_SESSION['userid']),
    		'docid' 				=> s_for($_SESSION['docid']),
    		'adddate' 				=> now(),
    		'ip_address' 			=> s_for($_SERVER['REMOTE_ADDR'])
    		);
    		
    		// $db->query($ins_sql);
    		$dentalexpage1->save($data);
    		// $pat_sql = "UPDATE dental_patients SET
    		// feet = '".s_for($feet)."',
      //               inches = '".s_for($inches)."',
      //               weight = '".s_for($weight)."',
      //               bmi = '".s_for($bmi)."'
    		// WHERE patientid='".s_for($_GET['pid'])."'";
    		$pat_sql = array(
    				'feet' => s_for($feet),
                    'inches' => s_for($inches),
                    'weight' => s_for($weight),
                    'bmi' => s_for($bmi)
    		);
    		$dentalexpage1->updateDentalPatient($pat_sql, $_GET['pid']);
    		// $db->query($pat_sql);
            $msg = "Added Successfully";
            if(isset($_POST['ex_pagebtn_proceed'])){
?>
                <script type="text/javascript">
                    window.location='ex_page2.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
<?php
            } else {
?>
        		<script type="text/javascript">
        			window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
        		</script>
<?php
		    }
		  trigger_error("Die called", E_USER_ERROR);
	    } else {
//    		$ed_sql = " update dental_ex_page1 set 
//    		blood_pressure = '".s_for($blood_pressure)."',
//    		pulse = '".s_for($pulse)."',
//    		neck_measurement = '".s_for($neck_measurement)."',
//    		additional_paragraph = '".s_for($additional_paragraph)."',
//    		tongue = '".s_for($tongue_arr)."'
//    		where ex_page1id = '".s_for($_POST['ed'])."'";
    		
    		$ed_sql = array(
	    		'blood_pressure' 		=> s_for($blood_pressure),
	    		'pulse' 				=> s_for($pulse),
	    		'neck_measurement' 		=> s_for($neck_measurement),
	    		'additional_paragraph' 	=> s_for($additional_paragraph),
	    		'tongue' 				=> s_for($tongue_arr)
			);
    		$dentalexpage1->update($ed_sql,s_for($_POST['ed']));
    		// $db->query($ed_sql);

            // $pat_sql = "UPDATE dental_patients SET
            // feet = '".s_for($feet)."',
            // inches = '".s_for($inches)."',
            // weight = '".s_for($weight)."',
            // bmi = '".s_for($bmi)."'
            // WHERE patientid='".s_for($_GET['pid'])."'";
    		$pat_sql = array(
    			'feet' => s_for($feet),
	            'inches' => s_for($inches),
	            'weight' => s_for($weight),
	            'bmi' => s_for($bmi)
    		);

    		$dentalexpage1->updateDentalPatient($pat_sql, $_GET['pid']);
            // $db->query($pat_sql);
	        $msg = "Edited Successfully";
            if(isset($_POST['ex_pagebtn_proceed'])){
?>
                <script type="text/javascript">
                    window.location='ex_page2.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
<?php
            } else {
?>
        		<script type="text/javascript">
        			window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
        		</script>
<?php
            }
		    trigger_error("Die called", E_USER_ERROR);
	    }
    }

    // $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

    $pat_myarray = $dentalexpage1->findFromDentalPatients($_GET['pid']);
    // $pat_myarray = $db->getRow($pat_sql);
    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
    if($pat_myarray['patientid'] == '') {
?>
    	<script type="text/javascript">
    		window.location = 'manage_patient.php';
    	</script>
<?php
    	trigger_error("Die called", E_USER_ERROR);
    }

    // $bmi_sql = "select * from dental_patients where patientid='".$_GET['pid']."'";
    $bmi_myarray = $dentalexpage1->findFromDentalPatients($_GET['pid']);
    // $bmi_myarray = $db->getRow($bmi_sql);
    $bmi = st($bmi_myarray['bmi']);
    $feet = st($bmi_myarray['feet']);
    $inches = st($bmi_myarray['inches']);
    $weight = st($bmi_myarray['weight']);

    $sql = "select * from dental_ex_page1 where patientid='".$_GET['pid']."'";

    $myarray = $db->getRow($sql);
    $ex_page1id = st($myarray['ex_page1id']);
    $blood_pressure = st($myarray['blood_pressure']);
    $pulse = st($myarray['pulse']);
    $neck_measurement = st($myarray['neck_measurement']);
    $additional_paragraph = st($myarray['additional_paragraph']);
    $tongue = st($myarray['tongue']);
?>

    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="script/wufoo.js"></script>

    <a name="top"></a>
    &nbsp;&nbsp;

    <?php include("includes/form_top.htm");?>

    <br /><br>
    <div align="center" class="red">
    	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>

    <form id="ex_page1frm" class="ex_form" name="ex_page1frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post">
        <input type="hidden" name="ex_page1sub" value="1" />
        <input type="hidden" name="ed" value="<?php echo $ex_page1id;?>" />
        <input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />
        <div style="float:left; margin-left:10px;">
            <input type="reset" value="Undo Changes" />
        </div>
        <div style="float:right;">
            <input type="submit" name="ex_pagebtn" value="Save" />
            <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" />
            &nbsp;&nbsp;&nbsp;
        </div>
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
                                <input id="blood_pressure" name="blood_pressure" type="text" class="field text addr tbox" value="<?php echo $blood_pressure;?>" tabindex="1" maxlength="255" style="width:75px;" />
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
                                	<?php for($i = 50; $i <= 150; $i++){ ?>
    									<option value="<?php echo $i?>" <?php if($pulse == $i) echo " selected";?>><?php echo $i; ?></option>
    								<?php } ?>
                                </select>
                            </span>
                    	</div>
                        <br />
                        <div>    
                            <span>
                            	Neck Measurement
                                &nbsp;&nbsp;&nbsp;
                                <select name="neck_measurement" id="neck_measurement" class="field text addr tbox" style="width:50px;" tabindex="3">
                                	<?php for($i = 5; $i<=29 ; $i += .5){ ?>
    									<option value="<?php echo $i?>" <?php if($neck_measurement == $i) echo " selected";?>><?php echo $i; ?></option>
    								<?php } ?>
                                </select>
                                inches
                            </span>
                    	</div>
                        <br />
                    </li>
                </ul>
                <label class="desc" id="title0" for="Field0">
                   HEIGHT/WEIGHT 
                </label>
                <ul style="width:50%; float:left;">
            		<li>
                        <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                            <option value="0">Feet</option>
                            <?php for($i = 1; $i < 9; $i++){ ?>
                                <option value="<?php echo $i?>" <?php if($feet == $i) echo " selected";?>><?php echo $i?></option>
                            <?php } ?>
                        </select>
                        <?php
                            showPatientValue('dental_patients', $_GET['pid'], 'feet', (!empty($pat_row['feet']) ? $pat_row['feet'] : ''), $feet, true, (!empty($showEdits) ? $showEdits : ''));
                        ?>
                        <label for="feet">Feet</label>
                    </li>
                    <li>
                        <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                            <option value="-1">Inches</option>
                            <?php for($i = 0; $i < 12; $i++){ ?>
                                <option value="<?php echo $i?>" <?php if($inches!='' && $inches == $i) echo " selected";?>><?php echo $i?></option>
                            <?php } ?>
                        </select>
                        <label for="inches">Inches</label>
                    </li>
                    <li>
                        <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                            <option value="0">Weight</option>
                            <?php for($i = 80; $i <= 500; $i++){ ?>
                                <option value="<?php echo $i?>" <?php if($weight == $i) echo " selected";?>><?php echo $i?></option>
                            <?php } ?>
                        </select>
                        <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    </li>
            		<li>
                        <span style="color:#000000; padding-top:2px;">BMI</span>
                        <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?php echo $bmi?>" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
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
                            	<?php
        							$tongue_sql = "select * from dental_tongue where status=1 order by sortby";
        							
                                    $tongue_my = $db->getResults($tongue_sql);
        							if ($tongue_my) foreach ($tongue_my as $tongue_myarray) {
    							?>
        								<input type="checkbox" id="tongue" name="tongue[]" value="<?php echo st($tongue_myarray['tongueid'])?>" tabindex="9" <?php if(strpos($tongue,'~'.st($tongue_myarray['tongueid']).'~') === false) {} else { echo " checked";}?> />
                                        &nbsp;&nbsp;
                                        <?php echo st($tongue_myarray['tongue']);?><br />
							    <?php
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
    							<textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $additional_paragraph;?></textarea>
    						</span>
    					</div>
					   <br />
                    </li>
                </ul>
            </td>
        </tr>
        </table>
        <div style="float:left; margin-left:10px;">
            <input type="reset" value="Undo Changes" />
        </div>
        <div style="float:right;">
            <input type="submit" name="ex_pagebtn" value="Save" />
            <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" />
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>

    <br />
        <?php include("includes/form_bottom.htm");?>
    <br />

    <div id="popupRefer" style="width:750px;">
        <a id="popupReferClose">
            <button>X</button>
        </a>
        <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopupRef"></div>
    <div id="popupContact" style="width:750px;">
        <a id="popupContactClose">
            <button>X</button>
        </a>
        <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopup"></div>
    <br /><br />	

<?php
    } else {  // end pt info check
    	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
    }
?>

<?php include "includes/bottom.htm";?>
