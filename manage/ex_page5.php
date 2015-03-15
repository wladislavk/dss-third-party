<?php namespace Ds3\Legacy; ?><?php 
	include "includes/top.htm";
	include_once('includes/patient_info.php');
	if ($patient_info) {
?>

<script type="text/javascript" src="js/ex_page5.js"></script>

<?php
		if(!empty($_POST['ex_page5sub']) && $_POST['ex_page5sub'] == 1)
		{
			$additional_paragraph_pal = $_POST['additional_paragraph_pal'];
			$caries = (!empty($_POST['caries']) ? $_POST['caries'] : '');
			$joint_exam = $_POST['joint_exam'];
			$i_opening_from = $_POST['i_opening_from'];
			$i_opening_to = (!empty($_POST['i_opening_to']) ? $_POST['i_opening_to'] : '');
			$i_opening_equal = (!empty($_POST['i_opening_equal']) ? $_POST['i_opening_equal'] : '');
			$protrusion_from = $_POST['protrusion_from'];
			$protrusion_to = $_POST['protrusion_to'];
			if($protrusion_from !='' && $protrusion_to != ''){
			  $protrusion_equal = abs($protrusion_to-$protrusion_from);
			}else{
			  $protrusion_equal = $_POST['protrusion_equal'];
			}
	
			$l_lateral_from = $_POST['l_lateral_from'];
			$l_lateral_to = (!empty($_POST['l_lateral_to']) ? $_POST['l_lateral_to'] : '');
			$l_lateral_equal = (!empty($_POST['l_lateral_equal']) ? $_POST['l_lateral_equal'] : '');
			$r_lateral_from = $_POST['r_lateral_from'];
			$r_lateral_to = (!empty($_POST['r_lateral_to']) ? $_POST['r_lateral_to'] : '');
			$r_lateral_equal = (!empty($_POST['r_lateral_equal']) ? $_POST['r_lateral_equal'] : '');
			$deviation_from = (!empty($_POST['deviation_from']) ? $_POST['deviation_from'] : '');
			$deviation_to = (!empty($_POST['deviation_to']) ? $_POST['deviation_to'] : '');
			$deviation_equal = (!empty($_POST['deviation_equal']) ? $_POST['deviation_equal'] : '');
			$deflection_from = $_POST['deflection_from'];
			$deflection_to = (!empty($_POST['deflection_to']) ? $_POST['deflection_to'] : '');
			$deflection_equal = (!empty($_POST['deflection_equal']) ? $_POST['deflection_equal'] : '');
			$range_normal = (!empty($_POST['range_normal']) ? $_POST['range_normal'] : '');
			$normal = (!empty($_POST['normal'])) ? $_POST['normal'] : '';
			$other_range_motion = (!empty($_POST['other_range_motion']) ? $_POST['other_range_motion'] : '');
			$additional_paragraph_rm = $_POST['additional_paragraph_rm'];
			$deviation_r_l = $_POST['deviation_r_l'];
			$deflection_r_l = $_POST['deflection_r_l'];
			
			$palpation_sql = "select * from dental_palpation where status=1 order by sortby";
			
			$palpation_my = $db->getResults($palpation_sql);
			$pal_arr = '';
			$palR_arr = '';
			if ($palpation_my) foreach ($palpation_my as $palpation_myarray)
			{
				if($_POST['palpation_'.$palpation_myarray['palpationid']] <> '')
				{
					$pal_arr .= $palpation_myarray['palpationid'].'|'.$_POST['palpation_'.$palpation_myarray['palpationid']].'~';
				}
				
				if($_POST['palpationR_'.$palpation_myarray['palpationid']] <> '')
				{
					$palR_arr .= $palpation_myarray['palpationid'].'|'.$_POST['palpationR_'.$palpation_myarray['palpationid']].'~';
				}
			}
			
			$joint_sql = "select * from dental_joint where status=1 order by sortby";
			
			$joint_my = $db->getResults($joint_sql);
			$joi_arr = '';
			if ($joint_my) foreach ($joint_my as $joint_myarray)
			{
				if($_POST['joint_'.$joint_myarray['jointid']] <> '')
				{
					$joi_arr .= $joint_myarray['jointid'].'|'.$_POST['joint_'.$joint_myarray['jointid']].'~';
				}
			}
			
			$join_exam_arr = '';
			if(is_array($joint_exam))
			{
				if (!isset($joint_exam_arr)) {
					$joint_exam_arr = "";
				}

				foreach($joint_exam as $val)
				{
					if(trim($val) <> '')
						$joint_exam_arr .= trim($val).'~';
				}
			}
			if($joint_exam_arr != '')
				$joint_exam_arr = '~'.$joint_exam_arr;

			$sql = "select * from dental_summary where patientid='".$_GET['pid']."'";
			
			$row = $db->getRow($sql);
			$num = $db->getNumberRows($sql);

	        if($num==0)
	        {
                $ins_sql = " insert into dental_summary set 
                patientid = '".s_for($_GET['pid'])."',
                initial_device_titration_1 = '".s_for($_POST['initial_device_titration_1'])."',
                initial_device_titration_equal_h = '".s_for($_POST['initial_device_titration_equal_h'])."',
                initial_device_titration_equal_v = '".s_for($_POST['initial_device_titration_equal_v'])."',
                optimum_echovision_ver = '".s_for($_POST['optimum_echovision_ver'])."',
                optimum_echovision_hor = '".s_for($_POST['optimum_echovision_hor'])."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
                
                $db->query($ins_sql);
	        }else{
                $ed_sql = "update dental_summary set 
                initial_device_titration_1 = '".s_for($_POST['initial_device_titration_1'])."',
                initial_device_titration_equal_h = '".s_for(!empty($_POST['initial_device_titration_equal_h']) ? $_POST['initial_device_titration_equal_h'] : '')."',
                initial_device_titration_equal_v = '".s_for($_POST['initial_device_titration_equal_v'])."',
                optimum_echovision_ver = '".s_for($_POST['optimum_echovision_ver'])."',
                optimum_echovision_hor = '".s_for($_POST['optimum_echovision_hor'])."'
                 where patientid = '".s_for($_GET['pid'])."'";
                
                $db->query($ed_sql);
	        }

			if($_POST['ed'] == '') {
				$ins_sql = " insert into dental_ex_page5 set 
				patientid = '".s_for($_GET['pid'])."',
				palpationid = '".s_for($pal_arr)."',
				palpationRid = '".s_for($palR_arr)."',
				additional_paragraph_pal = '".s_for($additional_paragraph_pal)."',
				joint_exam = '".s_for($joint_exam_arr)."',
				jointid = '".s_for($joi_arr)."',
				i_opening_from = '".s_for($i_opening_from)."',
				i_opening_to = '".s_for($i_opening_to)."',
				i_opening_equal = '".s_for($i_opening_equal)."',
				protrusion_from = '".s_for($protrusion_from)."',
				protrusion_to = '".s_for($protrusion_to)."',
				protrusion_equal = '".s_for($protrusion_equal)."',
				l_lateral_from = '".s_for($l_lateral_from)."',
				l_lateral_to = '".s_for($l_lateral_to)."',
				l_lateral_equal = '".s_for($l_lateral_equal)."',
				r_lateral_from = '".s_for($r_lateral_from)."',
				r_lateral_to = '".s_for($r_lateral_to)."',
				r_lateral_equal = '".s_for($r_lateral_equal)."',
				deviation_from = '".s_for($deviation_from)."',
				deviation_to = '".s_for($deviation_to)."',
				deviation_equal = '".s_for($deviation_equal)."',
				deflection_from = '".s_for($deflection_from)."',
				deflection_to = '".s_for($deflection_to)."',
				deflection_equal = '".s_for($deflection_equal)."',
				range_normal = '".s_for($range_normal)."',
				normal = '".s_for($normal)."',
				other_range_motion = '".s_for($other_range_motion)."',
				additional_paragraph_rm = '".s_for($additional_paragraph_rm)."',
				deviation_r_l = '".s_for($deviation_r_l)."',
				deflection_r_l = '".s_for($deflection_r_l)."',
				userid = '".s_for($_SESSION['userid'])."',
				docid = '".s_for($_SESSION['docid'])."',
				adddate = now(),
				ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
				
				$db->query($ins_sql);
				
				$msg = "Added Successfully";
		        if(isset($_POST['ex_pagebtn_proceed'])){
?>
	                <script type="text/javascript">
                        window.location='ex_page4.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
	                </script>
<?php
		        } else {
?>
					<script type="text/javascript">
						window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
					</script>
<?php
				}
				die();
			} else {
				$ed_sql = " update dental_ex_page5 set 
				palpationid = '".s_for($pal_arr)."',
				palpationRid = '".s_for($palR_arr)."',
				additional_paragraph_pal = '".s_for($additional_paragraph_pal)."',
				joint_exam = '".s_for($joint_exam_arr)."',
				jointid = '".s_for($joi_arr)."',
				i_opening_from = '".s_for($i_opening_from)."',
				i_opening_to = '".s_for($i_opening_to)."',
				i_opening_equal = '".s_for($i_opening_equal)."',
				protrusion_from = '".s_for($protrusion_from)."',
				protrusion_to = '".s_for($protrusion_to)."',
				protrusion_equal = '".s_for($protrusion_equal)."',
				l_lateral_from = '".s_for($l_lateral_from)."',
				l_lateral_to = '".s_for($l_lateral_to)."',
				l_lateral_equal = '".s_for($l_lateral_equal)."',
				r_lateral_from = '".s_for($r_lateral_from)."',
				r_lateral_to = '".s_for($r_lateral_to)."',
				r_lateral_equal = '".s_for($r_lateral_equal)."',
				deviation_from = '".s_for($deviation_from)."',
				deviation_to = '".s_for($deviation_to)."',
				deviation_equal = '".s_for($deviation_equal)."',
				deflection_from = '".s_for($deflection_from)."',
				deflection_to = '".s_for($deflection_to)."',
				deflection_equal = '".s_for($deflection_equal)."',
				range_normal = '".s_for($range_normal)."',
				normal = '".s_for($normal)."',
				other_range_motion = '".s_for($other_range_motion)."',
				additional_paragraph_rm = '".s_for($additional_paragraph_rm)."',
				deviation_r_l = '".s_for($deviation_r_l)."',
				deflection_r_l = '".s_for($deflection_r_l)."'
				where ex_page5id = '".s_for($_POST['ed'])."'";
		
				$db->query($ed_sql);
				
				$msg = "Edited Successfully";
		        if(isset($_POST['ex_pagebtn_proceed'])){
?>
	                <script type="text/javascript">
                        window.location='ex_page4.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
	                </script>
<?php
		        } else {
?>
					<script type="text/javascript">
						window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
					</script>
<?php
				}
				die();
			}
		}

		$sqls = "select * from dental_summary where patientid='".$_GET['pid']."'";

		$myarrays = $db->getRow($sqls);
		$initial_device_titration_1 = $myarrays['initial_device_titration_1'];
		$initial_device_titration_equal_h = $myarrays['initial_device_titration_equal_h'];
		$initial_device_titration_equal_v = $myarrays['initial_device_titration_equal_v'];
		$optimum_echovision_ver = $myarrays['optimum_echovision_ver'];
		$optimum_echovision_hor = $myarrays['optimum_echovision_hor'];

		$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
		
		$pat_myarray = $db->getRow($pat_sql);
		$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

		if($pat_myarray['patientid'] == '')
		{
?>
			<script type="text/javascript">
				window.location = 'manage_patient.php';
			</script>
<?php
			die();
		}

		$sql = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
		
		$myarray = $db->getRow($sql);
		$ex_page5id = st($myarray['ex_page5id']);
		$palpationid = st($myarray['palpationid']);
		$palpationRid = st($myarray['palpationRid']);
		$additional_paragraph_pal = st($myarray['additional_paragraph_pal']);
		$joint_exam = st($myarray['joint_exam']);
		$jointid = st($myarray['jointid']);
		$i_opening_from = st($myarray['i_opening_from']);
		$i_opening_to = st($myarray['i_opening_to']);
		$i_opening_equal = st($myarray['i_opening_equal']);
		$protrusion_from = st($myarray['protrusion_from']);
		$protrusion_to = st($myarray['protrusion_to']);
		$protrusion_equal = st($myarray['protrusion_equal']);
		$l_lateral_from = st($myarray['l_lateral_from']);
		$l_lateral_to = st($myarray['l_lateral_to']);
		$l_lateral_equal = st($myarray['l_lateral_equal']);
		$r_lateral_from = st($myarray['r_lateral_from']);
		$r_lateral_to = st($myarray['r_lateral_to']);
		$r_lateral_equal = st($myarray['r_lateral_equal']);
		$deviation_from = st($myarray['deviation_from']);
		$deviation_to = st($myarray['deviation_to']);
		$deviation_equal = st($myarray['deviation_equal']);
		$deflection_from = st($myarray['deflection_from']);
		$deflection_to = st($myarray['deflection_to']);
		$deflection_equal = st($myarray['deflection_equal']);
		$range_normal = st($myarray['range_normal']);
		$normal = st($myarray['normal']);
		$other_range_motion = st($myarray['other_range_motion']);
		$additional_paragraph_rm = st($myarray['additional_paragraph_rm']);
		$deviation_r_l = st($myarray['deviation_r_l']);
		$deflection_r_l = st($myarray['deflection_r_l']);

		if($palpationid <> '')
		{	
			$pal_arr1 = explode('~',$palpationid);
			
			foreach($pal_arr1 as $i => $val)
			{
				$pal_arr2 = explode('|',$val);
				
				$palid[$i] = $pal_arr2[0];
				$palseq[$i] = (!empty($pal_arr2[1]) ? $pal_arr2[1] : '');
			}
		}

		if($palpationRid <> '')
		{	
			$palR_arr1 = explode('~',$palpationRid);
			
			foreach($palR_arr1 as $i => $val)
			{
				$palR_arr2 = explode('|',$val);
				
				$palRid[$i] = $palR_arr2[0];
				$palRseq[$i] = (!empty($palR_arr2[1]) ? $palR_arr2[1] : '');
			}
		}

		if($jointid <> '')
		{	
			$jo_arr1 = explode('~',$jointid);
			
			foreach($jo_arr1 as $i => $val)
			{
				$jo_arr2 = explode('|',$val);
				
				$joid[$i] = $jo_arr2[0];
				$joseq[$i] = (!empty($jo_arr2[1]) ? $jo_arr2[1] : '');
			}
		}
?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup1.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css/form.css" type="text/css" />
	<script type="text/javascript" src="script/wufoo.js"></script>

	<a name="top"></a>
	&nbsp;&nbsp;

	<?php include("includes/form_top.htm");?>

	<br /><br>
	<div align="center" class="red">
		<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>

	<form id="ex_page5frm" class="ex_form" name="ex_page5frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post" >
		<input type="hidden" name="ex_page5sub" value="1" />
		<input type="hidden" name="ed" value="<?php echo $ex_page5id;?>" />
		<input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />
		<div style="float:left; margin-left:10px;">
	        <input type="reset" value="Undo Changes" />
		</div>
		<div style="float:right;">
	        <input type="submit" name="ex_pagebtn" value="Save" />
	        <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" />
		    &nbsp;&nbsp;&nbsp;
		</div>
		<table style="clear:both;" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
			<tr>
		        <td valign="top" class="frmhead">
		        	<ul>
		                <li id="foli8" class="complex">	
		                    <label class="desc" id="title0" for="Field0">
		                      	Muscles & Manual Palpation
		                    </label>
							<br />
		                    <div align="right" style="text-align:right; float:right;">
		                    	<span class="ex_p5_0"> 
		                    		0 - No Tenderness
		                        </span>
		                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                        <span class="ex_p5_1" style="padding-left:10px;">
		                            1 - Mild
		                        </span>
		                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                        <span class="ex_p5_2"  style="padding-left:10px;">
		                            2 - Moderate
		                        </span>
		                        &nbsp;&nbsp;&nbsp;
		                        <span class="ex_p5_3" style="padding-left:10px;" >
		                            3 - Severe
		                        </span>
								<br />
								<button onclick="setDefaults();return false;">Set all to 0</button>
							</div>
		                    <div id="topcb">
		                    	<span class="full">
		                        	<table width="80%" cellpadding="3" cellspacing="1" border="0">
		                            	<tr>
		                                	<td valign="top" width="20%">
		                                    	Left
		                                    </td>
		                                	<td valign="top" width="20%">
		                                    	Right
		                                    </td>
		                                	<td valign="top" width="60%">&nbsp;</td>
		                                </tr>
		                                <?php
											$palpation_sql = "select * from dental_palpation where status=1 order by sortby";
											
											$palpation_my = $db->getResults($palpation_sql);
											foreach ($palpation_my as $palpation_myarray) {
												if(@array_search($palpation_myarray['palpationid'],$palid) === false){
													$chk = '';
												} else {
													$chk = (!empty($palseq[@array_search($palpation_myarray['palpationid'],$palid)]) ? $palseq[@array_search($palpation_myarray['palpationid'],$palid)] : '');
												}
												
												if(@array_search($palpation_myarray['palpationid'],$palRid) === false) {
													$chkR = '';
												} else {
													$chkR = (!empty($palRseq[@array_search($palpation_myarray['palpationid'],$palRid)]) ? $palRseq[@array_search($palpation_myarray['palpationid'],$palRid)] : '');
												}
										?>
			                                <tr>
			                                	<td valign="top">
													<select id="palpation_<?php echo st($palpation_myarray['palpationid']);?>" name="palpation_<?php echo st($palpation_myarray['palpationid']);?>" class="field text addr tbox" style="width:50px;">
														<option value=""></option>
														<option value="0" <?php if($chk == '0') echo " selected";?> class="ex_p5_0">
															0
														</option>
														<option value="1" <?php if($chk == '1') echo " selected";?> class="ex_p5_1">
															1
														</option>
														<option value="2" <?php if($chk == '2') echo " selected";?> class="ex_p5_2">
															2
														</option>
														<option value="3" <?php if($chk == '3') echo " selected";?> class="ex_p5_3">
															3
														</option>
													</select>
			                                     </td>
			                                     <td valign="top">
			                                     	<select id="palpationR_<?php echo st($palpation_myarray['palpationid']);?>" name="palpationR_<?php echo st($palpation_myarray['palpationid']);?>" class="field text addr tbox" style="width:50px;">
														<option value=""></option>
														<option value="0" <?php if($chkR == '0') echo " selected";?> class="ex_p5_0">
															0
														</option>
														<option value="1" <?php if($chkR == '1') echo " selected";?> class="ex_p5_1">
															1
														</option>
														<option value="2" <?php if($chkR == '2') echo " selected";?> class="ex_p5_2">
															2
														</option>
														<option value="3" <?php if($chkR == '3') echo " selected";?> class="ex_p5_3">
															3
														</option>
													</select>
                                     			</td>
												<td valign="top">
													<span>
														<?php echo st($palpation_myarray['palpation']);?>
													</span>
												</td>
                                  			</tr>	
										<?php } ?>
		                                <tr>
		                                	<td valign="top" colspan="3" align="right"></td>
		                                </tr>
                            		</table>
		                        </span>
		                   	</div>
                    		<br />
                		</li>
		                <li id="foli8" class="complex">	
		                    <label class="desc" id="title0" for="Field0">
		                        Additional Paragraph
		                        /
		                        <button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=ex_page5frm&tx=additional_paragraph_pal'); getElementById('popupContact1').style.top = '400px'; return false;">Custom Text</button>
		                    </label>
		                    <div>
		                    	<span>
		                        	<textarea name="additional_paragraph_pal" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $additional_paragraph_pal;?></textarea>
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
		                    <label class="desc" id="title0" for="Field0">Joint Sounds</label>
		                    <div>
		                    	<span style="width:350px;">
		                        	Examination Type:
		                        </span>
								<span>L = Left, R = Right, B = Both, WNL = Within Normal Limits</span>
								<a href="#" onclick="$('.jointdd').val('WNL');return false;" class="button">Set all to WNL</a>                   
							</div>
		                    <div>
		                    	<span class="full">
		                        	<table width="100%" cellpadding="3" cellspacing="1" >
		                            	<tr>
		                                	<td valign="top" width="40%">
		                                		<span>
			                                    	<?php
														$joint_exam_sql = "select * from dental_joint_exam where status=1 order by sortby";
														
														$joint_exam_my = $db->getResults($joint_exam_sql);
														if ($joint_exam_my) foreach ($joint_exam_my as $joint_exam_myarray) {
													?>
															<input type="checkbox" id="joint_exam" name="joint_exam[]" value="<?php echo st($joint_exam_myarray['joint_examid'])?>" <?php if(strpos($joint_exam,'~'.st($joint_exam_myarray['joint_examid']).'~') === false) {} else { echo " checked";}?> style="width:10px;" />
															&nbsp;&nbsp;
															<?php echo st($joint_exam_myarray['joint_exam']);?><br />
													<?php
														}
													?>
												</span>
		                                    </td>
		                                    <td valign="top">
		                                    	<table width="100%" cellpadding="3" cellspacing="1">
		                                    	    <?php
														$joint_sql = "select * from dental_joint where status=1 order by sortby";
														
														$joint_my = $db->getResults($joint_sql);
														if ($joint_my) foreach ($joint_my as $joint_myarray) {
															if(@array_search($joint_myarray['jointid'],$joid) === false) {
																$chkJ = '';
															} else {
																$chkJ = (!empty($joseq[@array_search($joint_myarray['jointid'],$joid)]) ? $joseq[@array_search($joint_myarray['jointid'],$joid)] : '');
															}
													?>
			                                            	<tr>
			                                                	<td valign="top" width="40%">
			                                                		<span>
																		<?php echo st($joint_myarray['joint']);?>
																	</span>
			                                                    </td>
			                                                    <td valign="top">
			                                                        <select class="jointdd" id="joint_<?php echo st($joint_myarray['jointid']);?>" name="joint_<?php echo st($joint_myarray['jointid']);?>" class="field text addr tbox" style="width:60px;">
			                                                            <option value=""></option>
			                                                            <option value="L" <?php if($chkJ == 'L') echo " selected";?> >
			                                                                L
			                                                            </option>
			                                                            <option value="R" <?php if($chkJ == 'R') echo " selected";?>>
			                                                                R
			                                                            </option>
			                                                            <option value="B" <?php if($chkJ == 'B') echo " selected";?>>
			                                                                B
			                                                            </option>
			                                                            <option value="WNL" <?php if($chkJ == 'WNL') echo " selected";?>>
			                                                                WNL
			                                                            </option>

			                                                        </select>
																</td>
															</tr>
													<?php } ?>
		                                        </table>
		                                    </td>
		                                </tr>
		                            </table>
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
		                        Range Of Motion
		                    </label>
		                    <div>
		                    	<span >
		                        	<table width="100%" cellpadding="3" cellspacing="1">
		                            	<tr>
		                                	<td valign="top">
		                                    	<span>
		                                    	Interincisal Opening
		                                        </span>
		                                    </td>
		                                    <td valign="top">
		                                    	<span>
		                                        	<input type="text" name="i_opening_from" class="field text addr tbox" style="width:50px;" value="<?php echo $i_opening_from;?>">
		                                        </span>
		                                    </td>
		                                </tr>
										<tr>
			                                <td valign="top">
		                                    	<span>George Scale</span>
		                                    </td>
	                                        <td valign="top">
		                                        <input type="text" id="protrusion_from" name="protrusion_from" onkeyup="updateProtrusion();" class="field text addr tbox" style="width:50px;" value="<?php echo $protrusion_from;?>">
		                                        &nbsp;&nbsp;&nbsp;
		                                        to
		                                        &nbsp;&nbsp;&nbsp;
		                                        <input type="text" id="protrusion_to" name="protrusion_to" onkeyup="updateProtrusion();" class="field text addr tbox" style="width:50px;" value="<?php echo $protrusion_to;?>">
	                                    	</td>
		                                </tr>
 										<tr>
		                                	<td valign="top">
		                                    	<span>
		                                    		Protrusion (Automatically calculated from George Gauge above)
		                                        </span>
		                                    </td>
		                                    <td valign="top">
		                                    	<span>
		                                    		<input type="text" id="protrusion_equal" onkeyup="check_georges(this.form);" name="protrusion_equal" class="field text addr tbox" style="width:50px;" value="<?php echo $protrusion_equal;?>">
		                                		</span>
		                                	</td>
		                                </tr>
		                                <tr>
		                                	<td valign="top">
		                                    	<span>
		                                    		Left Lateral Excursion
		                                        </span>
		                                    </td>
		                                    <td valign="top">
		                                    	<span>
		                                    		<input type="text" name="l_lateral_from" class="field text addr tbox" style="width:50px;" value="<?php echo $l_lateral_from;?>">
		                                        </span>
		                                    </td>
		                                </tr>
		                                <tr>
		                                	<td valign="top">
		                                    	<span>
		                                    		Right Lateral Excursion
		                                        </span>
		                                    </td>
		                                    <td valign="top">
		                                    	<span>
		                                    		<input type="text" name="r_lateral_from" class="field text addr tbox" style="width:50px;" value="<?php echo $r_lateral_from;?>">
		                                        </span>
		                                    </td>
		                                </tr>
		                                <tr>
		                                	<td valign="top">
		                                    	<span>
		                                    		Deviation
		                                        </span>
												&nbsp;&nbsp;
												<select id="deviation_r_l" name="deviation_r_l" class="field text addr tbox" style="width:60px;">
													<option value=""></option>
													<option value="Right" <?php if($deviation_r_l == 'Right') echo " selected";?> >
														Right
													</option>
													<option value="Left" <?php if($deviation_r_l == 'Left') echo " selected";?>>
														Left
													</option>
												</select>
		                                    </td>
		                                    <td valign="top">
		                                    	<span>
		                                    		<input type="text" name="deviation_from" class="field text addr tbox" style="width:50px;" value="<?php echo $deviation_from;?>">
		                                        </span>
		                                    </td>
		                                </tr>
		                                <tr>
		                                	<td valign="top">
		                                    	<span>
		                                    		Deflection
		                                        </span>
												&nbsp;
												<select id="deflection_r_l" name="deflection_r_l" class="field text addr tbox" style="width:60px;">
													<option value=""></option>
													<option value="Right" <?php if($deflection_r_l == 'Right') echo " selected";?> >
														Right
													</option>
													<option value="Left" <?php if($deflection_r_l == 'Left') echo " selected";?>>
														Left
													</option>
												</select>
		                                    </td>
		                                    <td valign="top">
		                                    	<span>
		                                    		<input type="text" name="deflection_from" class="field text addr tbox" style="width:50px;" value="<?php echo $deflection_from;?>">
		                                        </span>
		                                    </td>
		                                </tr>    
										<tr>
											<td valign="top"><span>Best Eccovision</span></td>
											<td></td>
										</tr>
										<tr>
											<td>
										       <span style="padding-left:30px">Horizontal</span>
										    </td>
										    <td>
										    	 <input type="text" name="optimum_echovision_hor" id="optimum_echovision_hor" size="5" value="<?php echo $optimum_echovision_hor; ?>" />mm
										  	</td>
										<tr>
										  	<td>
										  		<span style="padding-left:30px">Vertical</span>
										  	</td>
										  	<td>
										  		<input type="text" name="optimum_echovision_ver" id="optimum_echovision_ver" size="5" value="<?php echo $optimum_echovision_ver; ?>" />mm
										  	</td>
										</tr>
										<tr>
						  					<td valign="top">
										  		<span>
										   			Initial Device Setting
										  		</span>
											</td>
						 					<td></td>
  										</tr>
										<tr>
											<td>
											 	<span style="padding-left:30px">Incisal Edge Position (George/TAP Gauge Setting)</span>
											</td>
											<td>
												 <input type="text" onchange="checkIncisal()" name="initial_device_titration_1" id="i_pos" size="5" value="<?php echo $initial_device_titration_1; ?>" />mm 
											</td>
										</tr>
										<tr>
											<td>
										  		<span style="padding-left:30px">Vertical</span>
										  	</td>
										  	<td>
										  		 <input type="text" name="initial_device_titration_equal_v" id="initial_device_titration_equal_v" size="5" value="<?php echo $initial_device_titration_equal_v; ?>" />mm
						  					</td>
										</tr>
                           			</table>
                            		<input type="checkbox" name="range_normal" value="1" <?php if($range_normal == 1) echo " checked"; ?>/>
		                            Within normal limits
		                            <br /><br />
		                            NOTE: (Normal range of motion has been noted Vertical 40 - 50mm,  Lateral 12mm, Protrusive 9mm)
                        		</span>
                   			</div>
                    		<br />
		                </li>
		                <li id="foli8" class="complex">	
		                    <label class="desc" id="title0" for="Field0">
		                        Additional Paragraph
		                        /
		                        <button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=ex_page5frm&tx=additional_paragraph_rm'); return false;">Custom Text</button>
		                    </label>
		                    <div>
		                    	<span>
		                        	<textarea name="additional_paragraph_rm" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $additional_paragraph_rm;?></textarea>
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
	<script type="text/javascript">
		chk_normal();
	</script>

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
	<div id="popupContact1" style="width:750px;">
	    <a id="popupContactClose1">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop1" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup1"></div>
	<br /><br />	

<?php
	} else {  // end pt info check
		print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
	}
?>

<?php include "includes/bottom.htm";?>
