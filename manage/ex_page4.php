<?php namespace Ds3\Libraries\Legacy; ?><?php

use Illuminate\Support\Facades\App;

$dentalexpage4 = App::make('Ds3\Contracts\DentalExPage4Interface');

	include_once "includes/top.htm";
	include_once('includes/patient_info.php');
	if ($patient_info) {
?>
    <script type="text/javascript" src="js/ex_page4.js"></script>
    <script type="text/javascript" src="/manage/js/select_teeth_cross.js"></script>
<?php
    if(!empty($_POST['ex_page4sub']) && $_POST['ex_page4sub'] == 1) {
        $exam_teeth = $_POST['exam_teeth'];
        $other_maxilla = $_POST['other_maxilla'];
        $other_exam_teeth = $_POST['other_exam_teeth'];
        $caries = $_POST['caries'];
        $where_facets = $_POST['wear_facets'];
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

        if(is_array($exam_teeth)){
            foreach($exam_teeth as $val)
            {
                if(trim($val) <> '')
                    $exam_teeth_arr .= trim($val).'~';
            }
        }

        if($exam_teeth_arr != '') $exam_teeth_arr = '~'.$exam_teeth_arr;

        if($_POST['ed'] == '') {
           /*         $ins_sql = " insert into dental_ex_page4 set 
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
*/
        $data = array(
            'patientid' => s_for($_GET['pid']),
            'exam_teeth' => s_for($exam_teeth_arr),
            'other_exam_teeth' => s_for($other_exam_teeth),
            'caries' => s_for($caries),
            'where_facets' => s_for($where_facets),
            'cracked_fractured' => s_for($cracked_fractured),
            'missing' => s_for($missing),
            'old_worn_inadequate_restorations' => s_for($old_worn_inadequate_restorations),
            'dental_class_right' => s_for($dental_class_right),
            'dental_division_right' => s_for($dental_division_right),
            'dental_class_left' => s_for($dental_class_left),
            'dental_division_left' => s_for($dental_division_left),
            'additional_paragraph' => s_for($additional_paragraph),
            'initial_tooth' => s_for($initial_tooth),
            'open_proximal' => s_for($open_proximal),
            'deistema' => s_for($deistema),
            'crossbite' => s_for($crossbite),
            'userid' => s_for($_SESSION['userid']),
            'docid' => s_for($_SESSION['docid']),
            'adddate' => now(),
            'ip_address' => s_for($_SERVER['REMOTE_ADDR'])
            );
            // $db->query($ins_sql);
            $dentalexpage4->save($data);
            
            $msg = "Added Successfully";
            if(isset($_POST['ex_pagebtn_proceed'])){
?>
                <script type="text/javascript">
                    window.location='ex_page1.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
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
			$update_data  = array (
            'exam_teeth' => s_for($exam_teeth_arr),
            'other_exam_teeth' => s_for($other_exam_teeth),
            'caries' => s_for($caries),
            'where_facets' => s_for($where_facets),
            'missing' => s_for($missing),
            'cracked_fractured' => s_for($cracked_fractured),
            'old_worn_inadequate_restorations' => s_for($old_worn_inadequate_restorations),
            'dental_class_right' => s_for($dental_class_right),
            'dental_division_right' => s_for($dental_division_right),
            'dental_class_left' => '".s_for($dental_class_left)."',
            'dental_division_left' => s_for($dental_division_left),
            'additional_paragraph' => s_for($additional_paragraph),
            'initial_tooth' => s_for($initial_tooth),
            'open_proximal' => s_for($open_proximal),
            'deistema' => s_for($deistema),
            'crossbite' => s_for($crossbite)
            );

           $dentalexpage4->update($update_data,$_POST['ed']);
           
			$msg = "Edited Successfully";
            if(isset($_POST['ex_pagebtn_proceed'])){
?>
                <script type="text/javascript">
                    window.location='ex_page1.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
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
 // $pat_sql = "select * from dental_patients where patientidd='".s_for($_GET['pid'])."'";
    $pat_myarray = $dentalexpage4->findFromDentalPatients($_GET['pid']);
    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

    if($pat_myarray['patientid'] == '') {
?>
        <script type="text/javascript">
            window.location = 'manage_patient.php';
        </script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}

    // $sql = "select * from dental_ex_page4 where patientid='".$_GET['pid']."'";
    // $myarray = $db->getRow($sql);
    $myarray = $dentalexpage4->where($_GET['pid']);

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

    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="script/wufoo.js"></script>

    <a name="top"></a>
    &nbsp;&nbsp;

    <?php include_once("includes/form_top.htm"); ?>

    <br /><br>

    <div align="center" class="red">
        <b><?php  echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>

    <form id="ex_page4frm" class="ex_form" name="ex_page4frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post">
        <input type="hidden" name="ex_page4sub" value="1" />
        <input type="hidden" name="ed" value="<?php echo $ex_page4id;?>" />
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
                                    <input type="text" name="missing" value="<?php echo $missing?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=missing&fval='+document.ex_page4frm.missing.value); return false;">Change</button>
                                    <button onclick="toggle_perio(); return false;">Perio Chart</button>
                                </span>
                            </div>
                            <div id="perio_chart" style="display:none;">
                                <iframe name="perio_iframe" id="perio_iframe" src="missing_teeth_form.php?pid=<?php echo $_GET['pid']?>&mt=<?php echo  $missing ?>" width="920" height="840"></iframe>
                            </div>
                            <br />
                            <label class="desc" id="title0" for="Field0">
                                EXAMINATION OF TEETH REVEALED
                            </label>
                            <div>
                                <span>
                                    <?php
                                        $exam_teeth_sql = "select * from dental_exam_teeth where status=1 order by sortby";
                                        
                                        $exam_teeth_my = $db->getResults($exam_teeth_sql);
                                        foreach ($exam_teeth_my as $exam_teeth_myarray) {
                                    ?>
                                            <input type="checkbox" id="exam_teeth" name="exam_teeth[]" value="<?php echo st($exam_teeth_myarray['exam_teethid'])?>" <?php  if(strpos($exam_teeth,'~'.st($exam_teeth_myarray['exam_teethid']).'~') === false) {} else { echo " checked";}?> />
                                            &nbsp;&nbsp;
                                            <?php echo st($exam_teeth_myarray['exam_teeth']);?><br />
                                    <?php
                                        }
                                    ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <span style="color:#000000; padding-top:0px;">Other Items<br /></span>
                                    (Enter Each on Different Line)<br />
                                    <textarea name="other_exam_teeth" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_exam_teeth;?></textarea>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span style="color:#000000;">
                                    <label class="exam_label">Caries Tooth #</label>
                                    <input type="text" name="caries" value="<?php echo $caries?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=caries&fval='+document.ex_page4frm.caries.value); return false;">Change</button>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span style="color:#000000;">
                                    <label class="exam_label">Wear Facets Tooth #</label>
                                    <input type="text" name="wear_facets" value="<?php echo $where_facets?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=wear_facets&fval='+document.ex_page4frm.wear_facets.value); return false;">Change</button>
                                    <button onclick="Javascript: loadPopupRefer('select_general.php?tx=wear_facets&fval='+document.ex_page4frm.wear_facets.value); return false;">Generalized</button>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span style="color:#000000;">
                                    <label class="exam_label">Cracked or Fractured Tooth #</label>
                                    <input type="text" name="cracked_fractured" value="<?php echo $cracked_fractured?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=cracked_fractured&fval='+document.ex_page4frm.cracked_fractured.value); return false;">Change</button>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span style="color:#000000;">
                                    <label class="exam_label">Old, Worn or Inadequate Restorations Tooth #</label>
                                    <input type="text" name="old_worn_inadequate_restorations" value="<?php echo $old_worn_inadequate_restorations?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=old_worn_inadequate_restorations&fval='+document.ex_page4frm.old_worn_inadequate_restorations.value); return false;">Change</button>
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
                            <label class="desc" id="title0" for="Field0">DENTAL RELATIONSHIP</label>
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
                                                <input type="radio" name="dental_class_right" value="I (normal)" <?php  if($dental_class_right == 'I (normal)') echo " checked";?> style="width:10px;" />
                                                I (normal)
                                            </td>
                                            <td valign="top">
                                                <input type="radio" name="dental_division_right" value="1" <?php  if($dental_division_right == '1') echo " checked";?> style="width:10px;" />
                                                1
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <input type="radio" name="dental_class_right" value="II (Retrognathic)(Retruded Lower Jaw)" <?php  if($dental_class_right == 'II (Retrognathic)(Retruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                                II (Retrognathic)
                                                <br />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                (Retruded Lower Jaw)
                                            </td>
                                            <td valign="top">
                                                <input type="radio" name="dental_division_right" value="2" <?php  if($dental_division_right == '2') echo " checked";?> style="width:10px;" />
                                                2
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <input type="radio" name="dental_class_right" value="III (Prognathic)(Protruded Lower Jaw)" <?php  if($dental_class_right == 'III (Prognathic)(Protruded Lower Jaw)') echo " checked";?> style="width:10px;" />
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
                                                <input type="radio" name="dental_class_left" value="I (normal)" <?php  if($dental_class_left == 'I (normal)') echo " checked";?> style="width:10px;" />
                                                I (normal)
                                            </td>
                                            <td valign="top">
                                                <input type="radio" name="dental_division_left" value="1" <?php  if($dental_division_left == '1') echo " checked";?> style="width:10px;" />
                                                1
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <input type="radio" name="dental_class_left" value="II (Retrognathic)(Retruded Lower Jaw)" <?php  if($dental_class_left == 'II (Retrognathic)(Retruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                                II (Retrognathic)
                                                <br />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                (Retruded Lower Jaw)
                                            </td>
                                            <td valign="top">
                                                <input type="radio" name="dental_division_left" value="2" <?php  if($dental_division_right == '2') echo " checked";?> style="width:10px;" />
                                                2
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <input type="radio" name="dental_class_left" value="III (Prognathic)(Protruded Lower Jaw)" <?php  if($dental_class_left == 'III (Prognathic)(Protruded Lower Jaw)') echo " checked";?> style="width:10px;" />
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
                                <button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=ex_page4frm&tx=additional_paragraph'); return false;">Use Custom Text</button>
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
            <tr>
                <td valign="top" class="frmhead">
                    <ul>
                        <li id="foli8" class="complex"> 
                            <label class="desc" id="title0" for="Field0">
                                TOOTH CONTACT PRIOR TO ORAL APPLIANCE
                            </label>
                            <div>
                                <span>
                                    <label class="exam_label">Teeth in Crossbite</label>
                                    <input type="text" name="crossbite" value="<?php echo $crossbite;?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=crossbite&fval=<?php echo $crossbite;?>');  return false;">Chart</button>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span>
                                    <label class="exam_label">The initial tooth contact was between</label>
                                    <input type="text" name="initial_tooth" id="initial_tooth" value="<?php echo $initial_tooth;?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=initial_tooth&fval=<?php echo $initial_tooth;?>'); return false;">Chart</button>
                                    <button onclick="Javascript: $('#initial_tooth').val('Bilateral and even initial contact'); return false;">Bilateral and even initial contact</button>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span>
                                    <label class="exam_label">Open proximal contact(s) present between teeth numbers</label>
                                    <input type="text" name="open_proximal" value="<?php echo $open_proximal;?>" class="field text addr tbox" readonly="readonly" id="open_proximal" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=open_proximal&fval=<?php echo $open_proximal;?>'); return false;">Chart</button>
                                    <button onclick="$('#open_proximal').val('None'); return false;">None</button>
                                </span>
                            </div>
                            <br />
                            <div>
                                <span>
                                    <label class="exam_label">Diastema(s) present between teeth numbers</label>
                                    <input type="text" name="deistema" value="<?php echo $deistema;?>" class="field text addr tbox" readonly="readonly" />
                                    <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=deistema&fval=<?php echo $deistema;?>'); return false;">Chart</button>
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
        <?php  include_once("includes/form_bottom.htm");?>
    <br />
    <div id="popupRefer" style="width:750px;">
        <a id="popupReferClose">
            <button>X</button>
        </a>
        <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopupRef"></div>
    <div id="popupContact" style="width:750px; height: 500px;">
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

<?php  include_once "includes/bottom.htm";?>
