<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";

$db = new Db();
$baseTable = 'dental_ex_page8_pivot';
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
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(':input:not(#patient_search)').change(function() {
            window.onbeforeunload = confirmExit;
        });
        $('#ex_page8frm').submit(function() {
            window.onbeforeunload = null;
        });
    });
    function confirmExit() {
        return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
    }
</script>
<?php
if (!$isHistoricView && $_POST['ex_page8sub'] == 1) {
    $inserted = $_POST['inserted'];
    $recommended = $_POST['recommended'];
    $other_inserted = $_POST['other_inserted'];
    $other_recommended = $_POST['other_recommended'];
    $see_number = $_POST['see_number'];
    $see_type = $_POST['see_type'];
    $followup = $_POST['followup'];
    $additional_paragraph_followup = $_POST['additional_paragraph_followup'];
    $plan_enable_referral =$_POST['plan_enable_referral'];
    $referring = $_POST['referring'];
    $additional_paragraph_referral = $_POST['additional_paragraph_referral'];
    $device = $_POST['device'];

    $inserted_arr = '';
    if (is_array($inserted)) {
        foreach ($inserted as $val) {
            if (trim($val) != '') {
                $inserted_arr .= trim($val) . '~';
            }
        }
    }
    if ($inserted_arr != '') {
        $inserted_arr = '~' . $inserted_arr;
    }

    $recommended_arr = '';
    if (is_array($recommended)) {
        foreach ($recommended as $val) {
            if (trim($val) != '') {
                $recommended_arr .= trim($val) . '~';
            }
        }
    }
    if ($recommended_arr != '') {
        $recommended_arr = '~' . $recommended_arr;
    }

    $followup_arr = '';
    if (is_array($followup)) {
        foreach ($followup as $val) {
            if (trim($val) != '') {
                $followup_arr .= trim($val) . '~';
            }
        }
    }
    if ($followup_arr != '') {
        $followup_arr = '~' . $followup_arr;
    }

    if ($_POST['ed'] == '') {
        $ins_sql = "insert into dental_ex_page8 set 
            patientid = '".s_for($_GET['pid'])."',
            inserted = '".s_for($inserted_arr)."',
            recommended = '".s_for($recommended_arr)."',
            other_inserted = '".s_for($other_inserted)."',
            other_recommended = '".s_for($other_recommended)."',
            see_number = '".s_for($see_number)."',
            see_type = '".s_for($see_type)."',
            followup = '".s_for($followup_arr)."',
            additional_paragraph_followup = '".s_for($additional_paragraph_followup)."',
            referring = '".s_for($referring)."',
            plan_enable_referral = '".s_for($plan_enable_referral)."',
            additional_paragraph_referral = '".s_for($additional_paragraph_referral)."',
            device = '".s_for($device)."',
            userid = '".s_for($_SESSION['userid'])."',
            docid = '".s_for($_SESSION['docid'])."',
            adddate = now(),
            ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
        mysqli_query($con, $ins_sql) or trigger_error($ins_sql." | ".mysqli_error($con), E_USER_ERROR);
        $msg = "Added Successfully";
        ?>
        <script type="text/javascript">
            window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
        </script>
        <?
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ed_sql = "update dental_ex_page8 set 
            inserted = '".s_for($inserted_arr)."',
            recommended = '".s_for($recommended_arr)."',
            other_inserted = '".s_for($other_inserted)."',
            other_recommended = '".s_for($other_recommended)."',
            see_number = '".s_for($see_number)."',
            see_type = '".s_for($see_type)."',
            followup = '".s_for($followup_arr)."',
            additional_paragraph_followup = '".s_for($additional_paragraph_followup)."',
            referring = '".s_for($referring)."',
            plan_enable_referral = '".s_for($plan_enable_referral)."',
            device = '".s_for($device)."',
            additional_paragraph_referral = '".s_for($additional_paragraph_referral)."'
            where ex_page8id = '".s_for($_POST['ed'])."'";
        mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
        $msg = "Edited Successfully";
        ?>
        <script type="text/javascript">
            window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con, $pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

$fullname = st($pat_myarray['salutation']).$name;

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

$my = mysqli_query($con, $sql);
$myarray = mysqli_fetch_array($my);

$ex_page8id = st($myarray['ex_page8id']);
$inserted = st($myarray['inserted']);
$recommended = st($myarray['recommended']);
$other_inserted = st($myarray['other_inserted']);
$other_recommended = st($myarray['other_recommended']);
$see_number = st($myarray['see_number']);
$see_type = st($myarray['see_type']);
$followup = st($myarray['followup']);
$additional_paragraph_followup = st($myarray['additional_paragraph_followup']);
$referring = st($myarray['referring']);
$plan_enable_referral = st($myarray['plan_enable_referral']);
$additional_paragraph_referral = st($myarray['additional_paragraph_referral']);
$device = st($myarray['device']);

if ($see_type == "") {
    $see_type = "Weeks";
}
?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<a name="top"></a>
&nbsp;&nbsp;
<a href="manage_forms.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
    <b>&lt;&lt;Back To Forms</b>
</a>
<br />
<?php include "includes/form_top.htm";?>
<br />
<br />
<div align="center" class="red">
    <b><?php echo $_GET['msg'];?></b>
</div>

<form id="ex_page8frm" class="ex_form" name="ex_page8frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?><?= $isHistoricView ? "&history_id=$historyId" : '' ?>" method="post" >
    <input type="hidden" name="ex_page8sub" value="1" />
    <input type="hidden" name="ed" value="<?= $targetId ?: '' ?>" />
    <input type="hidden" name="backup_table" value="<?= $isCreateNew ?>" />
    <input type="hidden" name="goto_p" value="<?=$cur_page?>" />

    <div align="right">
        <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
        <input type="submit" name="ex_pagebtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
        <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" <?= $isHistoricView ? 'disabled' : '' ?> />
        &nbsp;&nbsp;&nbsp;
    </div>
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">
                            PLAN/PROGRESS
                        </label>
                        <div>
                            <span class="full">
                                <table width="100%" cellpadding="3" cellspacing="1">
                                    <tr>
                                        <td valign="top" width="10%">
                                            Inserted
                                        </td>
                                        <td valign="top" width="10%">
                                            Recommended
                                        </td>
                                        <td valign="top" width="80%">&nbsp;</td>
                                    </tr>
                                    <?php
                                    $device_sql = "select * from dental_device where status=1 order by sortby";
                                    $device_my = mysqli_query($con, $device_sql);
                                    while ($device_myarray = mysqli_fetch_array($device_my)) { ?>
                                        <tr>
                                            <td valign="top">
                                                <input type="checkbox" id="inserted" name="inserted[]" value="<?=st($device_myarray['deviceid'])?>" <?php if (strpos($inserted, '~'.st($device_myarray['deviceid']).'~') !== false) { echo " checked";}?> style="width:10px;" />
                                            </td>
                                            <td valign="top">
                                                <input type="checkbox" id="recommended" name="recommended[]" value="<?=st($device_myarray['deviceid'])?>" <?php if (strpos($recommended, '~'.st($device_myarray['deviceid']).'~') !== false) { echo " checked";}?> style="width:10px;" />
                                            </td>
                                            <td valign="top">
                                                <span>
                                                <?=st($device_myarray['device']);?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                    } ?>
                                </table>
                            </span>
                        </div>
                        <br />
                        <div>
                            <span>
                                <span style="color:#000000; padding-top:0;">
                                    Other Items [Inserted]<br />
                                </span>
                                <br />
                                <textarea name="other_inserted" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_inserted;?></textarea>
                            </span>
                        </div>
                        <br />
                        <div>
                            <span>
                                <span style="color:#000000; padding-top:0;">
                                    Other Items [Recommended]<br />
                                </span>
                                <br />
                                <textarea name="other_recommended" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_recommended;?></textarea>
                            </span>
                        </div>
                        <br />
                        <?php
                        $plan_text_sql = "select * from dental_plan_text";
                        $plan_text_my = mysqli_query($con, $plan_text_sql);
                        $plan_text_myarray = mysqli_fetch_array($plan_text_my) or trigger_error($plan_text_sql.' | '.mysqli_error($con), E_USER_ERROR);
                        ?>
                        <div>
                            <span style="font-weight:normal;">
                                <?
                                $device_my = mysqli_query($con, $device_sql);

                                $dd_val = '
                                <select name="device">
                                    <option value=""></option>';
                                    while ($device_myarray = mysqli_fetch_array($device_my)) {
                                        $dd_val .= '
                                            <option value="'.st($device_myarray['deviceid']).'"';
                                            if ($device == st($device_myarray['deviceid'])) {
                                                $dd_val .= '" selected"';
                                            }
                                            $dd_val .= '>
                                                '.st($device_myarray['device']).'
                                            </option>';
                                    }
                                    $dd_val .= '
                                </select>';

                                $p_text = str_replace('*PAT*', '<b>'.$fullname.'</b>', st($plan_text_myarray['plan_text']));
                                $p_text = str_replace('*DD*', $dd_val, $p_text);
                                echo $p_text;
                                ?>
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
                            Additional Paragraph
                            /
                            <button onclick="loadPopup('select_custom_all.php?fr=ex_page8frm&tx=additional_paragraph_followup'); getElementById('popupContact').style.top = '800px'; return false;">Custom Text</button>
                        </label>
                        <div>
                            <span>
                                <textarea name="additional_paragraph_followup" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_followup;?></textarea>
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
                            Patient Referral
                        </label>
                        <div>
                            <span>
                                <input type="checkbox" name="plan_enable_referral" onclick="showMe2('referring')" value="Yes" <?php if($plan_enable_referral == "Yes"){ echo "checked=\"checked\""; } ?>>&nbsp; &nbsp;
                              We are referring this patient to:<br />
                                <textarea name="referring" id="referring" class="field text addr tbox" style="width:650px; height:100px;<?php if($plan_enable_referral != "Yes"){ echo "display:none;"; } ?>"><?=$referring;?></textarea>
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
                            Additional Paragraph
                            /
                            <button onclick="loadPopup('select_custom_all.php?fr=ex_page8frm&tx=additional_paragraph_referral'); getElementById('popupContact').style.top = '1000px'; return false;">Custom Text</button>
                        </label>
                        <div>
                            <span>
                                <textarea name="additional_paragraph_referral" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_referral;?></textarea>
                            </span>
                        </div>
                        <br />
                    </li>
                </ul>
            </td>
        </tr>
    </table>

    <div align="right">
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
<?php include "includes/form_bottom.htm";?>
<br />

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php include __DIR__ . '/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<?php include "includes/bottom.htm";?>
