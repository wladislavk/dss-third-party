<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include_once 'admin/includes/general.htm';

$db = new Db();

if (!empty($_POST['q_sleepsub']) && $_POST['q_sleepsub'] == 1) {
    $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
    $epworth_my = $db->getResults($epworth_sql);
    foreach ($epworth_my as $epworth_myarray) {
        if ($_POST['epworth_'.$epworth_myarray['epworthid']] != '') { ?>
            <script type="text/javascript">
                parent.update_ess('epworth_<?php echo $_REQUEST['id']; ?>_<?php echo $epworth_myarray['epworthid']; ?>', '<?php echo $_POST['epworth_'.$epworth_myarray['epworthid']]; ?>');
            </script>
            <?php
        }
    }

    $ess_score = 0;
    foreach ($_POST as $index => $value) {
        if (preg_match('/^epworth_\d+$/', $index)) {
            $ess_score += intval($value);
        }
    }
    ?>
    <script type="text/javascript">
        parent.update_ess_total('<?php echo $_REQUEST['id']; ?>', '<?php echo $ess_score; ?>');
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql);

if (empty($pat_myarray['patientid'])) { ?>
    <script type="text/javascript">
        window.location = 'manage_patient.php';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$sql = "select * from dental_q_sleep_pivot where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarray = $db->getRow($sql);

$epworthid = st($myarray['epworthid']);

if ($epworthid != '') {
    $epworth_arr1 = explode('~', $epworthid);
    foreach($epworth_arr1 as $i => $val)
    {
        $epworth_arr2 = explode('|', $val);
        $epid[$i] = $epworth_arr2[0];
        $epseq[$i] = (!empty($epworth_arr2[1]) ? $epworth_arr2[1] : '');
    }
} ?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/manage/script/autocomplete.js?v=20160719"></script>
<script type="text/javascript" src="/manage/js/q_sleep.js"></script>
<script type="text/javascript" src="admin/popup/popup2.js"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />

<form id="q_sleepfrm" name="q_sleepfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&id=<?php echo (!empty($_GET['id']) ? $_GET['id'] : ''); ?>" method="post">
    <input type="hidden" name="q_sleepsub" value="1" />
    <div align="right">
        <input type="submit" name="q_sleepbtn" value="Save" />
        &nbsp;&nbsp;&nbsp;
    </div>
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td valign="top" class="frmhead" style="text-align:center;">
                <table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
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
                                    $a_sql = "SELECT answer 
                                        FROM dentalsummfu_ess
                                        WHERE epworthid='".$epworth_myarray['epworthid']."' 
                                        AND followupid='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."';";
                                    $a = $db->getRow($a_sql);
                                    $chk = $a['answer']; ?>
                                    <tr>
                                        <td valign="top" width="60%" class="frmhead">
                                            <?php echo st($epworth_myarray['epworth']);?><br />&nbsp;
                                        </td>
                                        <td valign="top" class="frmdata">
                                            <select id="epworth_<?php echo st($epworth_myarray['epworthid']);?>" name="epworth_<?php echo st($epworth_myarray['epworthid']);?>" class="field text addr tbox" style="width:125px;" onchange="cal_analaysis(this.value);">
                                                <option value="0" <? if ($chk == '0') echo " selected";?>>0</option>
                                                <option value="1" <? if ($chk == 1) echo " selected";?>>1</option>
                                                <option value="2" <? if ($chk == 2) echo " selected";?>>2</option>
                                                <option value="3" <? if ($chk == 3) echo " selected";?>>3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <script type="text/javascript">
                                        v = parent.top.$('#epworth_<?php echo $_GET['id'];?>_<?php echo st($epworth_myarray['epworthid']);?>').val();
                                        $('#epworth_<?php echo st($epworth_myarray['epworthid']);?>').val(v);
                                    </script>
                                    <?php
                                } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div align="right">
        <input type="submit" name="q_pagebtn" value="Save" />
        &nbsp;&nbsp;&nbsp;
    </div>
</form>
