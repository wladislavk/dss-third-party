<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once('includes/patient_info.php');

$db = new Db();
$baseTable = 'dental_q_page1_pivot';
$baseSearch = [
    'patientid' => '$patientId',
    'docid' => '$docId',
];

$secondaryTables = [
    'dental_q_sleep_pivot' => ['patientid' => '$patientId'],
    'dental_thorton_pivot' => ['patientid' => '$patientId'],
];

$canBackup = false;

/**
 * Define $patientId, $docId, $userId, $adminId
 * Define $isHistoricView, $historyId, $snapshotDate
 * Define $historyTable, $sourceTable
 * Define $isCreateNew, $isBackupTable
 *
 * Backup tables as needed
 */
require_once __DIR__ . '/includes/form-backup-setup.php';

if ($patient_info) { ?>
    <script type="text/javascript" src="/manage/js/q_sleep.js?v=20171219"></script>
    <?php
    if (!$isHistoricView && isset($_POST['q_sleepsub']) && $_POST['q_sleepsub'] == 1) {
        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
        $epworth_my = $db->getResults($epworth_sql);

        $epworth_arr = '';
        if ($epworth_my) {
            foreach ($epworth_my as $epworth_myarray) {
                if ($_POST['epworth_'.$epworth_myarray['epworthid']] != '') {
                    $epworth_arr .= $epworth_myarray['epworthid'].'|'.$_POST['epworth_'.$epworth_myarray['epworthid']].'~';
                }
            }
        }

        $analysis = $_POST['analysis'];
        $snore_1 = $_POST['snore_1'];
        $snore_2 = $_POST['snore_2'];
        $snore_3 = $_POST['snore_3'];
        $snore_4 = $_POST['snore_4'];
        $snore_5 = $_POST['snore_5'];
        $tot_score = $_POST['tot_score'];

        if ($_POST['ed'] == '') {
            $ins_sql = "insert into dental_q_sleep set 
                patientid = '$patientId',
                epworthid = '".s_for($epworth_arr)."',
                analysis = '".s_for($analysis)."',
                userid = '$userId',
                docid = '$docId',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
            $db->query($ins_sql);

            $ins_sql = "insert into dental_thorton set 
                patientid = '".s_for($_GET['pid'])."',
                snore_1 = '".s_for($snore_1)."',
                snore_2 = '".s_for($snore_2)."',
                snore_3 = '".s_for($snore_3)."',
                snore_4 = '".s_for($snore_4)."',
                snore_5 = '".s_for($snore_5)."',
                tot_score = '".s_for($tot_score)."',
                userid = '$userId',
                docid = '$docId',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
            $db->query($ins_sql);

            $ess_score = 0;
            $ess_score += $_POST['epworth_1'];
            $ess_score += $_POST['epworth_2'];
            $ess_score += $_POST['epworth_3'];
            $ess_score += $_POST['epworth_4'];
            $ess_score += $_POST['epworth_5'];
            $ess_score += $_POST['epworth_6'];
            $ess_score += $_POST['epworth_7'];
            $ess_score += $_POST['epworth_8'];

            $page1_sql = "SELECT * FROM dental_q_page1_pivot WHERE patientid = '$patientId'";

            if ($db->getNumberRows($page1_sql) == 0) {
                $ed_sql = "INSERT INTO dental_q_page1 set 
                    ess = '".s_for($ess_score)."',
                    tss = '".s_for($tot_score)."',
                    patientid = '$patientId',
                    docid = '$docId'";
            } else {
                $qPage1Row = $db->getRow($page1_sql);
                $qPage1Id = $qPage1Row['q_page1id'];
                $ed_sql = "update dental_q_page1 set 
                    ess = '".s_for($ess_score)."',
                    tss = '".s_for($tot_score)."'
                    WHERE q_page1id = $qPage1Id";
            }
            $db->query($ed_sql);
            ?>
            <script type="text/javascript">
                window.location='q_page1.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ed_sql = "update dental_q_sleep set 
                epworthid = '".s_for($epworth_arr)."',
                analysis = '".s_for($analysis)."'
                where q_sleepid = '".s_for($_POST['ed'])."'";
            $db->query($ed_sql);

            $ed_sql = "update dental_thorton set 
                snore_1 = '".s_for($snore_1)."',
                snore_2 = '".s_for($snore_2)."',
                snore_3 = '".s_for($snore_3)."',
                snore_4 = '".s_for($snore_4)."',
                snore_5 = '".s_for($snore_5)."',
                tot_score = '".s_for($tot_score)."'
                where thortonid = '".s_for($_POST['ted'])."'";
            $db->query($ed_sql);

            $ess_score = 0;
            $ess_score += $_POST['epworth_1'];
            $ess_score += $_POST['epworth_2'];
            $ess_score += $_POST['epworth_3'];
            $ess_score += $_POST['epworth_4'];
            $ess_score += $_POST['epworth_5'];
            $ess_score += $_POST['epworth_6'];
            $ess_score += $_POST['epworth_7'];
            $ess_score += $_POST['epworth_8'];

            $page1_sql = "SELECT * FROM dental_q_page1_pivot WHERE patientid = '$patientId'";

            if ($db->getNumberRows($page1_sql) == 0) {
                $ed_sql = "INSERT INTO dental_q_page1 set 
                    ess = '".s_for($ess_score)."',
                    tss = '".s_for($tot_score)."',
                    patientid = '$patientId',
                    docid = '$docId'";
            } else {
                $qPage1RowSelected = $db->getRow($page1_sql);
                $qPage1IdSelected = $qPage1RowSelected['q_page1id'];
                $ed_sql = "update dental_q_page1 set 
                    ess = '".s_for($ess_score)."',
                    tss = '".s_for($tot_score)."'
                    WHERE q_page1id = $qPage1IdSelected";
            }
            $db->query($ed_sql);
            $msg = " Edited Successfully";
            ?>
            <script type="text/javascript">
                window.location = 'q_page1.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }

    $sql = "select *
        from {$secondarySourceTables['dental_thorton_pivot']}
        where patientid = '$patientId'
        $andReferenceIdConditional
        $andNullConditional";

    $myarray = $db->getRow($sql);
    $thortonid = st($myarray['thortonid']);
    $snore_1 = st($myarray['snore_1']);
    $snore_2 = st($myarray['snore_2']);
    $snore_3 = st($myarray['snore_3']);
    $snore_4 = st($myarray['snore_4']);
    $snore_5 = st($myarray['snore_5']);

    $pat_sql = "select * from dental_patients where patientid = '$patientId'";
   
    $pat_myarray = $db->getRow($pat_sql);
    if ($pat_myarray['patientid'] == '') { ?>
        <script type="text/javascript">
            window.location = 'manage_patient.php';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $sql = "select *
        from {$secondarySourceTables['dental_q_sleep_pivot']}
        where patientid = '$patientId'
        $andReferenceIdConditional
        $andNullConditional";
    $myarray = $db->getRow($sql);

    $q_sleepid = st($myarray['q_sleepid']);
    $epworthid = st($myarray['epworthid']);
    $analysis = st($myarray['analysis']);

    if ($epworthid != '') {
        $epworth_arr1 = explode('~', $epworthid);
        foreach ($epworth_arr1 as $i => $val) {
            $epworth_arr2 = explode('|', $val);
            $epid[$i] = $epworth_arr2[0];
            $epseq[$i] = isset($epworth_arr2[1]) ? $epworth_arr2[1] : '';
        }
    }
    ?>
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup2.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <a name="top"></a>
    &nbsp;&nbsp;
    <?php include "includes/form_top.htm";?>
    <br /><br>
    <div align="center" class="red">
        <b><?php echo isset($_GET['msg']) ? $_GET['msg'] : '';?></b>
    </div>
    <form id="q_sleepfrm" class="q_form" name="q_sleepfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?><?= $isHistoricView ? "&history_id=$historyId" : '' ?>" method="post">
        <input type="hidden" name="q_sleepsub" value="1" />
        <input type="hidden" name="ed" value="<?php echo $q_sleepid;?>" />
        <input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />

        <div align="right">
            <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
            <input type="submit" name="q_sleepbtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
            &nbsp;&nbsp;&nbsp;
        </div>
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td valign="top" class="frmhead"></td>
            </tr>
            <tr>
                <td valign="top" class="frmhead" style="text-align:center;">
                    <table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center" id="epworth-sleep-questionnaire">
                        <tr bgcolor="#FFFFFF">
                            <td>
                                <br />
                                <span class="admin_head">
                                    Epworth Sleep Questionnaire
                                </span>
                                <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                                    <tr>
                                        <td valign="top" colspan="2" >
                                            Using the following scale, choose the most appropriate number for each situation.
                                            <br />
                                            0 = No chance of dozing<br />
                                            1 = Slight chance of dozing<br />
                                            2 = Moderate chance of dozing<br />
                                            3 = High chance of dozing<br />
                                        </td>
                                    </tr>
                                    <?php
                                    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
                                    $epworth_my = $db->getResults($epworth_sql);
                                    foreach ($epworth_my as $epworth_myarray) {
                                        if (@array_search($epworth_myarray['epworthid'], $epid) === false) {
                                            $chk = '';
                                        } else {
                                            $chk = $epseq[@array_search($epworth_myarray['epworthid'], $epid)];
                                        } ?>
                                        <tr>
                                            <td valign="top" width="60%" class="frmhead">
                                                <?php echo st($epworth_myarray['epworth']);?><br />&nbsp;
                                            </td>
                                            <td valign="top" class="frmdata">
                                                <select id="epworth_<?php echo st($epworth_myarray['epworthid']);?>" name="epworth_<?php echo st($epworth_myarray['epworthid']);?>" class="field text addr tbox" style="width:125px;" onchange="cal_analaysis(this.value);">
                                                    <option value="0" <?php if ($chk == '0') echo " selected";?>>0</option>
                                                    <option value="1" <?php if ($chk == 1) echo " selected";?>>1</option>
                                                    <option value="2" <?php if ($chk == 2) echo " selected";?>>2</option>
                                                    <option value="3" <?php if ($chk == 3) echo " selected";?>>3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php
                                    } ?>
                                    <tr>
                                        <td colspan="2">
                                            <span style="color:#000000; padding-top:0;">
                                                Analysis
                                            </span>
                                            <br />
                                            <textarea name="analysis" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $analysis;?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top" class="frmhead" style="text-align:center;">
                    <table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center" id="thornton-snoring-scale">
                        <tr bgcolor="#FFFFFF">
                            <td>
                                <br />
                                <span class="admin_head">
                                    Thornton Snoring Scale
                                </span>
                                <br />
                                <br />
                                <input type="hidden" name="thortonsub" value="1" />
                                <input type="hidden" name="ted" value="<?php echo $thortonid;?>" />
                                <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                                    <tr>
                                        <td valign="top" colspan="2" >
                                            Using the following scale, choose the most appropriate number for each situation.
                                            <br />
                                            0 = Never<br />
                                            1 = Infrequently (1 night per week)<br />
                                            2 = Frequently (2-3 nights per week)<br />
                                            3 = Most of the time (4 or more nights)<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="60%" class="frmhead">
                                            1. My snoring affects my relationship with my partner:
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <select name="snore_1" onchange="cal_snore()" class="tbox" style="width:80px;">
                                                <option value="0" <?php if ($snore_1 == 0) echo " selected";?>>0</option>
                                                <option value="1" <?php if ($snore_1 == 1) echo " selected";?>>1</option>
                                                <option value="2" <?php if ($snore_1 == 2) echo " selected";?>>2</option>
                                                <option value="3" <?php if ($snore_1 == 3) echo " selected";?>>3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="frmhead">
                                            2. My snoring causes my partner to be irritable or tired:
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <select name="snore_2" onchange="cal_snore()" class="tbox" style="width:80px;">
                                                <option value="0" <?php if ($snore_2 == 0) echo " selected";?>>0</option>
                                                <option value="1" <?php if ($snore_2 == 1) echo " selected";?>>1</option>
                                                <option value="2" <?php if ($snore_2 == 2) echo " selected";?>>2</option>
                                                <option value="3" <?php if ($snore_2 == 3) echo " selected";?>>3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="frmhead">
                                            3. My snoring requires us to sleep in separate rooms:
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <select name="snore_3" onchange="cal_snore()" class="tbox" style="width:80px;">
                                                <option value="0" <?php if ($snore_3 == 0) echo " selected";?>>0</option>
                                                <option value="1" <?php if ($snore_3 == 1) echo " selected";?>>1</option>
                                                <option value="2" <?php if ($snore_3 == 2) echo " selected";?>>2</option>
                                                <option value="3" <?php if ($snore_3 == 3) echo " selected";?>>3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="frmhead">
                                            4. My snoring is loud:
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <select name="snore_4" onchange="cal_snore()" class="tbox" style="width:80px;">
                                                <option value="0" <?php if ($snore_4 == 0) echo " selected";?>>0</option>
                                                <option value="1" <?php if ($snore_4 == 1) echo " selected";?>>1</option>
                                                <option value="2" <?php if ($snore_4 == 2) echo " selected";?>>2</option>
                                                <option value="3" <?php if ($snore_4 == 3) echo " selected";?>>3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="frmhead">
                                            5. My snoring affects people when I am sleeping away from home:
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <select name="snore_5" onchange="cal_snore()" class="tbox" style="width:80px;">
                                                <option value="0" <?php if ($snore_5 == 0) echo " selected";?>>0</option>
                                                <option value="1" <?php if ($snore_5 == 1) echo " selected";?>>1</option>
                                                <option value="2" <?php if ($snore_5 == 2) echo " selected";?>>2</option>
                                                <option value="3" <?php if ($snore_5 == 3) echo " selected";?>>3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="frmhead">
                                            Your Score:
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <input type="text" name="tot_score" value="0" class="tbox" style="width:80px;" readonly="readonly" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="frmdata" colspan="2" style="text-align:right;">
                                            <b>A score of 5 or greater indicates your snoring may be significantly affecting your quality of life.  </b>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div align="right">
            <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
            <input type="submit" name="q_pagebtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>

    <br />
    <?php include "includes/form_bottom.htm";?>
    <br />
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
    echo "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}
?>
<?php include "includes/bottom.htm"; ?>
