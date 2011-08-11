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
		$('#ex_page5frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function setDefaults(){
    $('#topcb select').val(0).attr('selected', 'selected');
  }
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>

<?php
if($_POST['ex_page5sub'] == 1)
{
	$additional_paragraph_pal = $_POST['additional_paragraph_pal'];
	$caries = $_POST['caries'];
	$joint_exam = $_POST['joint_exam'];
	$i_opening_from = $_POST['i_opening_from'];
	$i_opening_to = $_POST['i_opening_to'];
	$i_opening_equal = $_POST['i_opening_equal'];
	$protrusion_from = $_POST['protrusion_from'];
	$protrusion_to = $_POST['protrusion_to'];
	$protrusion_equal = $_POST['protrusion_equal'];
	$l_lateral_from = $_POST['l_lateral_from'];
	$l_lateral_to = $_POST['l_lateral_to'];
	$l_lateral_equal = $_POST['l_lateral_equal'];
	$r_lateral_from = $_POST['r_lateral_from'];
	$r_lateral_to = $_POST['r_lateral_to'];
	$r_lateral_equal = $_POST['r_lateral_equal'];
	$deviation_from = $_POST['deviation_from'];
	$deviation_to = $_POST['deviation_to'];
	$deviation_equal = $_POST['deviation_equal'];
	$deflection_from = $_POST['deflection_from'];
	$deflection_to = $_POST['deflection_to'];
	$deflection_equal = $_POST['deflection_equal'];
	$range_normal = $_POST['range_normal'];
	$normal = $_POST['normal'];
	$other_range_motion = $_POST['other_range_motion'];
	$additional_paragraph_rm = $_POST['additional_paragraph_rm'];
	$screening_aware = $_POST['screening_aware'];
	$screening_normal = $_POST['screening_normal'];
	$deviation_r_l = $_POST['deviation_r_l'];
	$deflection_r_l = $_POST['deflection_r_l'];
	
	$palpation_sql = "select * from dental_palpation where status=1 order by sortby";
	$palpation_my = mysql_query($palpation_sql);
	
	$pal_arr = '';
	$palR_arr = '';
	while($palpation_myarray = mysql_fetch_array($palpation_my))
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
	$joint_my = mysql_query($joint_sql);
	
	$joi_arr = '';
	while($joint_myarray = mysql_fetch_array($joint_my))
	{
		if($_POST['joint_'.$joint_myarray['jointid']] <> '')
		{
			$joi_arr .= $joint_myarray['jointid'].'|'.$_POST['joint_'.$joint_myarray['jointid']].'~';
		}
	}
	
	$join_exam_arr = '';
	if(is_array($joint_exam))
	{
		foreach($joint_exam as $val)
		{
			if(trim($val) <> '')
				$joint_exam_arr .= trim($val).'~';
		}
	}
	if($joint_exam_arr != '')
		$joint_exam_arr = '~'.$joint_exam_arr;
		
	
	/*echo "palpationid - ".$pal_arr."<br>";
	echo "palpationRid - ".$palR_arr."<br>";
	echo "additional_paragraph_pal - ".$additional_paragraph_pal."<br>";
	echo "joint_exam - ".$joint_exam_arr."<br>";
	echo "jointid - ".$joi_arr."<br>";
	echo "i_opening_from - ".$i_opening_from."<br>";
	echo "i_opening_to - ".$i_opening_to."<br>";
	echo "i_opening_equal - ".$i_opening_equal."<br>";
	echo "protrusion_from - ".$protrusion_from."<br>";
	echo "protrusion_to - ".$protrusion_to."<br>";
	echo "protrusion_equal - ".$protrusion_equal."<br>";
	echo "l_lateral_from - ".$l_lateral_from."<br>";
	echo "l_lateral_to - ".$l_lateral_to."<br>";
	echo "l_lateral_equal - ".$l_lateral_equal."<br>";
	echo "r_lateral_from - ".$r_lateral_from."<br>";
	echo "r_lateral_to - ".$r_lateral_to."<br>";
	echo "r_lateral_equal - ".$r_lateral_equal."<br>";
	echo "deviation_from - ".$deviation_from."<br>";
	echo "deviation_to - ".$deviation_to."<br>";
	echo "deviation_equal - ".$deviation_equal."<br>";
	echo "deflection_from - ".$deflection_from."<br>";
	echo "deflection_to - ".$deflection_to."<br>";
	echo "deflection_equal - ".$deflection_equal."<br>";
	echo "range_normal - ".$range_normal."<br>";
	echo "normal - ".$normal."<br>";
	echo "other_range_motion - ".$other_range_motion."<br>";
	echo "additional_paragraph_rm - ".$additional_paragraph_rm."<br>";
	echo "screening_aware - ".$screening_aware."<br>";
	echo "screening_normal - ".$screening_normal."<br>";
	echo "deviation_r_l - ".$deviation_r_l."<br>";
	echo "deflection_r_l - ".$deflection_r_l."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page5 set 
		formid = '".s_for($_GET['fid'])."',
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
		screening_aware = '".s_for($screening_aware)."',
		screening_normal = '".s_for($screening_normal)."',
		deviation_r_l = '".s_for($deviation_r_l)."',
		deflection_r_l = '".s_for($deflection_r_l)."',
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
		screening_aware = '".s_for($screening_aware)."',
		screening_normal = '".s_for($screening_normal)."',
		deviation_r_l = '".s_for($deviation_r_l)."',
		deflection_r_l = '".s_for($deflection_r_l)."'
		where ex_page5id = '".s_for($_POST['ed'])."'";
		
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

$sql = "select * from dental_ex_page5 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

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
$screening_aware = st($myarray['screening_aware']);
$screening_normal = st($myarray['screening_normal']);
$deviation_r_l = st($myarray['deviation_r_l']);
$deflection_r_l = st($myarray['deflection_r_l']);


if($palpationid <> '')
{	
	$pal_arr1 = split('~',$palpationid);
	
	foreach($pal_arr1 as $i => $val)
	{
		$pal_arr2 = explode('|',$val);
		
		$palid[$i] = $pal_arr2[0];
		$palseq[$i] = $pal_arr2[1];
	}
}

if($palpationRid <> '')
{	
	$palR_arr1 = split('~',$palpationRid);
	
	foreach($palR_arr1 as $i => $val)
	{
		$palR_arr2 = explode('|',$val);
		
		$palRid[$i] = $palR_arr2[0];
		$palRseq[$i] = $palR_arr2[1];
	}
}

if($jointid <> '')
{	
	$jo_arr1 = split('~',$jointid);
	
	foreach($jo_arr1 as $i => $val)
	{
		$jo_arr2 = explode('|',$val);
		
		$joid[$i] = $jo_arr2[0];
		$joseq[$i] = $jo_arr2[1];
	}
}

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup1.js" type="text/javascript"></script>

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
	function chk_normal()
	{
		fa = document.ex_page5frm;
		
		//alert(fa.range_normal.checked);
		if(fa.range_normal.checked)
		{
			fa.i_opening_from.disabled = true;
			fa.protrusion_from.disabled = true;
			fa.protrusion_to.disabled = true;
			fa.protrusion_equal.disabled = true;
			fa.l_lateral_from.disabled = true;
			fa.r_lateral_from.disabled = true;
			fa.deviation_from.disabled = true;
			fa.deflection_from.disabled = true;
			fa.deviation_r_l.disabled = true;
			fa.deflection_r_l.disabled = true;
		}
		else
		{
			fa.i_opening_from.disabled = false;
			fa.protrusion_from.disabled = false;
			fa.protrusion_to.disabled = false;
			fa.protrusion_equal.disabled = false;
			fa.l_lateral_from.disabled = false;
			fa.r_lateral_from.disabled = false;
			fa.deviation_from.disabled = false;
			fa.deflection_from.disabled = false;
			fa.deviation_r_l.disabled = false;
			fa.deflection_r_l.disabled = false;
		}
	}
</script>

<form id="ex_page5frm" name="ex_page5frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="ex_page5sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page5id;?>" />
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
	<br />	<button onclick="setDefaults();return false;">Set all to 0</button>
					
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
                                	<td valign="top" width="60%">&nbsp;
                                    	
                                    </td>
                                </tr>
                                
                                <?
								$palpation_sql = "select * from dental_palpation where status=1 order by sortby";
								$palpation_my = mysql_query($palpation_sql);
								
								while($palpation_myarray = mysql_fetch_array($palpation_my))
								{
									if(@array_search($palpation_myarray['palpationid'],$palid) === false)
									{
										$chk = '';
									}
									else
									{
										$chk = $palseq[@array_search($palpation_myarray['palpationid'],$palid)];
									}
									
									if(@array_search($palpation_myarray['palpationid'],$palRid) === false)
									{
										$chkR = '';
									}
									else
									{
										$chkR = $palRseq[@array_search($palpation_myarray['palpationid'],$palRid)];
									}
									
								?>
                                <tr>
                                	<td valign="top">
										<select id="palpation_<?=st($palpation_myarray['palpationid']);?>" name="palpation_<?=st($palpation_myarray['palpationid']);?>" class="field text addr tbox" style="width:50px;">
											<option value=""></option>
											<option value="0" <? if($chk == '0') echo " selected";?> class="ex_p5_0">
												0
											</option>
											<option value="1" <? if($chk == '1') echo " selected";?> class="ex_p5_1">
												1
											</option>
											<option value="2" <? if($chk == '2') echo " selected";?> class="ex_p5_2">
												2
											</option>
											<option value="3" <? if($chk == '3') echo " selected";?> class="ex_p5_3">
												3
											</option>
											
										</select>
                                     </td>
                                     <td valign="top">
                                     	<select id="palpationR_<?=st($palpation_myarray['palpationid']);?>" name="palpationR_<?=st($palpation_myarray['palpationid']);?>" class="field text addr tbox" style="width:50px;">
											<option value=""></option>
											<option value="0" <? if($chkR == '0') echo " selected";?> class="ex_p5_0">
												0
											</option>
											<option value="1" <? if($chkR == '1') echo " selected";?> class="ex_p5_1">
												1
											</option>
											<option value="2" <? if($chkR == '2') echo " selected";?> class="ex_p5_2">
												2
											</option>
											<option value="3" <? if($chkR == '3') echo " selected";?> class="ex_p5_3">
												3
											</option>
											
										</select>
                                     </td>
                                     <td valign="top">
                                     	<span>
										<?=st($palpation_myarray['palpation']);?>
                                        </span>
                                     </td>
                                  </tr>	
								<? 
								}?>
                                <tr>
                                	<td valign="top" colspan="3" align="right">
                                    	<button onclick="Javascript: loadPopupRefer('custom_palpation.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>'); getElementById('popupContact').style.top = '300px'; return false;">Customize</button>
                                    </td>
                                </tr>
                            </table>
                        </span>
                   	</div>
                    <br />
                    
                    <!--<div>
                    	<span>
                            <input type="checkbox" name="palpation_normal" value="1" />
                            Within normal limits
                        </span>
                    </div> -->
                </li>
                
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Additional Paragraph
                        /
                        <button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=ex_page5frm&tx=additional_paragraph_pal'); getElementById('popupContact1').style.top = '400px'; return false;">Custom Text</button>
                    </label>
                    
                    <div>
                    	<span>
                        	<textarea name="additional_paragraph_pal" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_pal;?></textarea>
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
                        Joint Sounds
                    </label>
                    
                    <div>
                    	<span >
                        	Examination Type:
                        </span>
                   	</div>
                    
                    <div>
                    	<span class="full">
                        	<table width="100%" cellpadding="3" cellspacing="1" >
                            	<tr>
                                	<td valign="top" width="40%"><span>
                                    	<?
										$joint_exam_sql = "select * from dental_joint_exam where status=1 order by sortby";
										$joint_exam_my = mysql_query($joint_exam_sql);
										
										while($joint_exam_myarray = mysql_fetch_array($joint_exam_my))
										{
										?>
											<input type="checkbox" id="joint_exam" name="joint_exam[]" value="<?=st($joint_exam_myarray['joint_examid'])?>" <? if(strpos($joint_exam,'~'.st($joint_exam_myarray['joint_examid']).'~') === false) {} else { echo " checked";}?> style="width:10px;" />
											&nbsp;&nbsp;
											<?=st($joint_exam_myarray['joint_exam']);?><br />
										<?
										}
										?></span>
                                    </td>
                                    <td valign="top">
                                    	<table width="100%" cellpadding="3" cellspacing="1">                                        	<?
											$joint_sql = "select * from dental_joint where status=1 order by sortby";
											$joint_my = mysql_query($joint_sql);
											
											while($joint_myarray = mysql_fetch_array($joint_my))
											{
												if(@array_search($joint_myarray['jointid'],$joid) === false)
												{
													$chkJ = '';
												}
												else
												{
													$chkJ = $joseq[@array_search($joint_myarray['jointid'],$joid)];
												}
											?>
                                            	<tr>
                                                	<td valign="top" width="40%"> <span>
														<?=st($joint_myarray['joint']);?></span>
                                                    </td>
                                                    <td valign="top">
                                                        <select id="joint_<?=st($joint_myarray['jointid']);?>" name="joint_<?=st($joint_myarray['jointid']);?>" class="field text addr tbox" style="width:50px;">
                                                            <option value=""></option>
                                                            <option value="L" <? if($chkJ == 'L') echo " selected";?> >
                                                                L
                                                            </option>
                                                            <option value="R" <? if($chkJ == 'R') echo " selected";?>>
                                                                R
                                                            </option>
                                                            <option value="B" <? if($chkJ == 'B') echo " selected";?>>
                                                                B
                                                            </option>
                                                        </select>
													</td>
												</tr>
											<?
											}
											?>
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
                                        <input type="text" name="i_opening_from" class="field text addr tbox" style="width:50px;" value="<?=$i_opening_from;?>">
                                        </span>
                                    </td>
                                </tr>

                               <script type="text/javascript">
				  function updateProtrusion(){
					pval = Math.abs($('#protrusion_to').val() - $('#protrusion_from').val());
					$('#protrusion_equal').val(pval);

                                  }
			       </script>
                               <tr>
                                </td>
                                    <td valign="top">
                                    <span>George Scale</span>
                                    </td>
                                        <td valign="top">
                                        <input type="text" id="protrusion_from" name="protrusion_from" onkeyup="updateProtrusion();" class="field text addr tbox" style="width:50px;" value="<?=$protrusion_from;?>">
                                        &nbsp;&nbsp;&nbsp;
                                        to
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="text" id="protrusion_to" name="protrusion_to" onkeyup="updateProtrusion();" class="field text addr tbox" style="width:50px;" value="<?=$protrusion_to;?>">

                                        </span>
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
                                    	<input type="text" id="protrusion_equal" name="protrusion_equal" class="field text addr tbox" style="width:50px;" value="<?php echo abs($protrusion_to-($protrusion_from));?>">                                     </td>
                                </tr>
                                
                                <tr>
                                	<td valign="top">
                                    	<span>
                                    	Left Lateral Excursion
                                        </span>
                                    </td>
                                    <td valign="top">
                                    	<span>
                                    	<input type="text" name="l_lateral_from" class="field text addr tbox" style="width:50px;" value="<?=$l_lateral_from;?>">
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
                                    	<input type="text" name="r_lateral_from" class="field text addr tbox" style="width:50px;" value="<?=$r_lateral_from;?>">
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
											<option value="Right" <? if($deviation_r_l == 'Right') echo " selected";?> >
												Right
											</option>
											<option value="Left" <? if($deviation_r_l == 'Left') echo " selected";?>>
												Left
											</option>
										</select>
                                    </td>
                                    <td valign="top">
                                    	<span>
                                    	<input type="text" name="deviation_from" class="field text addr tbox" style="width:50px;" value="<?=$deviation_from;?>">
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
											<option value="Right" <? if($deflection_r_l == 'Right') echo " selected";?> >
												Right
											</option>
											<option value="Left" <? if($deflection_r_l == 'Left') echo " selected";?>>
												Left
											</option>
										</select>
                                    </td>
                                    <td valign="top">
                                    	<span>
                                    	<input type="text" name="deflection_from" class="field text addr tbox" style="width:50px;" value="<?=$deflection_from;?>">
                                        </span>
                                    </td>
                                </tr>    
                            </table>
                            
                            <input type="checkbox" name="range_normal" value="1" <? if($range_normal == 1) echo " checked"; ?>/>
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
                        	<textarea name="additional_paragraph_rm" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_rm;?></textarea>
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
                        Craniomandibular Screening
                    </label>
                    
                    <div>
                    	<span>
                        	<input type="checkbox" name="screening_aware" value="1" <? if($screening_aware == 1) echo " checked"; ?>/>
                            Patient is aware of a temporomandibular disorder
                            
                        	<br /><br>
                        	<input type="checkbox" name="screening_normal" value="1" <? if($screening_normal == 1) echo " checked"; ?>/>
                            Within normal limits
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

<script type="text/javascript">
	chk_normal();
</script>


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

<div id="popupContact1" style="width:750px;">
    <a id="popupContactClose1"><button>X</button></a>
    <iframe id="aj_pop1" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup1"></div>

<br /><br />	

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>


<? include "includes/bottom.htm";?>
