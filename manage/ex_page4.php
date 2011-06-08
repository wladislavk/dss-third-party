<?php
include "includes/top.htm";
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input :not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#ex_page4frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['ex_page4sub'] == 1)
{
	$exam_teeth = $_POST['exam_teeth'];
	$other_maxilla = $_POST['other_maxilla'];
	$other_exam_teeth = $_POST['other_exam_teeth'];
	$caries = $_POST['caries'];
	$where_facets = $_POST['where_facets'];
	$missing = $_POST['missing'];
	$cracked_fractured = $_POST['cracked_fractured'];
	$old_worn_inadequate_restorations = $_POST['old_worn_inadequate_restorations'];
	$dental_class_right = $_POST['dental_class_right'];
	$dental_division_right = $_POST['dental_division_right'];
	$dental_class_left = $_POST['dental_class_left'];
	$dental_division_left = $_POST['dental_division_left'];
	$initial_tooth = $_POST['initial_tooth'];
	$additional_paragraph = $_POST['additional_paragraph'];
	$open_proximal = $_POST['open_proximal'];
	$deistema = $_POST['deistema'];
	$crossbite = $_POST['crossbite'];
	
	$exam_teeth_arr = '';
	if(is_array($exam_teeth))
	{
		foreach($exam_teeth as $val)
		{
			if(trim($val) <> '')
				$exam_teeth_arr .= trim($val).'~';
		}
	}
	if($exam_teeth_arr != '')
		$exam_teeth_arr = '~'.$exam_teeth_arr;
		
	
	/*echo "exam_teeth - ".$exam_teeth_arr."<br>";
	echo "other_exam_teeth - ".$other_exam_teeth."<br>";
	echo "caries - ".$caries."<br>";
	echo "where_facets - ".$where_facets."<br>";
	echo "missing - ".$missing."<br>";
	echo "cracked_fractured - ".$cracked_fractured."<br>";
	echo "old_worn_inadequate_restorations - ".$old_worn_inadequate_restorations."<br>";
	echo "dental_class_right - ".$dental_class_right."<br>";
	echo "dental_division_right - ".$dental_division_right."<br>";
	echo "dental_class_left - ".$dental_class_left."<br>";
	echo "dental_division_left - ".$dental_division_left."<br>";
	echo "additional_paragraph - ".$additional_paragraph."<br>";
	echo "initial_tooth - ".$initial_tooth."<br>";
	echo "open_proximal - ".$open_proximal."<br>";
	echo "deistema - ".$deistema."<br>";
	echo "crossbite - ".$crossbite."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page4 set 
		formid = '".s_for($_GET['fid'])."',
		patientid = '".s_for($_GET['pid'])."',
		exam_teeth = '".s_for($exam_teeth_arr)."',
		other_exam_teeth = '".s_for($other_exam_teeth)."',
		caries = '".s_for($caries)."',
		where_facets = '".s_for($where_facets)."',
		cracked_fractured = '".s_for($cracked_fractured)."',
		missing = '".s_for($missing)."',
		old_worn_inadequate_restorations = '".s_for($old_worn_inadequate_restorations)."',
		dental_class_right = '".s_for($dental_class_right)."',
		dental_division_right = '".s_for($dental_division_right)."',
		dental_class_left = '".s_for($dental_class_left)."',
		dental_division_left = '".s_for($dental_division_left)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		initial_tooth = '".s_for($initial_tooth)."',
		open_proximal = '".s_for($open_proximal)."',
		deistema = '".s_for($deistema)."',
		crossbite = '".s_for($crossbite)."',
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
		$ed_sql = " update dental_ex_page4 set 
		exam_teeth = '".s_for($exam_teeth_arr)."',
		other_exam_teeth = '".s_for($other_exam_teeth)."',
		caries = '".s_for($caries)."',
		where_facets = '".s_for($where_facets)."',
		missing = '".s_for($missing)."',
		cracked_fractured = '".s_for($cracked_fractured)."',
		old_worn_inadequate_restorations = '".s_for($old_worn_inadequate_restorations)."',
		dental_class_right = '".s_for($dental_class_right)."',
		dental_division_right = '".s_for($dental_division_right)."',
		dental_class_left = '".s_for($dental_class_left)."',
		dental_division_left = '".s_for($dental_division_left)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		initial_tooth = '".s_for($initial_tooth)."',
		open_proximal = '".s_for($open_proximal)."',
		deistema = '".s_for($deistema)."',
		crossbite = '".s_for($crossbite)."'
		where ex_page4id = '".s_for($_POST['ed'])."'";
		
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

if($p_form_myarray['formid'] == '' && $_GET['fid'] == '' )
{
	$ins_sql = "insert into dental_forms set docid='".$_SESSION['docid']."', patientid = '".s_for($_GET["pid"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
	mysql_query($ins_sql) or die($ins_sql . " | ".mysql_error());
	
	$ins_id = mysql_insert_id();
	$_GET['fid'] = $ins_id;
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

$sql = "select * from dental_ex_page4 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page4id = st($myarray['ex_page4id']);
$exam_teeth = st($myarray['exam_teeth']);
$other_exam_teeth = st($myarray['other_exam_teeth']);
$caries = st($myarray['caries']);
$where_facets = st($myarray['where_facets']);
$missing = st($myarray['missing']);
$cracked_fractured = st($myarray['cracked_fractured']);
$old_worn_inadequate_restorations = st($myarray['old_worn_inadequate_restorations']);
$dental_class_right = st($myarray['dental_class_right']);
$dental_division_right = st($myarray['dental_division_right']);
$dental_class_left = st($myarray['dental_class_left']);
$dental_division_left = st($myarray['dental_division_left']);
$additional_paragraph = st($myarray['additional_paragraph']);
$initial_tooth = st($myarray['initial_tooth']);
$open_proximal = st($myarray['open_proximal']);
$deistema = st($myarray['deistema']);
$crossbite = st($myarray['crossbite']);

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

<form id="ex_page4frm" name="ex_page4frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="ex_page4sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page4id;?>" />
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
                        <span class="form_info">
                        	DENTAL SCREENING
                        </span>
                    </label>
				</li>
			</ul>
		</td>
	</tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
					<div>
                        <span style="color:#000000;">
                        	Missing Tooth # 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="text" name="missing" value="<?=$missing?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth.php?tx=missing&fval='+document.ex_page4frm.missing.value); getElementById('popupContact').style.top = '200px'; return false;">Change</button>
							
							<button onclick="Javascript: loadPopup('missing_teeth_form.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&mt='+document.ex_page4frm.missing.value); getElementById('popupContact').style.top = '200px'; getElementById('popupContact').style.height = '500px'; return false;">Perio Chart</button>
							
                        </span>
                    </div>
                    <br />
					
                    <label class="desc" id="title0" for="Field0">
                        EXAMINATION OF TEETH REVEALED
                    </label>
                    
                    <div>
                    	<span>
                        	<?
							$exam_teeth_sql = "select * from dental_exam_teeth where status=1 order by sortby";
							$exam_teeth_my = mysql_query($exam_teeth_sql);
							
							while($exam_teeth_myarray = mysql_fetch_array($exam_teeth_my))
							{
							?>
								<input type="checkbox" id="exam_teeth" name="exam_teeth[]" value="<?=st($exam_teeth_myarray['exam_teethid'])?>" <? if(strpos($exam_teeth,'~'.st($exam_teeth_myarray['exam_teethid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($exam_teeth_myarray['exam_teeth']);?><br />
							<?
							}
							?>
                        </span>
                   	</div>
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_exam_teeth" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_exam_teeth;?></textarea>
                        </span>
                    </div>
                    <br />
					
                    
                    <div>
                        <span style="color:#000000;">
                        	Caries Tooth # 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="text" name="caries" value="<?=$caries?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth.php?tx=caries&fval='+document.ex_page4frm.caries.value); getElementById('popupContact').style.top = '500px'; return false;">Change</button>
                        </span>
                    </div>
                    <br />
                    
                    <div>
                        <span style="color:#000000;">
                        	Wear Facets Tooth # 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;
                            <input type="text" name="where_facets" value="<?=$where_facets?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth.php?tx=where_facets&fval='+document.ex_page4frm.where_facets.value); getElementById('popupContact').style.top = '500px'; return false;">Change</button>
                        </span>
                    </div>
                    <br />
                    
                    <div>
                        <span style="color:#000000;">
                        	Cracked or Fractured Tooth # 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="cracked_fractured" value="<?=$cracked_fractured?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth.php?tx=cracked_fractured&fval='+document.ex_page4frm.cracked_fractured.value); getElementById('popupContact').style.top = '500px'; return false;">Change</button>
                        </span>
                    </div>
                    <br />
                    
                    <div>
                        <span style="color:#000000;">
                        	Old, Worn or Inadequate Restorations Tooth # 
                            &nbsp;
                            <input type="text" name="old_worn_inadequate_restorations" value="<?=$old_worn_inadequate_restorations?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth.php?tx=old_worn_inadequate_restorations&fval='+document.ex_page4frm.old_worn_inadequate_restorations.value); getElementById('popupContact').style.top = '500px'; return false;">Change</button>
                        </span>
                    </div>
                    <br />
                    
                    <!--<div>
                        <span style="color:#000000;">
                        	Teeth in Crossbite Tooth # 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="text" name="teeth_crossbite" value="<?=$teeth_crossbite?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth.php?tx=teeth_crossbite'); getElementById('popupContact').style.top = '500px'; return false;">Change</button>
                        </span>
                    </div>
                    <br /> -->
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        DENTAL RELATIONSHIP
                    </label>
                    
                    <div>
                    	<span class="left">
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<tr>
                                	<td valign="top" colspan="2" align="center" style="font-size:16px;">
                                    	Right
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top" width="60%">
                                    	<u>Class</u>
                                    </td>
                                	<td valign="top" width="40%">
                                    	<u>Division</u>
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<input type="radio" name="dental_class_right" value="I (normal)" <? if($dental_class_right == 'I (normal)') echo " checked";?> style="width:10px;" />
                                        I (normal)
                                    </td>
                                    <td valign="top">
                                    	<input type="radio" name="dental_division_right" value="1" <? if($dental_division_right == '1') echo " checked";?> style="width:10px;" />
                                        1
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<input type="radio" name="dental_class_right" value="II (Retrognathic)(Retruded Lower Jaw)" <? if($dental_class_right == 'II (Retrognathic)(Retruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        II (Retrognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Retruded Lower Jaw)
                                    </td>
                                    <td valign="top">
                                    	<input type="radio" name="dental_division_right" value="2" <? if($dental_division_right == '2') echo " checked";?> style="width:10px;" />
                                        2
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<input type="radio" name="dental_class_right" value="III (Prognathic)(Protruded Lower Jaw)" <? if($dental_class_right == 'III (Prognathic)(Protruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        III (Prognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Protruded Lower Jaw)
                                    </td>
                                    <td valign="top">&nbsp;
                                    	
                                    </td>
                                </tr>
                            </table>
                            
                        </span>
                        
                    	<span class="left">
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                            	<tr>
                                	<td valign="top" colspan="2" align="center" style="font-size:16px;">
                                    	Left
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top" width="60%">
                                    	<u>Class</u>
                                    </td>
                                	<td valign="top" width="40%">
                                    	<u>Division</u>
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<input type="radio" name="dental_class_left" value="I (normal)" <? if($dental_class_left == 'I (normal)') echo " checked";?> style="width:10px;" />
                                        I (normal)
                                    </td>
                                    <td valign="top">
                                    	<input type="radio" name="dental_division_left" value="1" <? if($dental_division_left == '1') echo " checked";?> style="width:10px;" />
                                        1
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<input type="radio" name="dental_class_left" value="II (Retrognathic)(Retruded Lower Jaw)" <? if($dental_class_left == 'II (Retrognathic)(Retruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        II (Retrognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Retruded Lower Jaw)
                                    </td>
                                    <td valign="top">
                                    	<input type="radio" name="dental_division_left" value="2" <? if($dental_division_right == '2') echo " checked";?> style="width:10px;" />
                                        2
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	<input type="radio" name="dental_class_left" value="III (Prognathic)(Protruded Lower Jaw)" <? if($dental_class_left == 'III (Prognathic)(Protruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        III (Prognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Protruded Lower Jaw)
                                    </td>
                                    <td valign="top">&nbsp;
                                    	
                                    </td>
                                </tr>
                            </table>
                            
                        </span>
                   	</div>
                    <br />
                    
                    <label class="desc" id="title0" for="Field0">
                        Other Items:
                        
                        <button onclick="Javascript: loadPopup('select_custom_all.php?fr=ex_page4frm&tx=additional_paragraph'); getElementById('popupContact').style.top = '700px'; return false;">Use Canned Text</button>
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
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        TOOTH CONTACT PRIOR TO ORAL APPLIANCE
                    </label>
                    
					<div>
                    	<span>
                    		Teeth in Crossbite
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="text" name="crossbite" value="<?=$crossbite;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth_cross.php?tx=crossbite&fval=<?=$crossbite;?>'); getElementById('popupContact').style.top = '750px' ;  return false;">Chart</button>
                    	</span>
                    </div>
                    <br />
                    
                    <div>
                    	<span>
                    		The initial tooth contact was between 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="text" name="initial_tooth" id="initial_tooth" value="<?=$initial_tooth;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth_cross.php?tx=initial_tooth&fval=<?=$initial_tooth;?>'); getElementById('popupContact').style.top = '750px' ;  return false;">Chart</button>
			    <button onclick="Javascript: $('#initial_tooth').val('Bilateral and even initial contact'); return false;">Bilateral and even initial contact</button>
                    	</span>
                    </div>
                    <br />
                    
                    <div>
                    	<span>
                    		Open proximal contact(s) present between teeth numbers 
                            &nbsp;&nbsp;
                            <input type="text" name="open_proximal" value="<?=$open_proximal;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth_cross.php?tx=open_proximal&fval=<?=$open_proximal;?>'); getElementById('popupContact').style.top = '750px' ;  return false;">Chart</button>
                    	</span>
                    </div>
                    <br />
                    
                    <div>
                    	<span>
                    		Diastema(s) present between teeth numbers 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <input type="text" name="deistema" value="<?=$deistema;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopup('select_teeth_cross.php?tx=deistema&fval=<?=$deistema;?>'); getElementById('popupContact').style.top = '750px' ;  return false;">Chart</button>
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
