<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once('includes/patient_info.php');

$db = new Db();
$baseTable = 'dental_ex_page2_view';
$baseSearch = [
    'patientid' => '$patientId',
    'docid' => '$docId',
];

/**
 * Define $patientId, $docId, $userId, $adminId
 * Define $isHistoricView, $historyId, $snapshotDate
 * Define $historyTable, $sourceTable
 * Define $isCreateNew, $isBackupTable
 *
 * Backup tables as needed
 */
require_once __DIR__ . '/includes/form-backup-setup.php';

if ($patient_info) {
?>
    <script type="text/javascript" src="js/ex_page2.js"></script>
    <?php
    if (!$isHistoricView && !empty($_POST['ex_page2sub']) && $_POST['ex_page2sub'] == 1) {
        $mallampati = (!empty($_POST['mallampati']) ? $_POST['mallampati'] : '');
        $tonsils = (!empty($_POST['tonsils']) ? $_POST['tonsils'] : '');
        $tonsils_grade = (!empty($_POST['tonsils_grade']) ? $_POST['tonsils_grade'] : '');
        $tonsils_arr = '';

        if (is_array($tonsils)) {
            foreach ($tonsils as $val) {
                if (trim($val) != '') {
                    $tonsils_arr .= trim($val) . '~';
                }
            }
        }

        if ($tonsils_arr != '') {
            $tonsils_arr = '~'.$tonsils_arr;
        }
	
        if ($_POST['ed'] == '') {
            $ins_sql = " insert into dental_ex_page2 set 
                patientid = '".s_for($_GET['pid'])."',
                mallampati = '".s_for($mallampati)."',
                additional_notes = '".mysqli_real_escape_string($con, $_POST['additional_notes'])."',
                tonsils = '".s_for($tonsils_arr)."',
                tonsils_grade = '".s_for($tonsils_grade)."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
            $db->query($ins_sql);

            $msg = "Added Successfully";
            if (isset($_POST['ex_pagebtn_proceed'])) { ?>
                <script type="text/javascript">
                    window.location='ex_page3.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?php
            } else { ?>
                <script type="text/javascript">
                    window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?php
            }
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ed_sql = " update dental_ex_page2 set 
        		mallampati = '".s_for($mallampati)."',
                additional_notes = '".mysqli_real_escape_string($con, $_POST['additional_notes'])."',
        		tonsils = '".s_for($tonsils_arr)."',
        		tonsils_grade = '".s_for($tonsils_grade)."'
        		where ex_page2id = '".s_for($_POST['ed'])."'";
            $db->query($ed_sql);

            $msg = "Edited Successfully";
            if (isset($_POST['ex_pagebtn_proceed'])) { ?>
                <script type="text/javascript">
                    window.location='ex_page3.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?php
            } else { ?>
                <script type="text/javascript">
                    window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?php
            }
            trigger_error("Die called", E_USER_ERROR);
        }
    }

    $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
    $pat_myarray = $db->getRow($pat_sql);

    $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
    if ($pat_myarray['patientid'] == '') { ?>
        <script type="text/javascript">
            window.location = 'manage_patient.php';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $sql = "select *
        from $sourceTable
        where patientid = '$patientId'
        $andHistoryIdConditional
        $andNullConditional";
    $myarray = $db->getRow($sql);

    $ex_page2id = st($myarray['ex_page2id']);
    $mallampati = st($myarray['mallampati']);
    $additional_notes = $myarray['additional_notes'];
    $tonsils = st($myarray['tonsils']);
    $tonsils_grade = st($myarray['tonsils_grade']); ?>

    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/form.css" type="text/css" />

    <a name="top"></a>
    &nbsp;&nbsp;
    <?php include "includes/form_top.htm"; ?>
    <br /><br>
    <div align="center" class="red">
    	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>
    <form id="ex_page2frm" class="ex_form" name="ex_page2frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?><?= $isHistoricView ? "&history_id=$historyId" : '' ?>" method="post">
        <input type="hidden" name="ex_page2sub" value="1" />
        <input type="hidden" name="ed" value="<?= $targetId ?: '' ?>" />
        <input type="hidden" name="backup_table" value="<?= $isCreateNew ?>" />
        <input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />

        <div style="float:right;">
            <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
            <input type="submit" value="" style="visibility: hidden; width: 0; height: 0; position: absolute;" onclick="return false;" onsubmit="return false;" onchange="return false;" />
            <button class="do-backup hidden" title="Save a copy of the last saved values">
                <span class="done">Archive page</span>
                <span class="in-progress" style="display:none;">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
            </button>
            <input type="submit" name="ex_pagebtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
            <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" <?= $isHistoricView ? 'disabled' : '' ?> />
            &nbsp;&nbsp;&nbsp;
        </div>
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
                                            	<img src="images/class1.jpg" height="201" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="mallampati" value="Class I" <?php if ($mallampati == 'Class I') echo " checked";?> /> Class I
                                            </td>
                                        	<td valign="top" width="25%" align="center">
                                            	<img src="images/class2.jpg" height="201" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="mallampati" value="Class II" <?php if ($mallampati == 'Class II') echo " checked";?> /> Class II
                                            </td>
                                        	<td valign="top" width="25%" align="center">
                                            	<img src="images/class3.jpg" height="201" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="mallampati" value="Class III" <?php if ($mallampati == 'Class III') echo " checked";?> /> Class III
                                            </td>
                                        	<td valign="top" width="25%" align="center">
                                            	<img src="images/class4.jpg" height="201" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="mallampati" value="Class IV" <?php if ($mallampati == 'Class IV') echo " checked";?> /> Class IV
                                            </td>
                                        </tr>
                                    </table>
                                </span>
                    			<span>
                    				Additional Notes
                                    <button onclick="loadPopupRefer('select_custom_all.php?fr=ex_page2frm&tx=additional_notes'); return false;">Use Custom Text</button>
                                    <br />
                    				<textarea name="additional_notes" style="width:255px; height:187px"><?php echo $additional_notes; ?></textarea>
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
                                	<input type="checkbox" id="tonsils_present" name="tonsils[]" value="Present" <?php if (strpos($tonsils, '~Present~') !== false) { echo " checked";}?> />
                                    Present
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" id="tonsils_obstructive" name="tonsils[]" value="Obstructive" <?php if (strpos($tonsils, '~Obstructive~') !== false) { echo " checked";}?> />
                                    Obstructive
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" id="tonsils_purulent" name="tonsils[]" value="Purulent" <?php if (strpos($tonsils, '~Purulent~') !== false) { echo " checked";}?> />
                                    Purulent
                                </span>
                           </div>   
                           <br />
                           <div>
                            	<span>
                                	<table width="100%" cellpadding="3" cellspacing="1" border="0">
                                    	<tr>
                                        	<td valign="top" width="20%" align="center">
                                            	<img src="images/grade0.png" height="188" width="131" border="0" />
                                                <br />
                                                <input type="radio" id="tonsils_grade0" name="tonsils_grade" value="Grade 0" <?php if ($tonsils_grade == 'Grade 0') echo " checked";?> /> Grade 0
                                                <br /><br />
                                                Absent
                                            </td>
                                        	<td valign="top" width="20%" align="center">
                                            	<img src="images/grade1.png" height="188" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="tonsils_grade" value="Grade 1" <?php if ($tonsils_grade == 'Grade 1') echo " checked";?> /> Grade 1
                                                <br /><br />
                                                Small within the tonsillar fossa
                                            </td>
                                        	<td valign="top" width="25%" align="center">
                                            	<img src="images/grade2.png" height="188" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="tonsils_grade" value="Grade 2" <?php if ($tonsils_grade == 'Grade 2') echo " checked";?> /> Grade 2
                                                <br /><br />
                                                Extends beyond the tonsillar pillar
                                            </td>
                                        	<td valign="top" width="25%" align="center">
                                            	<img src="images/grade3.png" height="188" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="tonsils_grade" value="Grade 3" <?php if ($tonsils_grade == 'Grade 3') echo " checked";?> /> Grade 3
                                                <br /><br />
                                                Hypertrophic but not touching in midline
                                            </td>
                                        	<td valign="top" width="20%" align="center">
                                            	<img src="images/grade4.png" height="188" width="131" border="0" />
                                                <br />
                                                <input type="radio" name="tonsils_grade" value="Grade 4" <?php if ($tonsils_grade == 'Grade 4') echo " checked";?> /> Grade 4
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
        <div style="float:right;">
            <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
            <input type="submit" value="" style="visibility: hidden; width: 0; height: 0; position: absolute;" onclick="return false;" onsubmit="return false;" onchange="return false;" />
            <button class="do-backup hidden" title="Save a copy of the last saved values">
                <span class="done">Archive page</span>
                <span class="in-progress" style="display:none;">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
            </button>
            <input type="submit" name="ex_pagebtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
            <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" <?= $isHistoricView ? 'disabled' : '' ?> />
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>

    <br />
        <?php include "includes/form_bottom.htm"; ?>
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
    echo "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}
?>
<?php include __DIR__ . '/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<?php include "includes/bottom.htm";?>
